<?php

/**
 * 框架异常
 */
class CtxException extends Exception {
    /**
     * 异常处理基类
     * @param string $message 异常消息
     * @param int $code 错误码
     */
    public function __construct($message, $code = 0) {
        parent::__construct($message,$code);
    }
}
