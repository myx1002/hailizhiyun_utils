<?php

namespace Hlyun;

use Illuminate\Support\Facades\Log;
use Throwable;

trait Response
{
    //返回给前端的
    public function successJson($data = null, string $message = '')
    {
        $res = [
            'code' => 0,
            'message' => $message ?: '操作成功!'
        ];

        if (!is_null($data)) {
            $res['data'] = $data;
        }

        return response()->json($res, 200, [], JSON_UNESCAPED_UNICODE);
    }

    //返回给前端的
    public function failJson(string $message = '', int $errCode = 600, $data = null)
    {
        $res = [
            'code' => $errCode,
            'message' => $message ?: "操作失败！"
        ];

        if (!is_null($data)) {
            $res['data'] = $data;
        }
        return response()->json($res, 200, [], JSON_UNESCAPED_UNICODE);
    }

    // 微服务用
    public function successStrJson($data = [], string $message = ''): string
    {
        return json_encode_uni([
            'code' => 0,
            'message' => $message,
            'data' => $data
        ]);
    }

    // 微服务用
    public function failStrJson(string $message = '', int $errCode = 600, $data = []): string
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
        $ref = new \ReflectionClass($th);
        $className = $ref->getName();
        Log::info($className);
        if ($className === 'Illuminate\Validation\ValidationException') {
            $errMsg = current($th->errors())[0] ?? '参数有误';
        } elseif ($className === 'Hlyun\ServiceException') {
            $errMsg = $th->getMessage();
        } else {
            $errMsg = '调用'.$serviceName.'的方法：'. $functionName.'()异常。错误信息为：'. $th->getMessage();
            if (env('APP_DEBUG')) {
                $errMsg .= $th->getTraceAsString();
            }
            Log::error($th->getTraceAsString());
        }
        return $this->failStrJson($errMsg); 
    }
}
