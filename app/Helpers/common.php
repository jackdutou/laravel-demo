<?php

if (!function_exists('message_success')) {

    /**
     * function message_success
     * @param array $data Result data
     * @param string $msg Prompt text
     * @return array
     * @author Jack
     * @date 2023/8/06
     */
    function message_success($data = [], $msg = "success")
    {
        $result = ['status' => 0, 'msg' => $msg, 'data' => $data, 'code' => 0];
        return $result;
    }
}

if (!function_exists('message_error')) {

    /**
     * function message_error
     * @param int $code code
     * @param string $msg Prompt     text
     * @param array $data Result data
     * @return array
     * @author Jack
     * @date 2023/8/06
     */
    function message_error($code = 1, $msg = "success", $data = [])
    {
        $result = ['status' => 1, 'msg' => $msg, 'data' => $data, 'code' => $code];
        return $result;
    }
}

if (!function_exists('request_params_to_json')) {
    /**
     * format request parameters
     * @param array $data
     * @return array
     */
    function request_params_to_json($data = [])
    {
        $params = [];
        if (!empty($data)) {
            if (is_array($data)) {
                $params = json_encode($data);
            }
        } else {
            $params = json_encode((object)$params);
        }
        return $params;
    }
}