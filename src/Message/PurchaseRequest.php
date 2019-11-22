<?php
namespace Omnipay\Latipay\Message;

use Omnipay\Common\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
{
    protected $endpoint = 'https://api.latipay.net/v2/transaction';

    public function setUserId($value)
    {
        return $this->setParameter('user_id', $value);
    }

    public function getUserId()
    {
        return $this->getParameter('user_id');
    }

    public function setWalletId($value)
    {
        return $this->setParameter('wallet_id', $value);
    }

    public function getWalletId()
    {
        return $this->getParameter('wallet_id');
    }

    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }

    public function getKey()
    {
        return $this->getParameter('key');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('payment_method', $value);
    }

    public function getPaymentMethod()
    {
        return $this->getParameter('payment_method');
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function getAmount()
    {
        return $this->getParameter('amount');
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('return_url', $value);
    }

    public function getReturnUrl()
    {
        return $this->getParameter('return_url');
    }

    public function setCallbackUrl($value)
    {
        return $this->setParameter('callback_url', $value);
    }

    public function getCallbackUrl()
    {
        return $this->getParameter('callback_url');
    }

    public function setMerchantReference($value)
    {
        return $this->setParameter('merchant_reference', $value);
    }

    public function getMerchantReference()
    {
        return $this->getParameter('merchant_reference');
    }

    public function setIp($value)
    {
        return $this->setParameter('ip', $value);
    }

    public function getIp()
    {
        return $this->getParameter('ip');
    }

    public function setVersion($value)
    {
        return $this->setParameter('version', $value);
    }

    public function getVersion()
    {
        return $this->getParameter('version');
    }

    public function setProductName($value)
    {
        return $this->setParameter('product_name', $value);
    }

    public function getProductName()
    {
        return $this->getParameter('product_name');
    }

    public function setPresentQr($value)
    {
        return $this->setParameter('present_qr', $value);
    }

    public function getPresentQr()
    {
        return $this->getParameter('present_qr');
    }

    public function getData()
    {
        $this->validate(
            'user_id',
            'wallet_id',
            'payment_method',
            'amount',
            'return_url',
            'callback_url',
            'merchant_reference',
            'ip',
            'version',
            'product_name',
            'present_qr'
        );

        $data = array();
        $data['user_id'] = $this->getUserId();
        $data['wallet_id'] = $this->getWalletId();
        $data['payment_method'] = $this->getPaymentMethod();
        $data['amount'] = $this->getAmount();
        $data['return_url'] = $this->getReturnUrl();
        $data['callback_url'] = $this->getCallbackUrl();
        $data['merchant_reference'] = $this->getMerchantReference();
        $data['ip'] = $this->getIp();
        $data['version'] = $this->getVersion();
        $data['product_name'] = $this->getProductName();
        $data['present_qr'] = $this->getPresentQr();

        ksort($data);
        $data['signature'] = $this->sign($data, $this->getKey());

        return $data;
    }

    public function sendData($data)
    {
        $response = $this->httpClient->request(
            'POST',
            $this->endpoint,
            ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
            json_encode($data)
        );

        return new PurchaseResponse($this, $response->getBody()->getContents());
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
