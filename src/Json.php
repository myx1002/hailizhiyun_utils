<?php

namespace Hlyun;

class Json
{
    public function getServiceJsonData(string $json)
    {
        $arr = json_decode($json, true);
        if (!is_array($arr)) {
            throw new ApiException('微服务返回json字符串非法');
        }
        if (!isset($arr['data']) || !isset($arr['code'])) {
            throw new ApiException('微服务返回json字符串格式非法');
        }
    }
}
