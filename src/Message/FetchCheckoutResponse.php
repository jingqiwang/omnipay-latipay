<?php

namespace Omnipay\Latipay\Message;

use Guzzle\Http\EntityBodyInterface;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

class FetchCheckoutResponse extends AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $data = json_decode($data, true);
        if (!$data) {
            throw new InvalidResponseException;
        }
        
        $this->data = $data;
    }

    public function isSuccessful()
    {
        return $this->getStatus() === 'paid';
    }

    public function getStatus()
    {
        return $this->data['status'];
    }

    public function getAmount()
    {
        return $this->data['amount'];
    }

    public function getPaymentMethod()
    {
        return $this->data['payment_method'];
    }
}