<?php
/**
 * @file
 * Contains support form for miniOrange 2FA Login
 *     Module.
 */

namespace Drupal\miniorange_2fa\Form;

use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\miniorange_2fa\MoAuthConstants;
use Drupal\miniorange_2fa\MoAuthUtilities;
use Drupal\miniorange_2fa\AuthenticationType;
use Drupal\miniorange_2fa\Helper\FormHelper\MoAuthTitle;

/**
 * Showing LoginSetting form info.
 */
class MoAuthLoginSettings extends FormBase {

	public function getFormId() {
		return 'miniorange_2fa_login_settings';
	}

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        global $base_url;
        $utilities = new MoAuthUtilities();

        // For the safer side previous variables having whitelist keywords are kept on this page, please remove after this release
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

        if($mo_db_values['mo_auth_2fa_allow_reconfigure_2fa'] == 'Not_Allowed' || $mo_db_values['mo_auth_2fa_allow_reconfigure_2fa'] == 'Allowed' ){
            $variables  = $mo_db_values['mo_auth_2fa_allow_reconfigure_2fa'] == 'Not_Allowed'?array('mo_auth_2fa_allow_reconfigure_2fa' => 0,):array('mo_auth_2fa_allow_reconfigure_2fa' => 1,);
            $utilities->miniOrange_set_get_configurations($variables, 'SET');
        }

        if($mo_db_values['mo_auth_2fa_kba_questions'] == 'Not_Allowed' || $mo_db_values['mo_auth_2fa_kba_questions'] == 'Allowed' ){
            $variables  = $mo_db_values['mo_auth_2fa_kba_questions'] == 'Not_Allowed'?array('mo_auth_2fa_kba_questions' => 0,):array('mo_auth_2fa_allow_reconfigure_2fa' => 1,);
            $utilities->miniOrange_set_get_configurations($variables, 'SET');
        }
      $title = [
        'name'        => t('2FA Policy For End Users'),
        'description' => t('The users can configure/reconfigure 2FA using this tab.'),
      ];
      MoAuthTitle::buildTitleForm($form, $form_state, $title);

        $disabled = False;
        if (!$utilities::isCustomerRegistered()) {
            $form['header'] = array(
                '#markup' => t('<div class="mo_2fa_register_message"><p>You need to <a href="' . $base_url . '/admin/config/people/miniorange_2fa/customer_setup">Register/Login</a> with miniOrange before using this module.</p></div>'),
            );
            $disabled = True;
        }

        $license_type = $mo_db_values['mo_auth_2fa_license_type'] == '' ? 'DRUPAL_2FA' : $mo_db_values['mo_auth_2fa_license_type'];
        $is_free = $license_type == MoAuthConstants::LICENSE_TYPE_PREMIUM || $license_type == MoAuthConstants::LICENSE_TYPE || $license_type == MoAuthConstants::LICENSE_TYPE_D8 ? FALSE : TRUE;

        if($is_free){
            $form['markup_top'] = array(
                '#markup' => '<div class="mo_2fa_welcome_message">' . t('Please <a target = _blank href="https://portal.miniorange.com/initializepayment?requestOrigin=drupal_2fa_premium_plan">upgrade</a> to the premium plan or initiate a <a class="js-form-submit form-submit use-ajax mo_top_bar_button" href="requestDemo">trial request</a> to enable all the features under this tab.') . '</div>'
            );
        }
        $form['markup_library'] = array(
            '#attached' => array(
                'library' => array(
                    "miniorange_2fa/miniorange_2fa.admin",
                    "miniorange_2fa/miniorange_2fa.license",
                    "miniorange_2fa/miniorange_2fa.copy_button",
                    "core/drupal.dialog.ajax",
                    "miniorange_2fa/miniorange_2fa.country_flag_dropdown",
                    "miniorange_2fa/miniorange_2fa.clickable_div",
                )
            ),
        );

        $form['2fa_general_settings'] = array(
            '#type' => 'details',
            '#title' => t('General 2FA Settings'),
            '#open' => true,
        );

