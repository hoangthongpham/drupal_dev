<?php
/**
 * @file
 * Contains support form for miniOrange 2FA Login
 *     Module.
 */

namespace Drupal\miniorange_2fa\Form;

use Drupal\Core\Config\Config;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\miniorange_2fa\MoAuthUtilities;
use Drupal\user\Entity\Role;
use Drupal\user\Entity\User;
use Drupal\Core\Url;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Database\Connection;
use Drupal\miniorange_2fa\Helper\FormHelper\MoAuthTitle;

class MoAuthUserManagement extends FormBase
{
    private ImmutableConfig $config;
    private Config $config_factory;
    private Request $request;
    private Connection $connection;

  public function __construct() {
    $this->config_factory = \Drupal::configFactory()->getEditable('miniorange_2fa.settings');
    $this->config = \Drupal::config('miniorange_2fa.settings');
    $this->request = \Drupal::request();
    $this->connection = \Drupal::database();
  }

    public function getFormId()
    {
        return 'miniorange_2fa_user_management';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        global $base_url;
        $utilities = new MoAuthUtilities();

      $title = [
        'name'        => t('User Management'),
        'description' => t( 'You can manage 2FA for the end user accounts from this tab. Please note that the user has to setup the 2FA again upon next login.' ),
      ];
      MoAuthTitle::buildTitleForm($form, $form_state, $title);


        $disabled = FALSE;
        if (!$utilities::isCustomerRegistered()) {
            $form['header'] = array(
                '#markup' => t('<div class="mo_2fa_register_message"><p>' . t('You need to') . ' <a href="' . $base_url . '/admin/config/people/miniorange_2fa/customer_setup">' . t('Register/Login') . '</a> ' . t('with miniOrange before using this module.') . '</p></div>'),
            );
            $disabled = True;
        }

        $form['markup_library'] = array(
            '#attached' => array(
                'library' => array(
                    "miniorange_2fa/miniorange_2fa.admin",
                    "miniorange_2fa/miniorange_2fa.license",
                    "core/drupal.dialog.ajax",
                )
            ),
        );

        /**
         * Create container to hold all the form elements.
         */
        $form['mo_user_management'] = array(
            '#type' => 'fieldset',
            '#attributes' => array('style' => 'padding:0% 2% 17%'),
            '#disabled' => $disabled,
        );

        $form['mo_user_management']['filter_fieldset'] = array(
          '#type' => 'fieldset',
        );

        $form['mo_user_management']['filter_fieldset'] ['username'] = array(
          '#type' => 'search',
          '#title' => $this->t('Name or email contains'),
          '#size' => 30,
          '#default_value' => $this->getUsername(),
          '#attributes' => array('class' => ['mo_2fa_horizontal_form']),
          '#prefix' => '<div class="container-inline">',
          '#suffix' => '&nbsp;',
        );

        $form['mo_user_management']['filter_fieldset'] ['no_of_rows'] = array(
          '#title' => $this->t('Items per page'),
          '#type' => 'number',
          '#min' => 5,
          '#default_value' =>  $this->config->get('mo_user_management_pages') ?? 10,
          '#attributes' => array('class' => ['mo_2fa_horizontal_form']),
           '#suffix' => '&nbsp;',
        );



        $form['mo_user_management']['filter_fieldset'] ['role'] = array(
          '#type' => 'select',
          '#title' => $this->t('Roles'),
          '#options' => $this->getUserRoles(),
          '#default_value' => $this->getDefaultRole(),
          '#attributes' => array('class' => ['mo_2fa_horizontal_form']),
          '#suffix' => '&nbsp;',
        );

        $form['mo_user_management']['filter_fieldset'] ['status'] = array(
          '#type' => 'select',
          '#title' => $this->t('2FA Status'),
          '#options' => [
            'any' => $this->t('- Any -'),
            'disabled' => $this->t('Disabled'),
            'enabled' => $this->t('Enabled'),
          ],
          '#default_value' => $this->getDefaultStatus(),
          '#attributes' => array('class' => ['mo_2fa_horizontal_form']),
          '#suffix' => '&nbsp;',
        );

        $form['mo_user_management']['filter_fieldset'] ['filter_button'] = array(
          '#type' => 'submit',
          '#value' => $this->t('Filter'),
        );

        if($this->showResetButton()) {
          $form['mo_user_management']['filter_fieldset'] ['reset_button'] = [
            '#type' => 'submit',
            '#value' => $this->t('Reset'),
            '#submit' => ['::resetFilter'],
            '#suffix' => '</div>',
          ];
        }

        if(!$disabled) {
          $result = $this->getUserList($this->getUsername()) ?? new stdClass();
          $empty_table = 'No people available.';
        }
        else {
          $result = new stdClass();
          $empty_table = 'Register/Login with miniOrange to use this feature';
        }
        $header = [
          'user_id'    => $this->t('User ID'),
          'username'   => $this->t('Username'),
          'user_email' => $this->t('User Email'),
          'phone'      => $this->t('Phone No'),
          'roles'      => $this->t('User Roles'),
          '2fa_method' => $this->t('2FA Method'),
          '2fa_status' => $this->t('2FA Status'),
          '2fa_action' => $this->t('Action'),
        ];

        if(!empty(json_decode(json_encode($result), true))) {
            $form['mo_user_management']['total_users'] = array(
                '#markup' => t('Total Users: ') . count($result),
            );
        }

        $form['mo_user_management']['user_management_table'] = array(
          '#type' => 'tableselect',
          '#header' => $header,
          '#empty' => $this->t($empty_table),
          );

        $row_number=0;
        foreach ($result as $row) {
          $user = User::load($row->uid);
          $form['mo_user_management']['user_management_table']['#options'][$row->uid]['user_id'] = ['#markup' => $row->uid];
          $form['mo_user_management']['user_management_table']['#options'][$row->uid]['username'] = ['#markup' => $user->getAccountName()];
          $form['mo_user_management']['user_management_table']['#options'][$row->uid]['user_email'] = ['#markup' =>$row->miniorange_registered_email];
          $form['mo_user_management']['user_management_table']['#options'][$row->uid]['phone'] = ['#markup' =>empty($row->phone_number) ? '-' : $row->phone_number];
          $form['mo_user_management']['user_management_table']['#options'][$row->uid]['roles'] = ['#markup' => $this->getUserRoles($user->getRoles())];
          $form['mo_user_management']['user_management_table']['#options'][$row->uid]['2fa_method'] = ['#markup' =>$row->activated_auth_methods];
          $form['mo_user_management']['user_management_table']['#options'][$row->uid]['2fa_status'] = ['#markup' =>$row->enabled ? 'Enabled' : 'Disabled'];
          $form['mo_user_management']['user_management_table']['#options'][$row->uid]['2fa_action']['data'] = [
            '#type' => 'dropbutton',
            '#dropbutton_type' => 'extrasmall',
            '#links' => array(
              'disable' => array(
                'title' => !$row->enabled ? $this->t('Enable' ): $this->t('Disable'),
                'url'  => Url::fromRoute('miniorange_2fa.changes_2fa_status', array('user' => $row->uid, 'enabled' => $row->enabled)),
              ),
              'reset' => array(
                'title' => $this->t('Reset'),
                'url' => Url::fromRoute('miniorange_2fa.reset_2fa', array('user' => $row->uid )),
              ),
            ),
          ];
          $row_number++;
        }

      $form['mo_user_management']['pager'] = array(
        '#type' => 'pager',
      );

      // Define a bulk operations' dropdown.
      $form['mo_user_management']['mo_2fa_bulk_operation'] = [
        '#type' => 'select',
        '#title' => $this->t('Bulk operations'),
        '#options' => [
          'reset' => $this->t('Reset 2FA'),
          'enable' => $this->t('Enable 2FA'),
          'disable' => $this->t('Disable 2FA')
        ],
        '#empty_option' => $this->t('- Select -'),
        '#prefix' => '<div class="views-bulk-actions"><div class="views-bulk-actions__item">',
        '#suffix' => '</div>',
      ];


      $form['mo_user_management']['actions']['#type'] = 'actions';
      $form['mo_user_management']['actions']['bulk_submit'] = array(
        '#type' => 'submit',
        '#button_type' => 'small',
        '#value' => $this->t('Bulk Action'),
        '#prefix' => '<div class="views-bulk-actions__item">',
        '#suffix' => '</div></div>',
      );

      return $form;
    }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $clicked_element = $form_state->getTriggeringElement()['#id'];

