<?php
/**
 * @file
 * Contains form for customer setup.
 */

namespace Drupal\miniorange_2fa\Form;

use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\Core\Render\Markup;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\miniorange_2fa\MiniorangeUser;
use Drupal\miniorange_2fa\UsersAPIHandler;
use Drupal\miniorange_2fa\MoAuthUtilities;
use Drupal\miniorange_2fa\MoAuthConstants;
use Drupal\miniorange_2fa\AuthenticationType;
use Drupal\miniorange_2fa\MiniorangeCustomerSetup;
use Drupal\miniorange_2fa\MiniorangeCustomerProfile;
use Drupal\miniorange_2fa\Helper\FormHelper\MoAuthTitle;
use Drupal\miniorange_2fa\Helper\MoUserUtility;

/**
 * Customer setup form().
 */
class MoAuthCustomerSetup extends FormBase {

	public function getFormId() {
		return 'miniorange_2fa_customer_setup';
	}

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        global $base_url;
        $user_obj = User::load(\Drupal::currentUser()->id());
        $user_id = $user_obj->id();
        $current_status = \Drupal::config('miniorange_2fa.settings')->get('mo_auth_status');

      $title = [
          'name'        => t('Register/Login'),
          'description' => t('Register/Login with your miniOrange account.'),
        ];
      MoAuthTitle::buildTitleForm($form, $form_state, $title);
      $form['markup_library'] = array(
        '#attached' => array(
          'library' => array(
            'miniorange_2fa/miniorange_2fa.license',
            "miniorange_2fa/miniorange_2fa.admin",
            "core/drupal.dialog.ajax",
          ),
        ),
      );

