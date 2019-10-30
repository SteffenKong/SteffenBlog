<?php

/**
 * json格式化输出
 */
if(!function_exists('jsonPrint')) {
    function jsonPrint($staus,$message,$data = [],$extra = [],$httpCode = 200) {
        $result = [
            'status'=>$staus,
            'message'=>$message,
            'data'=>$data,
            'extra'=>$extra,
            'httpCode'=>$httpCode
        ];

        return response()->json($result,$httpCode);
    }
}
