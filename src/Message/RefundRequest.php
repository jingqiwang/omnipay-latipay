<?php
namespace Omnipay\Latipay\Message;

use Omnipay\Common\Message\AbstractRequest;

class RefundRequest extends AbstractRequest
{
    protected $endpoint = 'https://api.latipay.net/v2/refund';

    public function setUserId($value)
    {
        return $this->setParameter('user_id', $value);
    }

    public function getUserId()
    {
        return $this->getParameter('user_id');
    }

    public function setOrderId($value)
    {
        return $this->setParameter('order_id', $value);
    }

    public function getOrderId()
    {
        return $this->getParameter('order_id');
    }

    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }

    public function getKey()
    {
        return $this->getParameter('key');
    }

    public function setRefundAmount($value)
    {
        return $this->setParameter('refund_amount', $value);
    }

    public function getRefundAmount()
    {
        return $this->getParameter('refund_amount');
    }

    public function setReference($value)
    {
        return $this->setParameter('reference', $value);
    }

    public function getReference()
    {
        return $this->getParameter('reference');
    }

    public function getData()
    {
        $this->validate(
            'user_id',
            'order_id',
            'refund_amount',
            'reference'
        );

        $data = array();
        $data['user_id'] = $this->getUserId();
        $data['order_id'] = $this->getOrderId();
        $data['refund_amount'] = $this->getAmount();
        $data['reference'] = $this->getReference();

        ksort($data);
        $data['signature'] = $this->sign($data, $this->getKey());

        return $data;
    }

    public function sendData($data)
    {
        $response = $this->httpClient->post(
            $this->endpoint,
            ['Content-Type'=>'application/json'],
            json_encode($data)
        )->send();

        return new RefundResponse($this, $response->getBody());
    }

    protected function sign($params, $secureKey)
    {
        $signText = implode('&', array_map(
            function ($key, $value) {
                return $key . '=' . $value;
            },
            array_keys($params),
            $params
        ));

        return hash_hmac('sha256', $signText . $secureKey, $secureKey);
    }
}