      if ($current_status == 'PLUGIN_CONFIGURATION') {

          $utilities = new MoAuthUtilities();
          $custom_attribute = $utilities::get_users_custom_attribute($user_id);
          $user_email = isset($custom_attribute[0]) && is_object($custom_attribute[0]) ? $custom_attribute[0]->miniorange_registered_email : '-';
          $customer = new MiniorangeCustomerProfile();
          $user_api_handler = new UsersAPIHandler($customer->getCustomerID(), $customer->getAPIKey());
          $miniorange_user = new MiniorangeUser($customer->getCustomerID(), $user_email, '', '', '');
          $response = $user_api_handler->get($miniorange_user);
          $authType = AuthenticationType::getAuthType(is_object($response) && $response->status != 'FAILED' ? $response->authType : '-');

          $variables_and_values = array(
              'mo_user_limit_exceed',
              'mo_auth_customer_admin_email',
              'mo_auth_customer_id',
              'mo_auth_customer_api_key',
              'mo_auth_customer_token_key',
              'mo_auth_customer_app_secret',
              'mo_auth_2fa_license_type',
              'mo_auth_2fa_license_plan',
              'mo_auth_2fa_license_no_of_users',
              'mo_auth_2fa_ivr_remaining',
              'mo_auth_2fa_sms_remaining',
              'mo_auth_2fa_email_remaining',
              'mo_auth_2fa_license_expiry',
              'mo_auth_2fa_support_expiry',
          );
          $mo_db_values = $utilities->miniOrange_set_get_configurations($variables_and_values, 'GET');

          $title = [
            'name'        => t('Profile'),
            'description' => t('Thank you for being a part of the miniOrange Drupal family. Find your profile details here.'),
          ];
          MoAuthTitle::buildTitleForm($form, $form_state, $title);
          $form['markup_library'] = array(
            '#attached' => array(
              'library' => array(
                'miniorange_2fa/miniorange_2fa.license',
                "miniorange_2fa/miniorange_2fa.admin",
                "core/drupal.dialog.ajax",
              ),
            ),);


        /** Show message if user creation limit exceeded */
          $mo_user_limit = $mo_db_values['mo_user_limit_exceed'];
          if (isset($mo_user_limit) && $mo_user_limit == TRUE) {
              $form['markup_top_2'] = array(
                    '#markup' => '<div class="users_2fa_limit_exceeded_message">' . t('Your user creation limit has been completed. Please upgrade your license to add more users. Please ignore if already upgraded.') . ' </div>'
                );
            }

            $form['mo_profile_information'] = array(
                '#type' => 'details',
                '#title' => t('Profile Details'),
                '#attributes' => array('style' => 'margin-bottom:2%;'),
                //'#open' => TRUE,
            );

            $mo_table_content = array(
                array('2FA Registered Email', $mo_db_values['mo_auth_customer_admin_email']),
                array('Activated 2FA Method', isset($authType['name']) ? $authType['name'] : ''),
                array('Xecurify Registered Email', $user_email),
                array('Customer ID', $mo_db_values['mo_auth_customer_id']),
                //array( 'Token Key', $mo_db_values['mo_auth_customer_token_key'] ), //TODO: Remove this after 3.08 release
                //array( 'App Secret', $mo_db_values['mo_auth_customer_app_secret'] ), //TODO: Remove this after 3.08 release
                array('Drupal Version', MoAuthUtilities::mo_get_drupal_core_version()),
                array('PHP Version', phpversion()),
            );

            $form['mo_profile_information']['miniorange_testing_form_element'] = array(
                '#type' => 'table',
                '#header' => array('ATTRIBUTE', 'VALUE'),
                '#rows' => $mo_table_content,
                '#empty' => t('Something is not right. Please run the update script or contact us at') . '<a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a>',
                '#responsive' => TRUE,
                '#sticky' => FALSE, //headers will move with the scroll
                '#size' => 2,
            );

//            $form['mo_profile_information']['miniorange_customer_Remove_Account_info'] = array(
//                '#markup' => '<br/><h3>Remove Account:</h3><p>This section will help you to remove your current logged in account without losing your current configurations.</p>'
//            );

            $form['mo_profile_information']['miniorage_remove_account'] = array(
                '#type' => 'link',
                '#title' => $this->t('Remove Account'),
                '#url' => Url::fromRoute('miniorange_2fa.modal_form'),
                '#attributes' => [
                    'class' => [
                        'use-ajax',
                        'button',
                    ],
                ],
                '#suffix' => '<br/><br/>',
            );

            $form['mo_license_information'] = array(
                '#type' => 'details',
                '#title' => t('License Info'),
                '#open' => true,
            );

            $isLicenseExpired = MoAuthUtilities::getIsLicenseExpired($mo_db_values['mo_auth_2fa_license_expiry']);

            $cron_run_interval = \Drupal::config('automated_cron.settings')->get('interval');
            $cron_run_interval = $cron_run_interval !=0 ? \Drupal::service('date.formatter')->formatInterval($cron_run_interval) : 'Never';
            $last_cron_run     = \Drupal::state()->get('system.cron_last');
            $last_cron_run     = \Drupal::service('date.formatter')->formatTimeDiffSince($last_cron_run);
            $cron_message      = MoAuthUtilities::getCronInformation();

            $NoofUsers = '';
            if (isset($mo_db_values['mo_auth_2fa_license_type']) && $mo_db_values['mo_auth_2fa_license_type'] == 'DRUPAL_2FA') {
                $NoofUsers = [
                    'data' => Markup::create('</span><a class="js-form-submit form-submit use-ajax" href="requestDemo">Explore 2FA policies for End Users</a>')
                ];
            }

            if (isset($mo_db_values['mo_auth_2fa_license_type']) && $mo_db_values['mo_auth_2fa_license_type'] == MoAuthConstants::LICENSE_TYPE) {
                $NoofUsers = [
                    'data' => Markup::create('</span><a class="js-form-submit form-submit use-ajax" href="contact_us">ADD MORE USERS</a>')
                ];
            }

            $updateLicense = '';
            if ($isLicenseExpired['LicenseGoingToExpire']) {
                $updateLicense = [
                    'data' => Markup::create('</span><a class="js-form-submit form-submit use-ajax" href="contact_us">ADD MORE USERS</a>')
                ];
            }

            $mo_license_table_content = array(
                array('License Type', $mo_db_values['mo_auth_2fa_license_type'], ''),
                array('License Plan', $mo_db_values['mo_auth_2fa_license_plan'], ''),
                array('No. of Users', $mo_db_values['mo_auth_2fa_license_no_of_users'], $NoofUsers),
            );
            $mo_license_table_content_2 = array(
                array('IVR Transactions Remaining', $mo_db_values['mo_auth_2fa_ivr_remaining'], ''),
                array('SMS Transactions Remaining', $mo_db_values['mo_auth_2fa_sms_remaining'], ''),
                array('Email Transactions Remaining', $mo_db_values['mo_auth_2fa_email_remaining'], ''),
                array('License Expiry', $mo_db_values['mo_auth_2fa_license_expiry'], $updateLicense),
                array('Support Expiry', $mo_db_values['mo_auth_2fa_support_expiry'], ''),
                array('Cron Run Interval', $cron_message, ''),
            );


            if ($mo_db_values['mo_auth_2fa_license_type'] !== 'DRUPAL_2FA') {
                $mo_license_table_content = array_merge($mo_license_table_content, $mo_license_table_content_2);
            }

            $form['mo_license_information']['miniorange_hidden_value'] = array(
                '#type' => 'hidden',
                '#value' => 'User_Logged_in',
            );

            $form['mo_license_information']['miniorange_customer-license'] = array(
                '#type' => 'table',
                '#header' => array('ATTRIBUTE', 'VALUE', 'ACTION'),
                '#rows' => $mo_license_table_content,
                '#empty' => t('Something is not right. Please run the update script or contact us at') . ' <a href="mailto:drupalsupport@xecurify.com">drupalsupport@xecurify.com</a>',
                '#responsive' => TRUE,
                '#sticky' => FALSE, //headers will move with the scroll
                '#size' => 2,
                '#prefix' => '',
                '#suffix' => '<br>',
            );

            $form['mo_license_information']['fecth_customer_license'] = array(
                '#type' => 'submit',
                '#button_type' => 'primary',
                '#value' => t('Check License'),
                '#submit' => [[new MoUserUtility(), 'moAuthFetchCustomerLicense']],
                //'#suffix' => '</div>',
            );

            if ($mo_db_values['mo_auth_2fa_license_type'] === 'DRUPAL_2FA') {
                $form['mo_license_information']['miniorage_request_demo'] = array(
                    '#type' => 'link',
                    '#title' => $this->t('Request 7 Days Trial'),
                    '#url' => Url::fromRoute('miniorange_2fa.request_demo'),
                    '#attributes' => [
                        'class' => [
                            'use-ajax',
                            'button',
                        ],
                    ],
                );
            }

            $form['mo_license_information']['markup_end'] = array(
                '#markup' => '</div>'
            );

            return $form;
        }

