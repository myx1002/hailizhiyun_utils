<?php

namespace Hlyun;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

trait Response
{
    //返回给前端的
    public function successJson($data = null, string $message = '操作成功!')
    {
        $res = [
            'code' => 0,
            'message' => $message
        ];

        if (!is_null($data)) {
            $res['data'] = $data;
        }

        return response()->json($res, 200, [], JSON_UNESCAPED_UNICODE);
    }

    //返回给前端的
    public function failJson(string $message = '操作失败!', int $errCode = 600, $data = null)
    {
        $res = [
            'code' => $errCode,
            'message' => $message
        ];

        if (!is_null($data)) {
            $res['data'] = $data;
        }
        return response()->json($res, 200, [], JSON_UNESCAPED_UNICODE);
    }

    // 微服务用
    public function successStrJson($data = [], string $message = '操作成功!', string $log = ''): string
    {
        $res = [
            'code' => 0,
            'message' => $message,
            'data' => $data
        ];
        if (!empty($log)) {
            $res['log'] = $log;
        }
        return json_encode_uni($res);
    }

    // 微服务用
    public function failStrJson(string $message = '操作失败!', int $errCode = 600, $data = []): string
    {
        return json_encode_uni([
            'code' => $errCode,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * 微服务抛异常用
     *
     * @param Throwable $th
     * @param string $functionName 传入方法名方便定位
     * @return string
     */
    public function throwStrJson(Throwable $th, string $functionName = '', string $serviceName = '')
    {        
        if ($th instanceof ValidationException) {
            $errMsg = current($th->errors())[0] ?? '参数有误';
        } elseif ($th instanceof ServiceException) {
            $errMsg = $th->getMessage();
            return $th->failStrJson($errMsg, $th->getCode(), $th->data);
        } else {
            $logInfo = $this->assembleLogInfo($th);
            $errMsg = '调用' . $serviceName . '的方法：' . $functionName . '()异常。';
            if (env('APP_DEBUG')) {
                $errMsg .= $logInfo;
            }
            Log::error($logInfo);
            Log::error($th->getTraceAsString());
        }
        return $this->failStrJson($errMsg);
    }

    /**
     * 组装报错信息
     *
     * @param Throwable $th
     * @return string
     */
    private function assembleLogInfo(Throwable $th): string
    {
        $logInfo =  '错误信息:' . $th->getMessage() . '。发生于:' . $th->getFile() . '(' . $th->getLine().')';
        return $logInfo;
    }
}