        $form['2fa_general_settings']['mo_auth_enable_two_factor'] = array(
            '#type' => 'checkbox',
            '#default_value' => $mo_db_values['mo_auth_enable_two_factor'],
            '#title' => t('Activate Two-Factor Authentication'),
            '#disabled' => $disabled,
            '#id' => "inlineRegistration",
        );

        $url_path = $base_url . '/' . \Drupal::service('extension.list.module')->getPath('miniorange_2fa') . '/includes/images';

        $form['2fa_general_settings']['mo_auth_enforce_inline_registration'] = array(
            '#type' => 'checkbox',
            '#title' => t('Enforce 2FA to end users ' . '<a class=" js-form-submit form-submit use-ajax mo_top_bar_button" href="allowed_2fa_methods">Set Up Available 2FA Methods</a>'),
            '#default_value' => $mo_db_values['mo_auth_enforce_inline_registration'],
            '#disabled' => $is_free,
        );

        $form['2fa_general_settings']['mo_auth_2fa_kba_questions'] = array(
            '#type' => 'checkbox',
            '#title' => t('Allow users to setup KBA as Backup-2FA '.'<a class=" js-form-submit form-submit use-ajax mo_top_bar_button" href="custom_kba_ques"> Customize KBA Questions</a>'),
            '#default_value' => $mo_db_values['mo_auth_2fa_kba_questions'],
            '#disabled' => $is_free,
        );

        $form['2fa_general_settings']['mo_auth_2fa_allow_reconfigure_2fa'] = array(
            '#type' => 'checkbox',
            '#title' => t('Allow users to change/re-configure 2FA'),
            '#default_value' => $mo_db_values['mo_auth_2fa_allow_reconfigure_2fa'],
            '#disabled' => $is_free,
        );

        $form['2fa_general_settings']['mo_auth_two_factor_instead_password'] = array(
            '#type' => 'checkbox',
            '#default_value' => $mo_db_values['mo_auth_use_only_2nd_factor'],
            '#disabled' => $is_free,
            '#title' => t('Allow Passwordless Login'),
            '#states' => array('disabled' => array(':input[name = "mo_auth_enforce_inline_registration"]' => array('checked' => FALSE),),),
        );

        $form['2fa_general_settings']['allow_end_users_to_decide'] = array(
            '#type' => 'checkbox',
            '#title' => $this->t("Allow users to skip 2FA"),
            '#disabled' => $is_free,
            '#default_value' => $mo_db_values['allow_end_users_to_decide'],
        );

        $form['2fa_general_settings']['mo_auth_enable_2fa_for_password_reset'] = array(
            '#type' => 'checkbox',
            '#title' => t('Enable two factor authentication for password reset ' . $utilities::mo_add_premium_tag()),
            '#disabled' => $is_free,
            '#default_value' => $mo_db_values['mo_auth_enable_2fa_for_password_reset'],
        );

        $form['2fa_general_settings']['auto_fetch_phone_number'] = array(
            '#type' => 'checkbox',
            '#title' => t('Auto fetch phone number '),
            '#default_value' => $mo_db_values['auto_fetch_phone_number'],
            '#description' => t('Fetch phone number from user profile while the end users set up OTP over SMS as 2FA methods.'),
            '#disabled' => $is_free,
        );

        $accountConfigUrl = Url::fromRoute('entity.user.field_ui_fields')->toString();
        $custom_fields = MoAuthUtilities::customUserFields();

        $form['2fa_general_settings']['auto_fetch_phone_number_field_name'] = array(
            '#type' => 'select',
            '#title' => t('Phone number field name'),
            '#options' => $custom_fields,
            '#default_value' => $mo_db_values['phone_number_field_machine_name'],
            '#states' => array('visible' => array(':input[name = "auto_fetch_phone_number"]' => array('checked' => TRUE),),),
            '#description' => t('<a target="_blank" href="' . $accountConfigUrl . '">Click here</a> to check available fields on your Drupal site.'),
            '#disabled' => $is_free,
        );

