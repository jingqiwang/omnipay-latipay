<?php
namespace Omnipay\Latipay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    protected $request;
    protected $payload;

    public function __construct(RequestInterface $request, $response)
    {
        $this->request = $request;
        $this->response = json_decode($response, true);
    }

    public function isSuccessful()
    {
        return $this->response['message'] === 'SUCCESS';
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->response['host_url'] . '/' . $this->response['nonce'];
    }

    public function getRedirectMethod()
    {
        return 'GET';
    }

    public function getRedirectData()
    {
        return null;
    }
}