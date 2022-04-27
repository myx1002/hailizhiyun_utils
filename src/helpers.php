<?php

function get_header_token()
{
    echo 'get_token';
}

function json_encode_uni($data)
{
    return json_encode($data, JSON_UNESCAPED_UNICODE);
}