        $form['2fa_general_settings']['auto_fetch_phone_number_country_code'] = array(
            '#type' => 'textfield',
            '#title' => t('Default country code'),
            '#default_value' => $mo_db_values['auto_fetch_phone_number_country_code'] . '00', //extra zeroes are append to show correct country code according to new JS library
            '#states' => array('visible' => array(':input[name = "auto_fetch_phone_number"]' => array('checked' => TRUE),),),
            '#disabled' => $is_free,
            '#id' => 'query_phone',
            '#attributes' => array('style' => 'width:15%;', 'class' => array('query_phone',)),
        );

        $backdoor_url = $disabled == FALSE ? $base_url . '/user/login?skip_2fa=' . $mo_db_values['mo_auth_customer_api_key'] : 'Register/Login with miniOrange to see the URL.';
        $form['2fa_general_settings']['mo_auth_enable_backdoor'] = array(
            '#type' => 'checkbox',
            '#title' => t('Enable Backdoor Login'),
            '#description' => t('Checking this option creates a backdoor to login and skip 2FA, for the users with administrator privileges..
                <b><br>Backdoor URL:</b> <span id="miniorange_2fa_backdoor_url"><code><b><a> ' . $backdoor_url . ' </a></b></code></span><span class="button button--small mo_copy">&#128461; Copy</span>'),
            '#disabled' => $disabled,
            '#default_value' => $mo_db_values['mo_auth_enable_backdoor'] == '' ? False : $mo_db_values['mo_auth_enable_backdoor'],
        );

        $form['2fa_general_settings']['mo_auth_redirect_user_after_login'] = array(
            '#type' => 'textfield',
            '#title' => t('Redirect URL after user login'),
            '#default_value' => $mo_db_values['mo_auth_redirect_user_after_login'] == '' ? $base_url . '/user' : $mo_db_values['mo_auth_redirect_user_after_login'],
            '#attributes' => array('placeholder' => '', 'style' => 'width:45%', 'title' => 'This is my tooltip'),
            '#disabled' => $disabled,
        );

        $form['2fa_restrictions'] = array(
            '#type' => 'details',
            '#title' => t('2FA Restrictions'),
            '#open' => false,
        );

        $form['2fa_restrictions']['restriction_types_table'] = [
            '#type' => 'table',
            '#responsive' => TRUE,
            '#attributes' => ['class' => ['mo_2fa_restriction_types']],
        ];

        $row = $this->mo_2fa_restriction_types();

        $form['2fa_restrictions']['restriction_types_table']['title'] = $row;

        $this->roleBasedFieldset($form, $utilities, $mo_db_values, $is_free);
        $this->domainBasedFieldset($form, $utilities, $mo_db_values, $is_free);
        $this->ipBasedFieldset($form, $utilities, $mo_db_values, $is_free);

        /**
         * Create container to hold @RememberMyDevice form elements.
         */
        $form['mo_remember_device'] = array(
            '#type' => 'details',
            '#title' => t('Remember My Device'),
        );

        $form['mo_remember_device']['mo_auth_rba'] = array(
            '#type' => 'checkbox',
            '#title' => t('Enable Remember My Device'),
            '#default_value' => $mo_db_values['mo_auth_rba'],
            '#disabled' => $is_free,
        );

        $form['mo_remember_device']['rba_duration'] = array(
            '#type' => 'number',
            '#title' => t('Device Profiles Expiry Time (In days).'),
            '#default_value' => $mo_db_values['mo_auth_rba_duration'],
            '#min' => 1,
            '#max' => 365,
            '#step' => 1,
            '#disabled' => $is_free,
        );

        $form['mo_remember_device']['rba_allowed_devices'] = array(
            '#type' => 'number',
            '#title' => t('Number of trusted devices per user'),
            '#default_value' => $mo_db_values['rba_allowed_devices'],
            '#min' => 1,
            '#max' => 5,
            '#step' => 1,
            '#disabled' => $is_free,
        );

        $form['mo_additional_settings'] = array(
            '#type' => 'details',
            '#title' => t('Customizations'),
        );

        $form['mo_additional_settings']['mo_auth_two_factor_google_authenticator_app_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Google Authenticator account name'),
            '#default_value' => $mo_db_values['mo_auth_google_auth_app_name'] == '' ? 'miniOrangeAuth' : urldecode($mo_db_values['mo_auth_google_auth_app_name']),
            '#attributes' => array(
                'style' => 'width:45%',
            ),
            '#disabled' => $disabled,
        );

