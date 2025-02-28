<?php

namespace Drupal\miniorange_2fa\Form;

use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\miniorange_2fa\MoAuthUtilities;
use Drupal\miniorange_2fa\MiniorangeCustomerProfile;

/**
 *  Showing Support form info.
 */
class MoCustomKBAQues extends FormBase
{
    public function getFormId()
    {
        return 'miniorange_2fa_custom_kba_ques';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $utilities = new MoAuthUtilities();

        $variables_and_values = array(
            'mo_auth_customer_admin_email',
            'mo_auth_2fa_license_type',
            'mo_auth_enable_two_factor',
            'mo_auth_enforce_inline_registration',
            'mo_auth_2fa_allow_reconfigure_2fa',
            'mo_auth_2fa_kba_questions',
            'mo_auth_enable_allowed_2fa_methods',
            'mo_auth_selected_2fa_methods',
            'mo_auth_enable_role_based_2fa',
            'mo_auth_role_based_2fa_roles',
            'mo_auth_enable_domain_based_2fa',
            'mo_auth_domain_based_2fa_domains',
            'mo_2fa_domain_and_role_rule',
            'mo_auth_use_only_2nd_factor',
            'mo_auth_enable_login_with_email',
            'mo_auth_enable_login_with_phone',
            'mo_auth_override_login_labels',
            'mo_auth_username_title',
            'mo_auth_username_description',
            'mo_auth_enable_trusted_IPs',
            'mo_auth_trusted_IP_address',
            'mo_auth_enable_whitelist_IPs', // Remove this variable after May 2023 release
            'mo_auth_whitelisted_IP_address',  // Remove this variable after May 2023 release
            'mo_auth_enable_custom_kba_questions',
            'mo_auth_redirect_user_after_login',
            'mo_auth_google_auth_app_name',
            // Advanced settings variables
            'mo_auth_custom_organization_name',
            'mo_auth_enable_2fa_for_password_reset',
            'mo_auth_customer_api_key',
            'mo_auth_enable_backdoor',

            // opt-in and opt-out variables
            'allow_end_users_to_decide',

            'auto_fetch_phone_number',
            'phone_number_field_machine_name',
            'auto_fetch_phone_number_country_code',

            // remember my device
            'mo_auth_rba',
            'mo_auth_rba_duration',
            'rba_allowed_devices',
            'mo_auth_rba_duration',
        );

        $mo_db_values = $utilities->miniOrange_set_get_configurations($variables_and_values, 'GET');

        $form['mo_customize_kba_option']['markup_custom_kba_questions_note'] = array(
            '#markup' => t('<div class="mo_2fa_highlight_background_note"><b></b>Follow the below format: 
                        <ul>
                            <li>Enter semicolon ( ; ) separated questions including ( ? ) question mark.</li>
                            <li>No spaces before and after the semicolon ( ; ).</li>
                            <li>No semicolon ( ; ) after the last question.</li>
                            <strong>eg.</strong> This is the first question?;This is the second question?
                        </ul></div>'),
        );

        $form['mo_customize_kba_option']['mo_auth_enable_custom_kba_set_1'] = array(
            '#type' => 'textarea',
            '#title' => t('Question set 1'),
            '#default_value' => $utilities::mo_get_kba_questions('ONE', 'STRING'),
        );

        $form['mo_customize_kba_option']['mo_auth_enable_custom_kba_set_2'] = array(
            '#type' => 'textarea',
            '#title' => t('Question set 2'),
            '#default_value' => $utilities::mo_get_kba_questions('TWO', 'STRING'),
        );

        $form['actions'] = array('#type' => 'actions');
        $form['actions']['send'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            '#attributes' => [
                'class' => [
                    'use-ajax',
                    'button--primary'
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
        $response = new AjaxResponse();
        // If there are any form errors, AJAX replace the form.
        if ($form_state->hasAnyErrors()) {
            $response->addCommand(new ReplaceCommand('#modal_support_form', $form));
        } else {
            $utilities = new MoAuthUtilities();
            $form_values = $form_state->getValues();

            $variables_and_values = array(
                'mo_auth_custom_kba_set_1' => self::processKBAQuestions($form_values['mo_auth_enable_custom_kba_set_1']),
                'mo_auth_custom_kba_set_2' => self::processKBAQuestions($form_values['mo_auth_enable_custom_kba_set_2']),
            );
            $utilities->miniOrange_set_get_configurations($variables_and_values, 'SET');

            \Drupal::messenger()->addStatus(t('KBA questions updated successfully.'));

            if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
                global $base_url;
                $current_path = explode($base_url, $_SERVER['HTTP_REFERER']);
                $url_object = \Drupal::service('path.validator')->getUrlIfValid($current_path[1]);
                $route_name = $url_object->getRouteName();
                $response->addCommand(new RedirectCommand(Url::fromRoute($route_name)->toString()));
            } else {
                $response->addCommand(new RedirectCommand(Url::fromRoute('miniorange_2fa.customer_setup')->toString()));
            }
        }
        return $response;
    }

    /**
     * Process KBA questions before saving
     * @param $questions
     * @return string
     */
    function processKBAQuestions($questions)
    {
        $mo_kba_questions = trim($questions);
        $mo_kba_questions = rtrim($mo_kba_questions, ";");
        return $mo_kba_questions;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
    }
}