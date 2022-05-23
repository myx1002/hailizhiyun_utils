<?php

/**
 * 封装一些跟业务无关的公用方法
 */

if (!function_exists('get_header_token')) {
    function get_header_token($type = 'center')
    {
        $token = request()->header($type . '-token');
        if (empty($token)) {
            $token = request()->header($type . '_token');
        }

        return $token;
    }
}

if (!function_exists('json_encode_uni')) {
    function json_encode_uni($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}

if (!function_exists('json_decode_arr')) {
    function json_decode_arr($data): array
    {
        $arr = json_decode($data, true);
        if (is_null($arr)) {
            return [];
        }
        return $arr;
    }
}


if (!function_exists('date_str')) {
    function date_str(?int $timpstamp = null)
    {
        if (empty($timpstamp)) {
            $timpstamp = time();
        }
        return date('Y-m-d', $timpstamp);
    }
}

if (!function_exists('date_time_str')) {
    function date_time_str(?int $timpstamp = null)
    {
        if (empty($timpstamp)) {
            $timpstamp = time();
        }
        return date('Y-m-d H:i:s', $timpstamp);
    }
}

// 根据数据库连接名称获取真实的数据库名称
if (!function_exists('get_schema_by_connection')) {
    function get_schema_by_connection(string $connection)
    {
        return config("database.connections.$connection.database");
    }
}

/**
 * 判断浏览器名称和版本
 */
function get_browser_name()
{
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return '未知';
    }
    if ((false == strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE)) {
        return 'Internet Explorer 11.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 10.0')) {
        return 'Internet Explorer 10.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.0')) {
        return 'Internet Explorer 9.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0')) {
        return 'Internet Explorer 8.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')) {
        return 'Internet Explorer 7.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0')) {
        return 'Internet Explorer 6.0';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Edge')) {
        return 'Edge';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
        return 'Firefox';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
        return 'Chrome';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Safari')) {
        return 'Safari';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
        return 'Opera';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], '360SE')) {
        return '360SE';
    }
    //微信浏览器
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessage')) {
        return 'MicroMessage';
    }
}

/**
 * 获取客户端操作系统信息包括win10
 * @param null
 * @return string
 * @author  Allen
 */
function get_os()
{
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return '未知';
    }
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $os = false;
    if (preg_match('/win/i', $agent) && strpos($agent, '95')) {
        $os = 'Windows 95';
    } else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')) {
        $os = 'Windows ME';
    } else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent)) {
        $os = 'Windows 98';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent)) {
        $os = 'Windows Vista';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)) {
        $os = 'Windows 7';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent)) {
        $os = 'Windows 8';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent)) {
        $os = 'Windows 10'; #添加win10判断
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {
        $os = 'Windows XP';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)) {
        $os = 'Windows 2000';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {
        $os = 'Windows NT';
    } else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent)) {
        $os = 'Windows 32';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/unix/i', $agent)) {
        $os = 'Unix';
    } else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'SunOS';
    } else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'IBM OS/2';
    } else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent)) {
        $os = 'Macintosh';
    } else if (preg_match('/PowerPC/i', $agent)) {
        $os = 'PowerPC';
    } else if (preg_match('/AIX/i', $agent)) {
        $os = 'AIX';
    } else if (preg_match('/HPUX/i', $agent)) {
        $os = 'HPUX';
    } else if (preg_match('/NetBSD/i', $agent)) {
        $os = 'NetBSD';
    } else if (preg_match('/BSD/i', $agent)) {
        $os = 'BSD';
    } else if (preg_match('/OSF1/i', $agent)) {
        $os = 'OSF1';
    } else if (preg_match('/IRIX/i', $agent)) {
        $os = 'IRIX';
    } else if (preg_match('/FreeBSD/i', $agent)) {
        $os = 'FreeBSD';
    } else if (preg_match('/teleport/i', $agent)) {
        $os = 'teleport';
    } else if (preg_match('/flashget/i', $agent)) {
        $os = 'flashget';
    } else if (preg_match('/webzip/i', $agent)) {
        $os = 'webzip';
    } else if (preg_match('/offline/i', $agent)) {
        $os = 'offline';
    } else {
        $os = '未知操作系统';
    }
    return $os;
}

/**
 * 获取真实ip
 * @Author
 * @param
 * @param string $value [description]
 */
function get_ip()
{

    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else if (!empty($_SERVER["REMOTE_ADDR"])) {
        $cip = $_SERVER["REMOTE_ADDR"];
    } else {
        $cip = '';
    }
    preg_match("/[\d\.]{7,15}/", $cip, $cips);
    $cip = isset($cips[0]) ? $cips[0] : 'unknown';
    unset($cips);
    return $cip;
}


//获取图片地址
if (!function_exists('image_url')) {
    function image_url($document)
    {
        $imageDomain = env('STATIC_URL', 'localhost');
        return rtrim($imageDomain, '/') . '/api/fileServer/getImage/' . $document;
    }
}

//数组null值转为""
if (!function_exists('null_to_empty_string')) {
    function null_to_empty_string(array $data)
    {
        foreach ($data as &$value) {
            if (is_array($value)) {
                $value = null_to_empty_string($value);
            } else {
                if ($value === null) {
                    $value = '';
                }
            }
        }

        return $data;
    }
}

if (!function_exists('arr_id_to_str')) {
    /**
     * 查询字段键值
     * @author ALLEN 2016.11.29
     * @param string $id 待查询键
     * @param string $key 待查询键
     * @param object $val 查询值
     * @param string $arr 数组库（类似数据库）
     * @return string        字符串
     */
    function arr_id_to_str($id, $key, $arr)
    {
        $str = '';
        if (is_array($arr)) {
            foreach ($arr as $k => $v) {
                if ($v['id'] == $id) {
                    $str = $v[$key];
                    return $str;
                }
            }
        }
        return $str;
    }
}
