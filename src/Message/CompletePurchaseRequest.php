<?php
namespace Omnipay\Latipay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

class CompletePurchaseRequest extends PurchaseRequest
{
    protected $endpoint = 'https://api.latipay.net/v2/transaction/';

    public function getData()
    {
        $this->validate('merchant_reference');

        $data = [
            'user_id' => $this->getUserId(),
            'signature' => hash_hmac('sha256', $this->getMerchantReference() . $this->getUserId(), $this->getKey()),
        ];

        return $data;
    }

    public function send()
    {
        return $this->sendData($this->getData());
    }

    public function sendData($data)
    {
        $response = $this->httpClient->request(
            'GET',
            $this->endpoint . $this->getMerchantReference() . '?' . http_build_query($data),
            ['Accept' => 'application/json'],
            ''
        );

        return new CompletePurchaseResponse($this, $response->getBody()->getContents());
    }

    public function getMerchantReference()
    {
        return $this->getParameter('merchant_reference');
    }

    public function getUserId()
    {
        return $this->getParameter('user_id');
    }

    public function getKey()
    {
        return $this->getParameter('key');
    }
}
