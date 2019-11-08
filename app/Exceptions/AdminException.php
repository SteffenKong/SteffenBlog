<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

/**
 * Class AdminException
 * @package App\Exceptions
 * 管理员异常
 */
class AdminException extends \Exception implements BlogException
{

    /**
     * @param $request
     * @param Exception $exception
     * @return \Illuminate\Http\JsonResponse
     * 管理员异常输出
     */
    public function handle($request,Exception $exception) {

        if($request->ajax()) {
            return jsonPrint('003',$exception->getMessage());
        }
        return jsonPrint('003','访问方式非法');
    }
}
