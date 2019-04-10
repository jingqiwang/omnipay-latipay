<?php
namespace Omnipay\Latipay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

class RefundResponse extends AbstractResponse
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
        return $this->response['code'] === 0;
    }

    public function getMessage()
    {
        return $this->response['message'];
    }
}
