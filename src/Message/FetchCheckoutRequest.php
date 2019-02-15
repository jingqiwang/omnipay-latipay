<?php

namespace Omnipay\Latipay\Message;

use Omnipay\Common\Message\AbstractRequest;

class FetchCheckoutRequest extends AbstractRequest
{
    protected $endpoint = 'https://api.latipay.net/v2/transaction/';

    public function setMerchantReference($value)
    {
        return $this->setParameter('merchant_reference', $value);
    }

    public function getMerchantReference()
    {
        return $this->getParameter('merchant_reference');
    }

    public function setUserId($value)
    {
        return $this->setParameter('user_id', $value);
    }

    public function getUserId()
    {
        return $this->getParameter('user_id');
    }

    public function setKey($value)
    {
        return $this->setParameter('key', $value);   
    }

    public function getKey()
    {
        return $this->getParameter('key');   
    }

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
        $request = $this->httpClient->get($this->endpoint . $this->getMerchantReference(), [], [
            'query' => $data
        ]);
        $response = $request->send();

        return new FetchCheckoutResponse($this, $response->getBody(true));
    }
}