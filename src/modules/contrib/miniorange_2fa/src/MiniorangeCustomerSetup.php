<?php
/**
 * @file
 * Contains miniOrange Customer class.
 */

namespace Drupal\miniorange_2fa;

/**
 * @file
 * This class represents configuration for
 *     customer.
 */
class MiniorangeCustomerSetup
{
    public $email;
    public $phone;
    public $customerKey;
    public $transactionId;
    public $password;
    public $defaultCustomerId;
    public $defaultCustomerApiKey;

    /**
     * Constructor.
     */
    public function __construct($email, $phone, $password)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->defaultCustomerId = MoAuthConstants::DEFAULT_CUSTOMER_ID;
        $this->defaultCustomerApiKey = MoAuthConstants::DEFAULT_CUSTOMER_API_KEY;
    }

    /**
     * Check if customer exists.
     */
    public function checkCustomer()
    {
        $url = MoAuthConstants::getBaseUrl() . MoAuthConstants::CUSTOMER_CHECK_API;
        $fields = array(
            'email' => $this->email
        );
        $json = json_encode($fields);
        $response = MoAuthUtilities::callService($this->defaultCustomerId, $this->defaultCustomerApiKey, $url, $json, false);
        if (json_last_error() == JSON_ERROR_NONE && is_object($response) && strcasecmp($response->status, 'CURL_ERROR') == 0) {
            MoAuthUtilities::mo_add_loggers_for_failures($response->message, 'error');
        }
        return $response;
    }

    /**
     * Create Customer.
     */
    public function createCustomer()
    {
        $url = MoAuthConstants::getBaseUrl() . MoAuthConstants::CUSTOMER_CREATE_API;
        $fields = array(
            'companyName' => $_SERVER['SERVER_NAME'],
            'areaOfInterest' => MoAuthConstants::PLUGIN_NAME,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password
        );
        $json = json_encode($fields);
        $response = MoAuthUtilities::callService($this->defaultCustomerId, $this->defaultCustomerApiKey, $url, $json, false);
        if (json_last_error() == JSON_ERROR_NONE && strcasecmp($response->status, 'CURL_ERROR')) {
            MoAuthUtilities::mo_add_loggers_for_failures($response->message, $response->status === 'SUCCESS' ? 'info' : 'error');
        }
        return $response;
    }

    /**
     * Get Customer Keys.
     */
    public function getCustomerKeys()
    {
        $url = MoAuthConstants::getBaseUrl() . MoAuthConstants::CUSTOMER_GET_API;
        $fields = array(
            'email' => $this->email,
            'password' => $this->password
        );
        $json = json_encode($fields);
        $response = MoAuthUtilities::callService($this->defaultCustomerId, $this->defaultCustomerApiKey, $url, $json);
        if (json_last_error() == JSON_ERROR_NONE && empty($response->apiKey)) {
            MoAuthUtilities::mo_add_loggers_for_failures($response->message, 'error');
        }
        return $response;
    }

}
