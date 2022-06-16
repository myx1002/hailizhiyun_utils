<?php

namespace Hlyun;

//封装一些处理微服务交互的一些方法
class MicroService
{
    /**
     * 聚合层拿微服务返回的数据,取其中的data，抛api异常
     *
     * @param string $json
     * @param int $callerType 0聚合层调用 1微服务之间调用
     * @return mixed
     */
    public function fetchServiceJsonData(string $json, int $callerType = 0)
    {
        $arr = json_decode($json, true);
        if (!is_array($arr)) {
            $this->throwException($callerType, '微服务返回json字符串非法');
        }
        if (!isset($arr['code']) || !isset($arr['message'])) {
            $this->throwException($callerType, '微服务返回json字符串格式非法');
        }
        if ($arr['code'] != 0 || !isset($arr['data'])) {
            $this->throwException($callerType, $arr['message'], $arr['code']);
        }

        return $arr['data'];
    }

    /**
     * 抛异常
     *
     * @param integer $callerType 0聚合层调用 1微服务之间调用
     * @param string $errMsg
     * @param integer $code
     * @return void
     */
    private function throwException(int $callerType = 0, string $errMsg, $code = 600)
    {
        if ($callerType === 0) {
            throw new ApiException($errMsg, $code);
        }
        throw new ServiceException($errMsg, $code);
    }
}