        $url = $base_url . '/admin/config/people/miniorange_2fa/customer_setup';
        $tab = isset($_GET['tab']) && $_GET['tab'] == 'login' ? $_GET['tab'] : 'register';

        if ($tab == 'register') {
            /**
             * Create container to hold @Register form elements.
             */
            $form['mo_register_form'] = array(
                '#type' => 'fieldset',
                '#title' => t('Create an account with miniOrange'),
                '#attributes' => array('style' => 'padding:2%;'),
            );

            $form['mo_register_form']['Mo_auth_customer_register_username'] = array(
                '#type' => 'textfield',
                '#id' => "email_id",
                '#title' => t('Email'),
                '#attributes' => array(
                    'autofocus' => 'true',
                    'style' => 'width:32%',
                ),
                '#prefix' => '<hr><br>',

                '#required' => true,
            );

            $form['mo_register_form']['Mo_auth_customer_register_password'] = array(
                '#type' => 'password_confirm',
                '#required' => true,
            );

            $form['mo_register_form']['Mo_auth_customer_register_button'] = array(
                '#type' => 'submit',
                '#value' => t('Register'),
                '#limit_validation_errors' => array(),
                '#prefix' => '<div class="ns_row"><div class="ns_name">',
                '#suffix' => '</div>'
            );

            $form['mo_register_form']['already_account_link'] = array(
                '#markup' => '<a href="' . $url . '/?tab=login" class="button button--primary"><b>' . t('Already have an account?') . '</b></a>',
                '#prefix' => '<div class="ns_value">',
                '#suffix' => '</div></div></div>'
            );
        } else {
            /**
             * Create container to hold @Login form elements.
             */

            $form['mo_login_form'] = array(
                '#type' => 'fieldset',
                '#title' => t('Login with miniOrange'),
                '#attributes' => array('style' => 'padding:2% 2% 2% 2%;'),
            );

            $form['mo_login_form']['Mo_auth_customer_login_username'] = array(
                '#type' => 'email',
                '#title' => t('Email'),
                '#attributes' => array('style' => 'width:32%'),
                '#required' => true,
                '#prefix' => '<hr><br>'
            );

            $form['mo_login_form']['Mo_auth_customer_login_password'] = array(
                '#type' => 'password',
                '#title' => t('Password'),
                '#attributes' => array('style' => 'width:32%'),
                '#required' => true,
            );

            $form['mo_login_form']['Mo_auth_customer_login_button'] = array(
                '#type' => 'submit',
                '#value' => t('Login'),
                '#limit_validation_errors' => array(),
                '#prefix' => '<br><div class="ns_row"><div class="ns_name">',
                '#suffix' => '</div>'
            );

            $form['mo_login_form']['register_link'] = array(
                '#markup' => '<a href="' . $url . '" class="button button--primary"><b>' . t('Create an account?') . '</b></a>',
                '#prefix' => '<div class="ns_value">',
                '#suffix' => '</div></div></div>'
            );
        }

//        MoAuthUtilities::miniOrange_know_more_about_2fa($form, $form_state);

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $form_values = $form_state->getValues();

