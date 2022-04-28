<?php

namespace Hlyun;

use Illuminate\Support\Facades\Log;
use Throwable;

trait ThrowHandle
{
    use Response;

    /**
     * 微服务用，统一封装处理异常的方法
     *
     * @param Throwable $th
     * @param string $functionName 传入方法名方便定位
     * @return string
     */
    public function throwStrJson(Throwable $th, string $functionName = '', string $serviceName = '')
    {
        $errMsg = '调用'.$serviceName.'的方法：'. $functionName.'()异常。错误信息为：'. $th->getMessage();
        if (env('APP_DEBUG')) {
            $errMsg .= $th->getTraceAsString();
        }
        Log::error($th->getTraceAsString());
        return $this->failStrJson($errMsg);
    }
}
