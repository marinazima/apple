<?php

namespace backend\dto;

/**
 * Created by PhpStorm.
 * User: zima
 * Date: 11.01.2020
 * Time: 22:45
 */
class AppleServiceDto
{
    /**
     * @var bool
     */
    protected $success;

    /**
     * @var string
     */
    protected $message;

    /**
     * AppleServiceDto constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->success = $params['success'] ?? false;
        $this->message = $params['message'] ?? null;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}