        if (isset($form_values['Mo_auth_customer_register_username']) && !\Drupal::service('email.validator')->isValid(trim($form_values['Mo_auth_customer_register_username']))
            && !isset($form_values['mo_auth_customer_otp_token'])
            && !isset($form_values['Mo_auth_customer_login_username'])
            && !isset($form_values['miniorange_hidden_value'])) {
            $form_state->setErrorByName('Mo_auth_customer_register_username', $this->t('The email address is not valid.'));
        }
    }

    //Handle submit for customer setup.
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        global $base_url;
        $check_loggers = MoAuthUtilities::get_mo_tab_url('LOGS');
        $user = User::load(\Drupal::currentUser()->id());
        $user_id = $user->id();

        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'register';

        if ($tab == 'register') {
            $username = trim($form['mo_register_form']['Mo_auth_customer_register_username']['#value']);
            $phone = '';
            $password = trim($form['mo_register_form']['Mo_auth_customer_register_password']['#value']['pass1']);
        } else {
            $username = trim($form['mo_login_form']['Mo_auth_customer_login_username']['#value']);
            $password = trim($form['mo_login_form']['Mo_auth_customer_login_password']['#value']);
            $phone = '';
        }

        $customer_config = new MiniorangeCustomerSetup($username, $phone, $password);

        $check_customer_response = $customer_config->checkCustomer();
        $utilities = new MoAuthUtilities();
        if (is_object($check_customer_response) && $check_customer_response->status == 'CUSTOMER_NOT_FOUND') {
            if ($tab == 'login') {
                \Drupal::messenger()->addError(t('The account with username <strong>@username</strong> does not exist.', array('@username' => $username)));
                return;
            }
            // Create customer.
            // Store email and phone.
            $variables_and_values = array(
                'mo_auth_customer_admin_email' => $username,
                'mo_auth_customer_admin_phone' => $phone,
                'mo_auth_customer_admin_password' => $password,
            );

            $utilities->miniOrange_set_get_configurations($variables_and_values, 'SET');

            self::moAuthCreateMiniorangeUserAdmin($username,$phone, $password);

        } elseif (is_object($check_customer_response) && $check_customer_response->status == 'SUCCESS' && $check_customer_response->message == 'Customer already exists.') {
            // Customer exists. Retrieve keys.
            $customer_keys_response = $customer_config->getCustomerKeys();
            if (json_last_error() == JSON_ERROR_NONE) {
                $this->mo_auth_save_customer($user_id, $customer_keys_response, $username, $phone);
                \Drupal::messenger()->addStatus(t('Your account has been retrieved successfully.'));
            } else {
                \Drupal::messenger()->addError(t('Invalid credentials'));
                return;
            }
        } elseif (is_object($check_customer_response) && $check_customer_response->status == 'TRANSACTION_LIMIT_EXCEEDED') {
            MoAuthUtilities::mo_add_loggers_for_failures($check_customer_response->message, 'error');
            \Drupal::messenger()->addError(t('Failed to send an OTP. Please check your internet connection.') . ' <a href="' . $check_loggers . ' " target="_blank">' . t('Click here') . ' </a>' . t('for more details.'));
            return;

        } elseif (is_object($check_customer_response) && $check_customer_response->status == 'CURL_ERROR') {
            \Drupal::messenger()->addError(t('cURL is not enabled. Please enable cURL'));
            return;
        } else {
            MoAuthUtilities::mo_add_loggers_for_failures(isset($check_customer_response->message) ? $check_customer_response->message : '', 'error');
            \Drupal::messenger()->addError(t('Something went wrong, Please try again. Click <a href="' . $check_loggers . ' " target="_blank"> here </a> for more details.'));
            return;
        }
    }

    // Save MO Customer

    function mo_auth_save_customer($user_id, $json, $username, $phone)
    {

        $utilities = new MoAuthUtilities();
        $variables_and_values = array(
            'mo_auth_customer_admin_email' => $username,
            'mo_auth_customer_admin_phone' => $phone,
            'mo_auth_customer_id' => isset($json->id) ? $json->id : '',
            'mo_auth_customer_api_key' => isset($json->apiKey) ? $json->apiKey : '',
            'mo_auth_customer_token_key' => isset($json->token) ? $json->token : '',
            'mo_auth_customer_app_secret' => isset($json->appSecret) ? $json->appSecret : '',
        );
        $utilities->miniOrange_set_get_configurations($variables_and_values, 'SET');

        //Stores the user id of the user who activates the module.
        $MiniorangeUser = array(
            'mo_auth_firstuser_id' => \Drupal::currentUser()->id(),
        );
        $utilities->miniOrange_set_get_configurations($MiniorangeUser, 'SET');

        $auth_method = AuthenticationType::$EMAIL['code'] . ', ' . AuthenticationType::$EMAIL_VERIFICATION['code'];
        $available = $utilities::check_for_userID($user_id);
        $database = \Drupal::database();
        $fields = array(
            'uid' => $user_id,
            'configured_auth_methods' => $auth_method,
            'miniorange_registered_email' => $username,
        );

        if ($available == FALSE) {
            $database->insert('UserAuthenticationType')->fields($fields)->execute();
        } elseif ($available == TRUE) {
            $database->update('UserAuthenticationType')->fields(['miniorange_registered_email' => $username])->condition('uid', $user_id, '=')->execute();
        }

        $utilities->miniOrange_set_get_configurations(array('mo_auth_status' => 'PLUGIN_CONFIGURATION'), 'SET');

        // Update the customer second factor to OTP Over Email in miniOrange
        $customer = new MiniorangeCustomerProfile();
        $miniorange_user = new MiniorangeUser($customer->getCustomerID(), $username, '', '', AuthenticationType::$EMAIL['code']);
        $user_api_handler = new UsersAPIHandler($customer->getCustomerID(), $customer->getAPIKey());
        $user_api_handler->update($miniorange_user);
        $license_response = $user_api_handler->fetchLicense();

        $license_type = 'DRUPAL_2FA';
        $license_plan = 'DRUPAL_2FA';
        $no_of_users = 1;

        if (is_object($license_response) && $license_response->status == 'CURL_ERROR') {
            \Drupal::messenger()->addError(t('cURL is not enabled. Please enable cURL'));
            return;
        } elseif (is_object($license_response) && isset($license_response->licenseExpiry) && $utilities->license_expired($license_response->licenseExpiry) && $license_response->status == 'SUCCESS') {
            $license_type = $license_response->licenseType;
            /**Delete the OR part once all the Drupal 8 2FA customers shift on the Drupal 2FA plan.*/

            if ($license_type == MoAuthConstants::LICENSE_TYPE || $license_type == 'DRUPAL8_2FA_MODULE') {
                $license_plan = $license_response->licensePlan;
            }
            $no_of_users = $license_response->noOfUsers;
        }

        $mo_db_values = $utilities->miniOrange_set_get_configurations(array('mo_auth_enable_two_factor'), 'GET');

        $variables_and_values_2 = array(
            'mo_auth_2fa_license_type' => $license_type,
            'mo_auth_2fa_license_plan' => $license_plan,
            'mo_auth_2fa_license_no_of_users' => $no_of_users,
            'mo_auth_2fa_ivr_remaining' => isset($license_response->ivrRemaining) ? $license_response->ivrRemaining : '-',
            'mo_auth_2fa_sms_remaining' => isset($license_response->smsRemaining) ? $license_response->smsRemaining : '-',
            'mo_auth_2fa_email_remaining' => isset($license_response->emailRemaining) ? $license_response->emailRemaining : '-',
            'mo_auth_2fa_license_expiry' => isset($license_response->licenseExpiry) ? date('Y-M-d H:i:s', strtotime($license_response->licenseExpiry)) : '-',
            'mo_auth_2fa_support_expiry' => isset($license_response->supportExpiry) ? date('Y-M-d H:i:s', strtotime($license_response->supportExpiry)) : '-',
            'mo_auth_enable_two_factor' => $mo_db_values['mo_auth_enable_two_factor'] == '' ? TRUE : $mo_db_values['mo_auth_enable_two_factor'],
            'mo_auth_enforce_inline_registration' => $license_type == 'DRUPAL_2FA' ? FALSE : TRUE,
        );
        $utilities->miniOrange_set_get_configurations($variables_and_values_2, 'SET');
    }

  function moAuthCreateMiniorangeUserAdmin($username, $phone, $password)
  {
    $utilities = new MoAuthUtilities();

    $user = User::load(\Drupal::currentUser()->id());
    $user_id = $user->id();

    // Create customer.
    $customer_config = new MiniorangeCustomerSetup($username, $phone, $password);
    $create_customer_response = $customer_config->createCustomer();

    if ($create_customer_response->status == 'CURL_ERROR') {
      \Drupal::messenger()->addError(t('cURL is not enabled. Please enable cURL'));
      return;
    } elseif ($create_customer_response->status == 'SUCCESS') {
      // OTP Validated. Show Configuration page.
      $utilities->miniOrange_set_get_configurations(array('mo_auth_status' => 'PLUGIN_CONFIGURATION'), 'SET');
      $utilities->miniOrange_set_get_configurations(array('mo_auth_tx_id'), 'CLEAR');
      // Customer created.
      $this->mo_auth_save_customer($user_id, $create_customer_response, $username, $phone);
      \Drupal::messenger()->addStatus(t('Your account has been created successfully. Email Verification has been set as your default 2nd-factor method.'));
      return;
    } elseif ($create_customer_response->status == 'INVALID_EMAIL_QUICK_EMAIL') {
      \Drupal::messenger()->addError(t('There was an error creating an account for you.<br> You may have entered an invalid Email-Id
              <strong>(We discourage the use of disposable emails) </strong>
              <br>Please try again with a valid email.'));
      return;
    } else {
      MoAuthUtilities::mo_add_loggers_for_failures($create_customer_response->message, 'error');
      \Drupal::messenger()->addError(t('An error occurred while creating your account. Please try again or contact us at' . ' <a href="mailto:info@xecurify.com">info@xecurify.com</a>.'));
      return;
    }
  }
}
