<?php
namespace Omnipay\Latipay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Latipay';
    }

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

    public function purchase(array $params = [])
    {
        return $this->createRequest('\Omnipay\Latipay\Message\PurchaseRequest', $params);
    }

    public function completePurchase(array $params = [])
    {
        return $this->createRequest('\Omnipay\Latipay\Message\CompletePurchaseRequest', $params);
    }
}