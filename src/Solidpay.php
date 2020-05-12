<?php

namespace Solidpay;

use Solidpay\API\Client;
use Solidpay\API\Request;

class Solidpay
{
    
    public $request;

    /**
     * __construct function.
     *
     * Instantiates the main class.
     * Creates a client which is passed to the request construct.
     *
     * @auth_string string Authentication string for Solidpay
     *
     * @access public
     */

    public function __construct($auth_string = '', $merchant_id, $additional_headers = array())
    {
        $client = new Client($auth_string, $merchant_id, $additional_headers);
        $this->request = new Request($client);
    }

    /**
     * Add additional headers to request.
     *
     * This could be used when need to test a callback url in dev mode
     *
     *      Solidpay-Callback-Url: http://text.url/callback
     *
     * @access public
     */
    
    public function setHeaders($additional_headers = array())
    {
        $this->request->client->setHeaders($additional_headers);
    }

}