        $email_template_url = MoAuthConstants::getBaseUrl() . '/login?username=' . $mo_db_values['mo_auth_customer_admin_email'] . '&redirectUrl=' . MoAuthConstants::getBaseUrl() . '/admin/customer/emailtemplateconfiguration';
        $sms_template_url = MoAuthConstants::getBaseUrl() . '/login?username=' . $mo_db_values['mo_auth_customer_admin_email'] . '&redirectUrl=' . MoAuthConstants::getBaseUrl() . '/admin/customer/smstemplateconfiguration';
        $logo_favicon_url = MoAuthConstants::getBaseUrl() . '/login?username=' . $mo_db_values['mo_auth_customer_admin_email'] . '&redirectUrl=' . MoAuthConstants::getBaseUrl() . '/admin/customer/customerrebrandingconfig';
        $otp_url = MoAuthConstants::getBaseUrl() . '/login?username=' . $mo_db_values['mo_auth_customer_admin_email'] . '&redirectUrl=' . MoAuthConstants::getBaseUrl() . '/admin/customer/customerpreferences';

        /**
         *Create container to hold custom organization name.
         */
        $form['mo_additional_settings']['mo_auth_custom_organization_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Organization branding'),
            '#default_value' => $mo_db_values['mo_auth_custom_organization_name'] == '' ? 'login' : urldecode($mo_db_values['mo_auth_custom_organization_name']),
            '#attributes' => array(
                'style' => 'width:45%',
            ),
            '#disabled' => $disabled,
            '#description' => t('<strong>Note: </strong>If you have set the <strong>Organization Name</strong> under Basic Settings tab in <a target="_blank" href="' . $logo_favicon_url . '">Xecurify dashboard</a> then change this value same as Organization branding.'),
        );

        $form['mo_additional_settings']['mo_auth_two_factor_enable_login_with_email'] = array(
            '#type' => 'checkbox',
            '#disabled' => $is_free,
            '#default_value' => $mo_db_values['mo_auth_enable_login_with_email'],
            '#title' => t('Enable login using email address'),
        );

        $form['mo_additional_settings']['mo_auth_two_factor_enable_login_with_phone'] = array(
            '#type' => 'checkbox',
            '#disabled' => $is_free,
            '#default_value' => $mo_db_values['mo_auth_enable_login_with_phone'],
            '#title' => t('Enable login using phone number'),
        );

        $form['mo_additional_settings']['login_with_phone_number_field_machine_name'] = array(
            '#type' => 'select',
            '#title' => t('Select phone number field'),
            '#options' => $custom_fields,
            '#default_value' => $mo_db_values['phone_number_field_machine_name'],
            '#states' => array('visible' => array(':input[name = "mo_auth_two_factor_enable_login_with_phone"]' => array('checked' => TRUE),),),
            '#description' => t('<strong>Note: </strong><a target="_blank" href=" ' . $accountConfigUrl . ' ">Click here</a> to check the machine name of the phone number field.<br><br>'),
            '#disabled' => $is_free,
        );

        $form['mo_additional_settings']['mo_auth_two_factor_override_login_labels'] = array(
            '#type' => 'checkbox',
            '#disabled' => $is_free,
            '#title' => t('Override login form username title and description'),
            '#default_value' => $mo_db_values['mo_auth_override_login_labels'],
        );
        $form['mo_additional_settings']['mo_auth_two_factor_username_title'] = array(
            '#type' => 'textfield',
            '#title' => t('Login form username title'),
            '#attributes' => array(
                'style' => 'width:45%',
                'placeholder' => t('Login with username/email address')
            ),
            '#default_value' => $mo_db_values['mo_auth_username_title'],
            '#disabled' => $is_free,
            '#states' => array('disabled' => array(':input[name = "mo_auth_two_factor_override_login_labels"]' => array('checked' => FALSE),),),
        );
        $form['mo_additional_settings']['mo_auth_two_factor_username_description'] = array(
            '#type' => 'textfield',
            '#title' => t('Login form username description'),
            '#disabled' => $is_free,
            '#default_value' => $mo_db_values['mo_auth_username_description'],
            '#attributes' => array(
                'style' => 'width:45%',
                'placeholder' => t('You can use your username or email address to login.')
            ),
            '#states' => array('disabled' => array(':input[name = "mo_auth_two_factor_override_login_labels"]' => array('checked' => FALSE),),),
        );

        $form['mo_additional_settings']['mo_customize_email_sms_template']['customize_email_template'] = array(
            '#markup' => '
                         <div class="mo_customize_email_sms_template"><strong>The following can be customized from the Xecurify Dashboard.</strong>
                             <ol>
                                <li><a target="_blank" href="' . $email_template_url . '">Email Template</a></li>
                                <li><a target="_blank" href="' . $sms_template_url . '">SMS Template</a></li>
                                <li><a target="_blank" href="' . $logo_favicon_url . '">Logo and Favicon</a></li>
                                <li><a target="_blank" href="' . $otp_url . '">OTP length and validity</a></li>
                              
                             </ol>
                         </div>
                         ',
        );



        $form['Submit_LoginSettings_form'] = array(
            '#type' => 'submit',
            '#id' => 'miniorange_2fa_save_config_btn',
            '#button_type' => 'primary',
            '#value' => t('Save Settings'),
            '#disabled' => $disabled,
            '#suffix' => '</div>'
        );

        return $form;
    }

    /**
     * Fetch fieldset for the basic authentication type.
     */
    private function roleBasedFieldset(&$form, $utilities, $mo_db_values, $is_free) {
        $form['2fa_restrictions']['role_based_fieldset'] = [
            '#type' => 'fieldset',
            '#attributes' => ['style' => 'margin:16px;'],
            '#title' => $this->t('Role Based Restriction - Enable 2FA for specific roles.'),
            '#id' => 'role_based_restriction',
        ];

        $form['2fa_restrictions']['role_based_fieldset']['basic_auth_hidden_field'] = [
            '#type' => 'hidden',
            '#default_value' => 'Role Based Restriction',
            // Set an ID for easier manipulation with JavaScript.
            '#attributes' => ['id' => 'restriction-hidden-flag'],
        ];

        $form['2fa_restrictions']['role_based_fieldset']['mo_auth_two_factor_enable_role_based_2fa'] = array(
            '#type' => 'checkbox',
            '#default_value' => $mo_db_values['mo_auth_enable_role_based_2fa'],
            '#disabled' => $is_free,
            '#title' => t('Enable role based 2FA'),
            '#prefix' => t('<hr><div class="mo_2fa_highlight_background_note">Please note if "<u>Allow Passwordless Login</u>" is enabled, Second-Factor authentication will be invoked irrespective of the roles.</div><br>'),
        );

        $form['2fa_restrictions']['role_based_fieldset']['role_based_table_container'] = array(
            '#type' => 'container',
        );

        $header = [
            'role' => $this->t('Role'),
            '2fa_method' => $this->t('2FA Method'),

        ];

        /* Table for role based 2FA methods */
        $form['2fa_restrictions']['role_based_fieldset']['role_based_table_container']['mo_auth_role_based_2fa_table'] = array(
            '#type' => 'table',
            '#header' => $header,
        );

        /**
         * @variable $roles_arr -> Original Drupal roles array
         * @variable $selected_roles -> Array of roles for which 2FA is enabled
         * @variable $role_based_2fa_methods -> Array of allowed 2FA methods
         */
        $roles_arr = $utilities::get_Existing_Drupal_Roles();

        $selected_roles = isset($mo_db_values['mo_auth_role_based_2fa_roles']) ? json_decode($mo_db_values['mo_auth_role_based_2fa_roles'], true) : array();

        $mo_get_2fa_methods = $utilities::get_2fa_methods_for_inline_registration(FALSE);
        $selected_2fa_methods = isset($mo_db_values['mo_auth_selected_2fa_methods']) ? json_decode($mo_db_values['mo_auth_selected_2fa_methods'], true) : '';
        $role_based_2fa_methods['ALL SELECTED METHODS'] = 'All Allowed Methods' ;
        $methods = $mo_db_values['mo_auth_enable_allowed_2fa_methods'] ? $selected_2fa_methods : $mo_get_2fa_methods ;

        foreach ($methods as $key => $value) {
            $role_based_2fa_methods[$key] = $value;
        }

        /* Table rows for role based 2FA method*/
        foreach ($roles_arr as $sysName => $displayName) {
            $form['2fa_restrictions']['role_based_fieldset']['role_based_table_container']['mo_auth_role_based_2fa_table'][$sysName]['checkbox'] = array(
                '#type' => 'checkbox',
                '#disabled' => $is_free,
                '#title' => t($displayName),
                '#id' => $sysName,
                '#states' => array('disabled' => array(':input[name = "mo_auth_two_factor_enable_role_based_2fa"]' => array('checked' => FALSE),),),
                '#default_value' => is_array($selected_roles) ? array_key_exists($sysName, $selected_roles) ? TRUE : FALSE : TRUE,
            );

            $form['2fa_restrictions']['role_based_fieldset']['role_based_table_container']['mo_auth_role_based_2fa_table'][$sysName]['2fa_methods'] = array(
                '#type' => 'select',
                '#options' => $role_based_2fa_methods,
                '#default_value' => $selected_roles[$sysName] ?? 'ALL SELECTED METHODS',
                '#states' => array('disabled' => array(':input[id = '.$sysName.']' => array('checked' => FALSE),),),
            );
        }
    }

    /**
     * Create fieldset for the API key authentication.
     */
    private function domainBasedFieldset(&$form, $utilities, $mo_db_values, $is_free) {
        $form['2fa_restrictions']['domain_based_fieldset'] = [
            '#type' => 'fieldset',
            '#attributes' => ['style' => 'margin:16px;'],
            '#title' => $this->t('Domain Based Restriction - Enable 2FA for specific email domains.'),
            '#id' => 'domain_based_restriction',
        ];

        $form['2fa_restrictions']['domain_based_fieldset']['mo_auth_two_factor_invoke_2fa_depending_upon_domain'] = array(
            '#type' => 'checkbox',
            '#default_value' => $mo_db_values['mo_auth_enable_domain_based_2fa'],
            '#prefix' => t('<hr>'),
            '#disabled' => $is_free,
            '#title' => t('Enable Domain Based 2FA'),
        );
        $form['2fa_restrictions']['domain_based_fieldset']['mo_auth_domain_based_2fa_domains'] = array(
            '#type' => 'textarea',
            '#default_value' => $mo_db_values['mo_auth_domain_based_2fa_domains'],
            '#attributes' => array('placeholder' => t('Enter semicolon(;) separated domains ( eg. abc.com;xyz.com)'),),
            '#states' => array('disabled' => array(':input[name = "mo_auth_two_factor_invoke_2fa_depending_upon_domain"]' => array('checked' => FALSE),),),
        );

        $form['2fa_restrictions']['domain_based_fieldset']['mo_2fa_rule_for_domain'] = array(
            '#type' => 'radios',
            '#title' => t('Interaction between role based and domain based 2FA'),
            '#default_value' => $mo_db_values['mo_2fa_domain_and_role_rule'] == 'OR' ? 'OR' : 'AND',
            '#options' => array(
                'AND' => t('Invoke 2FA, if user belongs to Role as well as Domain'),
                'OR' => t('Invoke 2FA, if user belongs to either Role or Domain'),
            ),
            '#states' => array('disabled' => array(':input[name = "mo_auth_two_factor_invoke_2fa_depending_upon_domain"]' => array('checked' => FALSE),),),
        );
    }

    /**
     * Create the table for the API key authentication.
     */
    private function ipBasedFieldset(&$form, $utilities, $mo_db_values, $is_free) {

        $form['2fa_restrictions']['ip_based_fieldset'] = [
            '#type' => 'fieldset',
            '#attributes' => ['style' => 'margin:16px;'],
            '#title' => $this->t('IP Based Restriction - Skip 2FA for Trusted IPs.'),
            '#id' => 'ip_based_restriction',
        ];

        $form['2fa_restrictions']['ip_based_fieldset']['mo_auth_two_factor_invoke_2fa_depending_upon_IP'] = array(
            '#type' => 'checkbox',
            '#default_value' => empty($mo_db_values['mo_auth_enable_trusted_IPs']) ? $mo_db_values['mo_auth_enable_whitelist_IPs'] : $mo_db_values['mo_auth_enable_trusted_IPs'],  // Make change here after May 2023 release
            '#prefix' => t('<hr>'),
            '#disabled' => $is_free,
            '#title' => t('Enable Trusted IP Based 2FA'),
        );
        $form['2fa_restrictions']['ip_based_fieldset']['mo_auth_two_factor_trusted_IP'] = array(
            '#type' => 'textarea',
            '#default_value' => empty($mo_db_values['mo_auth_trusted_IP_address']) ? $mo_db_values['mo_auth_whitelisted_IP_address'] : $mo_db_values['mo_auth_trusted_IP_address'] ,
            '#attributes' => array('placeholder' => t('Enter semicolon(;) separated IP addresses ( Format for range: lower_range - upper_range )'),),
            '#states' => array('disabled' => array(':input[name = "mo_auth_two_factor_invoke_2fa_depending_upon_IP"]' => array('checked' => FALSE),),),
        );
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        $form_values = $form_state->getValues();
        if ($form_values['mo_auth_two_factor_invoke_2fa_depending_upon_IP'] === 1 && !empty($form_values['mo_auth_two_factor_trusted_IP'])) {
            $mo_trusted_IPs = preg_replace('/\s+/', '', $form_values['mo_auth_two_factor_trusted_IP']);
            $valid_IPs = MoAuthUtilities::check_for_valid_IPs($mo_trusted_IPs);
            if ($valid_IPs !== TRUE) {
                $form_state->setErrorByName('mo_auth_two_factor_trusted_IP', $this->t($valid_IPs));
            }
        }
        if ($form_values['mo_auth_two_factor_override_login_labels'] === 1) {
            if (empty($form_values['mo_auth_two_factor_username_title'])) {
                $form_state->setErrorByName('mo_auth_two_factor_username_title', $this->t('Username title is mandatory to enable<strong> Override login form username title and description</strong> option'));
            }
            if (empty($form_values['mo_auth_two_factor_username_description'])) {
                $form_state->setErrorByName('mo_auth_two_factor_username_description', $this->t('Username description is mandatory to enable<strong> Override login form username title and description</strong> option'));
            }
        }
    }

    private function mo_2fa_restriction_types() {

        $data = ['Role Based Restriction'=> 'role_based',
            'Domain Based Restriction'=> 'domain_based',
            'IP Based Restriction'=> 'ip_based',];
        foreach ($data as $parameter => $id) {
            $row[$parameter] = array(
                '#markup' => '<div class="container-inline display_style_blocks" id="'.$id.'"><div class="method_name_div"><b>' . $parameter . '</b></div></div>',
            );
        }
        return $row;
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $utilities = new MoAuthUtilities();
        $form_values = $form_state->getValues();

        $phone_number_field_machine_name = $utilities->miniOrange_set_get_configurations(['phone_number_field_machine_name'], 'GET')['phone_number_field_machine_name'];
        if (is_null($phone_number_field_machine_name)) {
            $phone_number_field_machine_name = trim($form_values['auto_fetch_phone_number_field_name']) == '' ? trim($form_values['login_with_phone_number_field_machine_name']) : trim($form_values['auto_fetch_phone_number_field_name']);
        } else {
            if ($phone_number_field_machine_name == trim($form_values['auto_fetch_phone_number_field_name'])) {
                $phone_number_field_machine_name = trim($form_values['login_with_phone_number_field_machine_name']);
            } else {
                $phone_number_field_machine_name = trim($form_values['auto_fetch_phone_number_field_name']);
            }
        }

        /**
         * @DO NOT REMOVE THE SPACES BETWEEN FOLLOWING LINES
         */
        $variables_and_values = array(
            'mo_auth_enable_two_factor' => $form_values['mo_auth_enable_two_factor'] === 1,
            'mo_auth_enforce_inline_registration' => $form_values['mo_auth_enforce_inline_registration'] === 1,
            'mo_auth_2fa_allow_reconfigure_2fa' => $form_values['mo_auth_2fa_allow_reconfigure_2fa'],
            'mo_auth_2fa_kba_questions' => $form_values['mo_auth_2fa_kba_questions'],

            'mo_auth_enable_role_based_2fa' => $form_values['mo_auth_two_factor_enable_role_based_2fa'] === 1,
            'mo_auth_role_based_2fa_roles' => self::getRoleBased2faRoles($form_values),

            'mo_auth_enable_domain_based_2fa' => $form_values['mo_auth_two_factor_invoke_2fa_depending_upon_domain'] === 1,
            'mo_auth_domain_based_2fa_domains' => preg_replace('/\s+/', '', $form_values['mo_auth_domain_based_2fa_domains']),
            'mo_2fa_domain_and_role_rule' => $form_values['mo_2fa_rule_for_domain'],

            'mo_auth_use_only_2nd_factor' => $form_values['mo_auth_two_factor_instead_password'] === 1,

            'mo_auth_enable_login_with_email' => $form_values['mo_auth_two_factor_enable_login_with_email'] === 1,
            'mo_auth_enable_login_with_phone' => $form_values['mo_auth_two_factor_enable_login_with_phone'] === 1,
            'mo_auth_override_login_labels' => $form_values['mo_auth_two_factor_override_login_labels'] === 1,
            'mo_auth_username_title' => $form_values['mo_auth_two_factor_username_title'],
            'mo_auth_username_description' => $form_values['mo_auth_two_factor_username_description'],

            'mo_auth_enable_trusted_IPs' => $form_values['mo_auth_two_factor_invoke_2fa_depending_upon_IP'] === 1,
            'mo_auth_trusted_IP_address' => preg_replace('/\s+/', '', $form_values['mo_auth_two_factor_trusted_IP']),

            'mo_auth_redirect_user_after_login' => $form_values['mo_auth_redirect_user_after_login'],
            'mo_auth_google_auth_app_name' => urlencode($form_values['mo_auth_two_factor_google_authenticator_app_name']),

            'mo_auth_custom_organization_name' => urlencode($form_values['mo_auth_custom_organization_name']),

            'mo_auth_enable_2fa_for_password_reset' => $form_values['mo_auth_enable_2fa_for_password_reset'] === 1,
            'mo_auth_enable_backdoor' => $form_values['mo_auth_enable_backdoor'] === 1,

            'allow_end_users_to_decide' => $form_values['allow_end_users_to_decide'] === 1,

            'auto_fetch_phone_number' => $form_values['auto_fetch_phone_number'] === 1,
            'phone_number_field_machine_name' => trim($phone_number_field_machine_name),
            'auto_fetch_phone_number_country_code' => $form_values['auto_fetch_phone_number_country_code'],
            'mo_auth_rba' => $form_values['mo_auth_rba'],
            'mo_auth_rba_duration' => (int)$form_values['rba_duration'],
            'rba_allowed_devices' => (int)$form_values['rba_allowed_devices'],
        );

        $utilities->miniOrange_set_get_configurations($variables_and_values, 'SET');

        $mo_db_values = $utilities->miniOrange_set_get_configurations($variables_and_values, 'GET');

        //drupal_flush_all_caches(); //TODO: Remove this after 3.08 release
        \Drupal::messenger()->addStatus(t("Login settings updated."));
    }


    /**
     * Process role based 2FA
     * @param $form_values
     * @return string
     */
    function getRoleBased2faRoles($form_values)
    {
          $mo_role_based_2fa_roles = [];
          $table_values  = $form_values['mo_auth_role_based_2fa_table'];
          foreach ($table_values as $key => $value) {
              if($value['checkbox'] == 1) {
                  $mo_role_based_2fa_roles[$key] = $value['2fa_methods'];
              }
          }
          return !empty($mo_role_based_2fa_roles) ? json_encode($mo_role_based_2fa_roles) : '';
    }
}
