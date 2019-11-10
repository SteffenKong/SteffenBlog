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


/**
 * 无限极树状排序
 */
if(!function_exists('getTree')) {
    function getTree($data,$pid = 0,$level = 0) {
        $arr = [];
        foreach ($data ?? [] as $k=>$v) {
            if($v['parentId'] == $pid) {
                $v['level'] = $level;
                $arr[] = $v;
                $level ++;
                $arr = array_merge(getTree($data,$v['id'],$level),$arr);

            }
        }
        return $arr;
    }
}
