<?php
/**
 * @file
 * Contains constants class.
 */

namespace Drupal\miniorange_2fa;
/**
 * @file
 * This class represents constants used
 *     throughout project.
 */
class MoAuthConstants
{
    const PLUGIN_NAME                  = 'Drupal Two-Factor Plugin';
    const TRANSACTION_NAME             = 'Drupal Two-Factor Module';
    const APPLICATION_NAME             = 'drupal_2fa';
    const LICENSE_TYPE                 = 'DRUPAL_2FA_PLUGIN';
    const PREMIUM_PLAN                 = 'drupal_2fa_premium_plan';
    const ADD_USER_PLAN                = 'drupal_2fa_add_user_plan';
    const RENEW_SUBSCRIPTION_PLAN      = 'drupal_2fa_renew_subscription_plan';
    const WBSITE_SECURITY              = 'https://plugins.miniorange.com/drupal-web-security-pro';
    const PORTAL_URL                   = 'https://portal.miniorange.com/initializepayment?requestOrigin=';

    const DEFAULT_CUSTOMER_ID          = '16622';
    const DEFAULT_CUSTOMER_API_KEY     = 'XzjkmAaAOzmtJRmXddkXyhgDXnMCrdZz';

    const CUSTOMER_CHECK_API           = '/rest/customer/check-if-exists';
    const CUSTOMER_CREATE_API          = '/rest/customer/add';
    const CUSTOMER_GET_API             = '/rest/customer/key';
    const CUSTOMER_CHECK_LICENSE       = '/rest/customer/license';
    const SUPPORT_QUERY                = '/rest/customer/contact-us';

    const USERS_CREATE_API             = '/api/admin/users/create';
    const USERS_GET_API                = '/api/admin/users/get';
    const USERS_UPDATE_API             = '/api/admin/users/update';
    const USERS_SEARCH_API             = '/api/admin/users/search';
    const USERS_DELETE_API             = '/api/admin/users/delete';
    const USERS_DISABLE_API            = '/api/admin/users/disable';
    const USERS_ENABLE_API             = '/api/admin/users/enable';

    const AUTH_CHALLENGE_API           = '/api/auth/challenge';
    const AUTH_VALIDATE_API            = '/api/auth/validate';
    const AUTH_STATUS_API              = '/api/auth/auth-status';
    const AUTH_REGISTER_API            = '/api/auth/register';
    const AUTH_REGISTRATION_STATUS_API = '/api/auth/registration-status';
    const AUTH_GET_GOOGLE_AUTH_API     = '/api/auth/google-auth-secret';
    const AUTH_GET_ALL_USER_API        = '/api/admin/users/getall';

    //Case studies links
    const HEADLESS_DRUPAL_2FA = 'https://www.drupal.org/case-study/secure-your-headless-drupal-website-with-robust-2-factor-authentication';
    const SSO_AND_2FA = 'https://www.drupal.org/case-study/drupal-salesforce-sso-with-oauth-server-and-2fa';
    const HARDWARE_TOKEN_2FA = 'https://www.drupal.org/case-study/abt-associates';
    const PASSWORDLESS_LOGIN = 'https://www.drupal.org/case-study/passwordless-login';
    const DRUPAL_CASE_STUDIES = 'https://www.drupal.org/node/3196471/case-studies';

    //Guide links
    const INLINE_REGISTRATION = 'https://www.drupal.org/docs/extending-drupal/contributed-modules/contributed-modules/setup-guides-to-configure-various-2fa-mfa-tfa-methods/feature-guides/inline-registration';

    //KBA validation constants
    const KBA_ANSWER_LENGTH = 3;
    CONST ALPHANUMERIC_PATTERN        = '/^[\w\s]+$/'; // This is the pattern for preg_match() function
    CONST ALPHANUMERIC_LENGTH_PATTERN = '^[\w\s?]{'.self::KBA_ANSWER_LENGTH.',}$'; // This is the pattern for Javascript validation | Current pattern - '^[\w\s?]{3,}$'
    const VALIDATION_MESSAGE          = 'The answer must be at least '. self::KBA_ANSWER_LENGTH .' characters long and contain only alphanumeric characters.';

    //Other License Types
    const LICENSE_TYPE_PREMIUM = 'PREMIUM';
    const LICENSE_TYPE_D8 = 'DRUPAL8_2FA_MODULE';

    /**
     * Function that handles the custom
     * organization name
     */
    public static function getBaseUrl()
    {
        $getBrandingName = \Drupal::config('miniorange_2fa.settings')->get('mo_auth_custom_organization_name');
        return "https://" . $getBrandingName . ".xecurify.com/moas";
    }

    CONST ADDON_LIST = [
        'mo_salesforce_addon'
    ];
}