    if($clicked_element == 'edit-bulk-submit'){
      $this->updateUser2faBulkOperation($form, $form_state);
    } else{
      $number_of_rows = $form_state->getValue('no_of_rows');
      if (!empty($number_of_rows)) {
        $this->config_factory->set('mo_user_management_pages', $number_of_rows)->save();
      }
      $username  = trim($form_state->getValue('username'));
      $role      = $form_state->getValue('role');
      $status    = $form_state->getValue('status');

      $form_state->setRedirect('miniorange_2fa.user_management',[],[
        'query' => [
          'username' => $username,
          'role' => $role,
          'status' => $status
        ],
      ]);
    }
  }

  /**
   * Function to set batch for bulk operation
   *
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *
   * @return void
   */
  public static function updateUser2faBulkOperation(array &$form, FormStateInterface $form_state) {

    $selected_operation = $form_state->getValue('mo_2fa_bulk_operation');
    $selected_values = $form_state->getValue('user_management_table');

    $batch = [
      'title' => t('Processing bulk operations...'),
      'operations' => [],
      'finished' => 'Drupal\miniorange_2fa\Form\MoAuthUserManagement::mo2faBulkOperationFinished',
    ];

    $batch_size = '10';
    $batches = array_chunk($selected_values, $batch_size);
    $num_batch = count($batches);

    for ($batch_id=0; $batch_id < $num_batch; $batch_id++) {
      $batch['operations'][] = array(
        'Drupal\miniorange_2fa\Form\MoAuthUserManagement::mo2faProcessBulkOperation',
        [
          $selected_operation,
          $batch_id+1,
          $batches[$batch_id]]
      );
    }

    batch_set($batch);
  }

  /**
   * Function run after bulk operation for users is completed.
   *
   * @param $success boolean true if batch runs successfully
   * @param $results array results set in the batch operation
   * @param $operations
   *
   * @return void
   */
  public static function mo2faBulkOperationFinished($success, $results, $operations){

    if ($success) {
      if($results['skipped']){
        \Drupal::messenger()->addMessage(t('@count items skipped.', array('@count' => $results['skipped'])));
      }
      if(!empty($results['progress'])){
        \Drupal::messenger()->addMessage(t('@count items successfully processed.', array('@count' => $results['progress'])));
      }
    }
    else {
      // $operations contains the operations that remained unprocessed.
      $error_operation = reset($operations);
      $message = t('An error occurred while processing %error_operation with arguments: @arguments', array('%error_operation' => $error_operation[0], '@arguments' => print_r($error_operation[1], TRUE)));
      \Drupal::messenger()->addMessage($message, 'error');
    }
  }

  /**
   * @param $selected_operation
   * @param $batch_id
   * @param $uids
   * @param $context
   *
   * @return void
   */
  public static function mo2faProcessBulkOperation ( $selected_operation, $batch_id, $uids, &$context) {

    if (!isset($context['results']['progress'])) {
      $context['results']['skipped'] = 0;
      $context['results']['progress'] = 0;
    }
    //remove anonymous user
    $uids = array_diff( $uids, [0]);
    if(empty($uids)){
      \Drupal::messenger()->addError(t("Please select a user"));
      return;
    }

    // Keep track of progress.
    $context['results']['progress'] += count($uids);
    switch($selected_operation) {
      case 'reset':
        foreach ($uids as $uid) {
          $user = User::load($uid);
          $userID = $user->id();
          $username = $user->getAccountName();

          $context['results']['process'] = 'Reset Users 2FA';
          $variables_and_values = array(
            'mo_auth_firstuser_id',
          );
          $current_user = \Drupal::currentUser();
          $current_user = $current_user->getAccountName();
          $mo_db_values = MoAuthUtilities::miniOrange_set_get_configurations($variables_and_values, 'GET');

          if (isset($mo_db_values['mo_auth_firstuser_id']) && $mo_db_values['mo_auth_firstuser_id'] == $userID) {
            $message = t("@current_user tried to reset the 2FA of @username", array('@current_user' => $current_user, '@username' => $username));
            \Drupal::logger('miniorange_2fa')->warning($message);
            \Drupal::messenger()->addError(t("You can not reset 2FA for @username account. Because this account has been used to activate/setup the module.", ['@username' => $username]));
            $context['results']['skipped']++;
          } else {
            $message = t("@current_user reset the 2FA of @username", array('@current_user' => $current_user, '@username' => $username));
            \Drupal::logger('miniorange_2fa')->info($message);
            MoAuthUtilities::delete_user_from_UserAuthentication_table($user);
          }
        }
        break;
      case 'enable':
        $context['results']['process'] = 'Enable 2FA for Users';

        MoAuthUtilities::update_user_status_from_UserAuthentication_table($uids,0);
        break;
      case 'disable':
        $context['results']['process'] = 'Disable 2FA for Users';
        MoAuthUtilities::update_user_status_from_UserAuthentication_table($uids,1);
        break;
    }
    \Drupal::logger('miniorange_2fa')->info('<code>mo2faProcessBulkOperation</code> was successfully executed.');
  }

    public function getUsername() {
      $username = $this->request->get('username');
      return empty($username) ? null : $username;
    }

    public function getDefaultStatus() {
      $status = $this->request->get('status');
      return is_null($status) ? 'any' : $status;
    }

    public function getDefaultRole() {
      $role = $this->request->get('role');
      return is_null($role) ? 'any' : $role;
    }

    public function resetFilter() {
      global $base_url;
      $this->config_factory->set('mo_user_management_pages', 10)->save();
      $response = new RedirectResponse($base_url.'/admin/config/people/miniorange_2fa/user_management');
      $response->send();
    }

   /**
    * Important function which actually filter the data
    */
    public function getUserList($username) {
      $role          = $this->request->get('role');
      $status        = $this->request->get('status');
      $filter_role   = true;
      $filter_status = true;

      if (is_null($role) || $role == 'any') {
        $filter_role = false;
      }

      if (is_null($status) || $status == 'any') {
        $filter_status = false;
      }

      $status = $status == 'enabled' ? 1 :0;

      if($filter_status && $filter_role) {
        return $this->filterBasedOnStatusAndRoles($status, $role, $username);
      } elseif($filter_status) {
        return $this->filterBasedOnStatus($status,$username);
      } elseif($filter_role) {
        return $this->filterBasedOnRoles($role, $username);
      }
      return $this->filterBasedOnUsername($username);
    }

    public function filterBasedOnStatus(string $status, $username) {
      try {
        $query = $this->getNameOrEmailFilter($username);
        $query->condition('enabled' ,$status, '=');
        return $query->orderBy('created', 'ASC')
          ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
          ->limit($this->config->get('mo_user_management_pages') ?? 5)
          ->execute()
          ->fetchAll();
      }
      catch (\Exception $exception) {
        $this->handleException($exception);
      }
    }

    public function filterBasedOnRoles(string $role, $username) {
      try {
        $uid   = $this->userIdForRoleFilter($role, $username );
        $query = $this->connection->select('UserAuthenticationType', 'u')
          ->fields('u')
          ->condition('uid', $uid, 'IN');

        return $query->orderBy('uid', 'ASC')
          ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
          ->limit($this->config->get('mo_user_management_pages') ?? 10)
          ->execute()
          ->fetchAll();
      }
      catch (\Exception $exception) {
        $this->handleException($exception);
      }

    }

    public function filterBasedOnStatusAndRoles(string $status, string $role, $username) {
      try {
        $uid = $this->userIdForRoleFilter($role, $username);
        $query = $this->connection->select('UserAuthenticationType', 'u')
          ->fields('u');
        $statusAndRoles = $query->andConditionGroup()
          ->condition('uid', $uid, 'IN')
          ->condition('enabled', $status, '=');
        $query->condition($statusAndRoles);
        return $query->orderBy('uid', 'ASC')
          ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
          ->limit($this->config->get('mo_user_management_pages') ?? 10)
          ->execute()
          ->fetchAll();
      }
      catch (\Exception $exception) {
        $this->handleException($exception);
      }
    }

    public function filterBasedOnUsername($username) {
      try {
        $query = $this->getNameOrEmailFilter($username);
        return $query->orderBy('created', 'ASC')
          ->extend('Drupal\Core\Database\Query\PagerSelectExtender')
          ->limit($this->config->get('mo_user_management_pages') ?? 10)
          ->execute()
          ->fetchAll();
      }
      catch (\Exception $exception) {
        $this->handleException($exception);
      }
    }

    public function getNameOrEmailFilter($username) {
      try {
        $query = $this->connection->select('UserAuthenticationType', 'u');
        $query->Join('users_field_data','udata','u.uid = udata.uid');
        $query->fields('u')->fields('udata');

        if (!is_null($username)){
          $emailOrUsername = $query->orConditionGroup()
            ->condition('name', '%' . $username . '%', 'LIKE' )
            ->condition('miniorange_registered_email', '%' . $username . '%', 'LIKE');
          $query->condition($emailOrUsername);
        }
        return $query;
      }
      catch (\Exception $exception) {
        $this->handleException($exception);
      }
    }

    public function getUserRoles(array $row_numberd=null) {
      $roles = Role::loadMultiple($row_numberd);
      $roles_array = [
        'any' => '- Any -',
      ];
      foreach ($roles as $key => $value) {
        $roles_array[$key] = $value->label();
      }

      if(isset($roles_array['authenticated'])) {
        unset($roles_array['authenticated']);
      }

      if(isset($roles_array['anonymous'])) {
        unset($roles_array['anonymous']);
      }

      if($row_numberd!=null) {
        unset($roles_array['any']);
        $string = '<ul>';
        foreach ($roles_array as $roles) {
          $string .= '<li>'.$roles.'</li>';
        }
        $string .= '</ul>';
        return Markup::create($string);
      }

      return $roles_array;
    }

    public function userIdForRoleFilter(string $role,$username) {
      $role_uid = [0];
      $user_uid = [0];
      try {
        $roles = $this->connection->select('user__roles', 'role')
          ->fields('role', ['entity_id', 'roles_target_id'])
          ->condition('roles_target_id',$role,'=')
          ->execute()
          ->fetchAll();

        foreach ($roles as $role) {
          $role_uid[] = $role->entity_id;
        }

        $role_uid = array_unique($role_uid);

        if(!is_null($username)) {
          $users = $this->connection->select('users_field_data', 'udata')->fields('udata');
          $emailOrUsername = $users->orConditionGroup()
            ->condition('name', '%' . $username . '%', 'LIKE' )
            ->condition('mail', '%' . $username . '%', 'LIKE');
          $result = $users->condition($emailOrUsername)->execute()->fetchAll();

          foreach ($result as $user) {
            $user_uid[] = $user->uid;
          }

          $role_uid =  array_intersect($user_uid, $role_uid);
        }
          return $role_uid;
      }
      catch (\Exception $exception) {
        $this->handleException($exception);
      }
    }

    public function handleException($exception) {
      MoAuthUtilities::mo_add_loggers_for_failures($exception, 'error');
      \Drupal::messenger()->addError('Something went wrong while filtering your data. Please see recent log for details.');
      return null;
    }

    public function showResetButton() {
      $username       = $this->getUsername();
      $status         = $this->getDefaultStatus();
      $role           = $this->getDefaultRole();
      $number_of_rows = $this->config->get('mo_user_management_pages') ;

      if(is_null($username) && ($status=='any') && ($role=='any') && ($number_of_rows==10)) {
        return false;
      }
      else {
        return true;
      }
    }

}
