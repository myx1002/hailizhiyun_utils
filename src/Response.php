<?php

namespace Hlyun;

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
}
