<?php

namespace App\Exceptions;

use Exception;
use Request;

/**
 * Interface BlogException
 * @package App\Exceptions
 * 所有的异常类必须实现这个接口
 */
interface BlogException {
    public function handle($request,Exception $exception);
}
