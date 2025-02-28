<?php

namespace Drupal\miniorange_2fa\Form;

use Drupal\Core\Url;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\miniorange_2fa\MoAuthUtilities;
use Drupal\miniorange_2fa\AuthenticationType;
use Drupal\miniorange_2fa\Miniorange2FASupport;

class MoAuthRequestDemo extends FormBase
{
    public function getFormId()
    {
        return 'miniorange_2fa_request_demo';
    }

    public function buildForm(array $form, FormStateInterface $form_state, $options = NULL)
    {
        $utilities = new MoAuthUtilities();
        $form['#prefix'] = '<div id="modal_example_form">';
        $form['#suffix'] = '</div>';
        $form['status_messages'] = [
            '#type' => 'status_messages',
            '#weight' => -10,
        ];

        if(empty($utilities->miniOrange_set_get_configurations(array('mo_auth_customer_admin_email'), 'GET')['mo_auth_customer_admin_email'])){
            $form['email'] = array(
                '#type' => 'textfield',
                '#id' => "email_id",
                '#title' => t('Email'),
                '#attributes' => array(
                    'autofocus' => 'true',
                ),
                '#required' => true,
            );
        }

        $form['miniorange_2fa_architecture'] = array(
            '#type' => 'radios',
            '#title' => t('Drupal Architecture:'),
            '#default_value' => 'Traditional/Normal',
            '#options' => array('Traditional/Normal' => t('Traditional/Normal'), 'Headless/Decoupled' => t('Headless/Decoupled')),
            '#required' => TRUE,
            '#prefix' => '<div class="container-inline">',
        );

        $mo_get_2fa_methods  = MoAuthUtilities::get_2fa_methods_for_inline_registration(FALSE);
        $mo_2fa_method_type  = MoAuthUtilities::get2FAMethodType($mo_get_2fa_methods);
        $table_rows          = MoAuthUtilities::generateMethodeTypeRows($mo_2fa_method_type, [], $form_state);

        $form['miniorange_2fa_methods_table'] = [
        '#type' => 'table',
        '#prefix' => '<b>'.t('Select 2FA methods you are interested in') . '</b>',
        '#header' => [$this->t('TOTP METHODS'), $this->t('OTP METHODS'), $this->t('OTHER METHODS')],];

        foreach ($table_rows as $rowNum => $rows ) {
          $form['miniorange_2fa_methods_table'][$rowNum] = $rows;
        }

        $form['miniorange_2fa_usecase'] = array(
            '#type' => 'textarea',
            '#title' => t('Additonal Usecase Details'),
            '#rows' => 1,
        );

        $form['actions'] = array('#type' => 'actions');
        $form['actions']['send'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#attributes' => [
                'class' => [
                    'use-ajax',
                ],
            ],
            '#ajax' => [
                'callback' => [$this, 'submitModalFormAjax'],
                'event' => 'click',
            ],
        ];

        $form['#attached']['library'][] = 'core/drupal.dialog.ajax';
        return $form;
    }

    public function submitModalFormAjax(array $form, FormStateInterface $form_state)
    {
        global $base_url;
        $response = new AjaxResponse();
        // If there are any form errors, AJAX replace the form.
        if ($form_state->hasAnyErrors()) {
            $response->addCommand(new ReplaceCommand('#modal_example_form', $form));
        } else {
            $utilities = new MoAuthUtilities();
            $variables_and_values = array(
                'mo_auth_customer_admin_email',
            );
            $mo_db_values = $utilities->miniOrange_set_get_configurations($variables_and_values, 'GET');
            $email = $mo_db_values['mo_auth_customer_admin_email'];

            $userAccountDetails = '<strong>User account email: </strong>' . $email;

            $siteURL = '<strong>Site Base URL: </strong>' . $base_url;
            $cron_status = '<strong>Cron Status: </strong>' . MoAuthUtilities::getCronInformation();

            $methods = json_decode(MoAuthUtilities::getSelected2faMethods($form_state, 'miniorange_2fa_methods_table'), TRUE);

            $form_values  = $userAccountDetails . '<br><br><strong>Interested 2FA methods: </strong>' . implode(', ' , $methods);
            $form_values .= '<br><br><strong>Drupal Architecture: </strong>' . $form['miniorange_2fa_architecture']['#value'];
            $form_values .= '<br><br><strong>Usecase/Requirements: </strong>' . $form['miniorange_2fa_usecase']['#value'];
            $form_values .= '<br><br>' . $siteURL;
            $form_values .= '<br><br>' . $cron_status;

            $query = "<br><br>Account Details and Usecase:<br><pre style=\"border:1px solid #444;padding:10px;\"><code>" . $form_values . "</code></pre>";

            $support = new Miniorange2FASupport($email, '', $query, 'Trial Request');
            $support_response = $support->sendTrialRequest();

            \Drupal::logger('miniorange_2fa')->info($support_response);

            if($support_response) {
                \Drupal::messenger()->addStatus(t('You will receive an email once trial licence is added under your account within 4-6 hours.'));
            }
            $_POST['value_check'] = 'False';
            $response->addCommand(new RedirectCommand(Url::fromRoute('miniorange_2fa.customer_setup')->toString()));
        }
        return $response;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
    }

    protected function getEditableConfigNames()
    {
        return ['config.miniorange_2fa_remove_account'];
    }
}
