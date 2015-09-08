<?php namespace Vdbf\Components\Cashweb;

use Exception;
use Illuminate\Support\Collection;
use SoapClient;
use Vdbf\Components\Cashweb\Elements\Cash;
use Vdbf\Components\Cashweb\Elements\CashElementInterface;

/**
 * Class CashApi
 *
 * Handles calls to CashWeb API in an OOP fashion
 *
 * @package Vdbf\Components\Cashweb
 */
class CashApi
{

    /**
     * @var string
     */
    protected static $wdsl = "https://www.cashweb.nl/?api/wsdl";

    /**
     * @var SoapClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $service;

    /**
     * @var \stdClass
     */
    protected $administration;

    /**
     * @var bool
     */
    protected $authenticated = false;

    /**
     * @var \Closure
     */
    protected $authenticationResolver;

    /**
     * Constuct a new Cash API object
     *
     * @param null $client
     * @param null $administration
     * @param null $service
     */
    public function __construct($client = null, $administration = null, $service = null)
    {
        $this->client = $client ?: $this->createSoapClient();
        $this->service = $service;
        $this->administration = $administration;
    }

    /**
     * Call Cash@Authenticate via SOAP
     *
     * @param $relation
     * @param null $email
     * @param null $password
     * @param null $service
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return mixed
     * @throws Exception
     */
    public function authenticate($relation, $email = null, $password = null, $service = null)
    {
        if (is_array($relation)) {
            //assume assoc array with keys <relation, email, password, [service]>
            extract($relation);
        }

        $response = $this->doSoapRequest('Authenticate',
            array(
                $relation,
                $email,
                $password,
                $service ?: $this->getService()
            )
        );
        $this->token = $response->token;

        return $response->token;
    }

    /**
     * Call Cash@Import() via SOAP
     *
     * @param $importData
     * @param null $administration
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return mixed
     * @throws Exception
     */
    public function import($importData, $administration = null)
    {
        $response = $this->doSoapRequest('Import',
            array(
                ($importData instanceof CashElementInterface || $importData instanceof Collection) ? $this->assemble($importData) : $importData,
                $administration ?: $this->getAdministration()
            )
        );

        return $response->transaction;
    }

    /**
     * Call Cash@Export() via SOAP
     *
     * @param $exportData
     * @param null $administration
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return mixed
     * @throws Exception
     */
    public function export($command, $administration = null)
    {
        $response = $this->doSoapRequest('Export',
            array(
                $command,
                $administration ?: $this->getAdministration()
            )
        );

        return property_exists($response, 'exportResult') ? $response->exportResult : null;
    }

    /**
     * Call Cash@ListAdministrators() via SOAP
     *
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return mixed
     * @throws Exception
     */
    public function listAdministrations()
    {
        $response = $this->doSoapRequest('ListAdministrations', array());

        return $response->administrationList;
    }

    /**
     * Call Cash@GetTransaction() via SOAP
     *
     * @param $id
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return mixed
     * @throws Exception
     */
    public function getTransaction($id)
    {
        $response = $this->doSoapRequest('GetTransaction', array($id));

        return $response->transaction;
    }

    /**
     * Proxy SOAP request method
     *
     * @param $method
     * @param $arguments
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return object
     * @throws Exception
     */
    public function doSoapRequest($method, $arguments)
    {
        if ($method != 'Authenticate') {

            if ($this->authenticated === false) {

                $this->resolveAuthentication();
            }

            //add correct token to argument list
            array_unshift($arguments, $this->token);
        }

        $response = (object)call_user_func_array(array($this->client, $method), $arguments);

        if (!ApiResponse::isSuccess($response)) {
            throw new Exception(ApiResponse::getErrorMessage($response->response->code));
        }

        return $response;
    }

    /**
     * Retrieve service identifier, identifying ERATI to CASH
     *
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return null
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Retrieve the administration object
     *
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return null
     */
    public function getAdministration()
    {
        return $this->administration;
    }

    /**
     * Assemble the element and provide nice formatting
     *
     * @param $elements
     * @param bool $formatOutput
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return string
     */
    public function assemble($elements, $formatOutput = true)
    {
        $dom = new \DOMDocument();
        $dom->formatOutput = $formatOutput;

        $header = new Cash();

        $elements = $elements instanceof Collection ? $elements : new Collection([$elements]);

        foreach($elements as $element) {
            $header->appendElement($element);
        }

        $header->assemble($dom);

        //return xml but strip last newline char
        return substr($dom->saveXml(), 0, -1);
    }

    /**
     * Construct a SOAP client with the correct WDSL
     *
     * @author Eelke van den Bos <eelkevdbos@gmail.com>
     * @return SoapClient
     */
    protected function createSoapClient()
    {
        return new SoapClient(static::$wdsl);
    }

    /**
     * Set authentication resolver
     *
     * @param $resolver
     */
    public function setAuthenticationResolver($resolver)
    {
        $this->authenticationResolver = $resolver;
    }

    /**
     * Resolve authentication
     *
     * @return void
     */
    protected function resolveAuthentication()
    {
        if (isset($this->authenticationResolver)) {

            call_user_func($this->authenticationResolver);

            $this->authenticated = true;
        }
    }

} 