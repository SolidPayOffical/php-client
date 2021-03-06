<?php
namespace Solidpay\API;

/**
 * @class       Solidpay_Client
 * @since       0.1.0
 * @package     Solidpay
 * @category    Class
 */

class Client
{
    /**
     * Contains cURL instance
     *
     * @access public
     */
    public $ch;

    /**
     * Contains the authentication string
     *
     * @access protected
     */
    protected $auth_string;

    /**
     * Contains the headers
     *
     * @access protected
     */
    protected $headers = array();

    /**
     * __construct function.
     *
     * Instantiate object
     *
     * @access public
     */
    public function __construct($auth_string = '', $merchant_id, $additional_headers = array())
    {
        // Check if lib cURL is enabled
        if (!function_exists('curl_init')) {
            throw new Exception('Lib cURL must be enabled on the server');
        }

        // Save authentication string
        $this->auth_string = $auth_string;

        // Create cURL instance.
        $this->ch = curl_init();
        curl_setopt_array($this->ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        ));

        // Default headers
        $this->headers = array(
            'Accept: application/json',
            'Merchant: '.$merchant_id
        );

        if (!empty($this->auth_string)) {
            $this->headers[] = 'Authorization: ' . base64_encode($this->auth_string);
        }

        // Add custom headers and set headers in cURL object.
        $this->setHeaders($additional_headers);
    }

    /**
     * Shutdown function.
     *
     * Closes the current cURL connection
     *
     * @access public
     */
    public function shutdown()
    {
        if (!empty($this->ch)) {
            curl_close($this->ch);
        }
    }

    /**
     * Set additional headers for cURL request.
     *
     * @param string[] $additional_headers
     * @access public
     * @return bool
     */
    public function setHeaders($additional_headers)
    {
        if (!empty($additional_headers)) {
            $this->headers = array_merge($this->headers, $additional_headers);
        }
        return curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
    }
}
