<?php

namespace BoldApps\ShopifyToolkit\Exceptions;

class ShopifyException extends \Exception
{
    private $response;

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     *
     * @return ShopifyException
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }
}
