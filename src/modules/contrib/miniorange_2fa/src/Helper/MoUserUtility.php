<?php

namespace Drupal\miniorange_2fa\Helper;

use Drupal\miniorange_2fa\UsersAPIHandler;
use Drupal\miniorange_2fa\MoAuthUtilities;
use Drupal\miniorange_2fa\MoAuthConstants;
use Drupal\miniorange_2fa\MiniorangeCustomerProfile;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class for MO user utility functions
 */
class MoUserUtility {

  /**
   * @param array $form
   *    An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *    The current state of the form.
   * @param string $triggered_element
   *    Action from where the event is triggered
   *
   * @return void
   */
  public static function moAuthFetchCustomerLicense( $form, &$form_state, $triggered_element = 'FORM')
  {
    //$check_loggers    = MoAuthUtilities::get_mo_tab_url('LOGS');
    $utilities = new MoAuthUtilities();
    $customer = new MiniorangeCustomerProfile();
    $user_api_handler = new UsersAPIHandler($customer->getCustomerID(), $customer->getAPIKey());
    $response = $user_api_handler->fetchLicense();

    /**
     * Check if license is expired or not found
     */
    if (is_object($response) && $response->status == 'SUCCESS' && $utilities->license_expired($response->licenseExpiry)) {
      $license_type = $response->licenseType;
      /**Delete the OR part once all the Drupal 8 2FA customers shift on the Drupal 2FA plan.*/
      $license_plan = $license_type == MoAuthConstants::LICENSE_TYPE || $license_type == 'DRUPAL8_2FA_MODULE' ? $response->licensePlan : 'DRUPAL_2FA';
      $no_of_users = $response->noOfUsers;

      $variables_and_values = array(
        'mo_auth_2fa_license_type'        => $license_type,
        'mo_auth_2fa_license_plan'        => $license_plan,
        'mo_auth_2fa_license_no_of_users' => $no_of_users,
        'mo_auth_2fa_ivr_remaining'       => isset($response->ivrRemaining) ? $response->ivrRemaining : '-',
        'mo_auth_2fa_sms_remaining'       => isset($response->smsRemaining) ? $response->smsRemaining : '-',
        'mo_auth_2fa_email_remaining'     => isset($response->emailRemaining) ? $response->emailRemaining : '-',
        'mo_auth_2fa_license_expiry'      => isset($response->licenseExpiry) ? date('Y-M-d H:i:s', strtotime($response->licenseExpiry)) : '-',
        'mo_auth_2fa_support_expiry'      => isset($response->supportExpiry) ? date('Y-M-d H:i:s', strtotime($response->supportExpiry)) : '-',
      );
      $utilities->miniOrange_set_get_configurations($variables_and_values, 'SET');

      /**
       * Enable Inline registration if license type is premium
       */
      $mo_enable_inline_registration = \Drupal::config('miniorange_2fa.settings')->get('mo_auth_enforce_inline_registration');
      if ($license_type !== 'DRUPAL_2FA' && $triggered_element !== 'CRON' && !isset($mo_enable_inline_registration)) {
        $utilities->miniOrange_set_get_configurations(array('mo_auth_enforce_inline_registration' => TRUE), 'SET');
      }

      $all_users = $user_api_handler->getall($no_of_users);
      if ($no_of_users == 1) {
        $utilities->miniOrange_set_get_configurations(array('mo_user_limit_exceed' => TRUE), 'SET');
      }

      if ($all_users->status == 'CURL_ERROR') {
        \Drupal::messenger()->addError(t('cURL is not enabled. Please enable cURL'));
        return;
      } elseif ($all_users->status == 'SUCCESS') {
        if (isset($all_users->fetchedCount) && $all_users->fetchedCount == 1) {
          $fetch_first_user = $user_api_handler->getall(1);
          if (is_object($fetch_first_user) && $fetch_first_user->status == 'SUCCESS' && isset($fetch_first_user->fetchedCount) && $fetch_first_user->fetchedCount == 1) {
            if ($fetch_first_user->users[0]->username != $all_users->users[0]->username) {
              $utilities->miniOrange_set_get_configurations(array('mo_user_limit_exceed' => TRUE), 'SET');
            } else {
              $utilities->miniOrange_set_get_configurations(array('mo_user_limit_exceed' => TRUE), 'CLEAR');
            }
          }
        } else {
          $utilities->miniOrange_set_get_configurations(array('mo_user_limit_exceed' => TRUE), 'CLEAR');
        }
      }
      //drupal_flush_all_caches(); //TODO: Remove this after 3.08 release
      if ($triggered_element === 'FORM') {
        \Drupal::messenger()->addStatus(t('License fetched successfully.'));
      }
      return;
    } elseif (is_object($response)) {
      $variables_and_values = array(
        'mo_auth_2fa_license_type' => 'DRUPAL_2FA',
        'mo_auth_2fa_license_plan' => 'DRUPAL_2FA',
        'mo_auth_2fa_license_no_of_users' => 1,
      );
      $utilities->miniOrange_set_get_configurations($variables_and_values, 'SET');
      $variables_and_values = array(
        'mo_auth_2fa_ivr_remaining',
        'mo_auth_2fa_sms_remaining',
        'mo_auth_2fa_email_remaining',
        'mo_auth_2fa_license_expiry',
        'mo_auth_2fa_support_expiry',
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
        'mo_auth_enable_trusted_IPs',
        'mo_auth_trusted_IP_address',
        // Advanced settings variables
        'mo_auth_enable_2fa_for_password_reset',

        // opt-in and opt-out variables
        'allow_end_users_to_decide',

        'auto_fetch_phone_number',
        'phone_number_field_machine_name',
        'auto_fetch_phone_number_country_code'
      );
      $utilities->miniOrange_set_get_configurations($variables_and_values, 'CLEAR');

      if($triggered_element === 'FORM') {
        \Drupal::messenger()->addMessage(t('License fetched successfully.'));
      }
      return;
    }

    MoAuthUtilities::mo_add_loggers_for_failures(isset($response->message) ? $response->message : '', 'error');

    if ($triggered_element === 'FORM') {
      \Drupal::messenger()->addError(t('No license found under your account, Please reach out at drupalsupport@xecurify.com'));
    }
  }
}
