<?php


namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class DemoController extends BaseController
{
    /**
     * @return array
     */
    public function success_get()
    {
        return message_success([], 'This is success get!');
    }

    /**
     * @return array
     */
    public function success_post()
    {
        return message_success([], 'This is success post!');
    }

    /**
     * @return array
     */
    public function expected_get()
    {
        $age = request()->input('age');
        if (!is_numeric($age)) {
            return message_error(1, 'The age parameter must be an integer!');
        }
        return message(['']);
    }

    /**
     * @return array
     */
    public function error_get()
    {
        ech;
    }

    /**
     * @return array
     */
    public function match_get()
    {
        $str = request()->input('s');
        if (empty($str)) {
            return message_error(1, 'Request parameters cannot be empty');
        }
        if (strlen($str) <= 1) {
            return message_error(1, 'Request parameter must be at least 2 strings');
        }
        if (strlen($str) > 10000) {
            return message_error(1, 'Request parameter characters cannot exceed 10000');
        }
        if (strlen($str) % 2 != 0) {
            return message_error(1, 'String length does not meet the requirements');
        }
        $flag = true;
        $i = 0;
        $j = 1;
        while (true) {
            if ($i >= strlen($str)) {
                break;
            }
            if (!in_array($str[$i], ['(', '[', '{', ')', ']', '}'])) {
                return message_error(1, 'Request parameters can only be specified special characters');
            }
            $even_char = $str[$i];
            $odd_char = $str[$j];
            //The double string must match the value in the array
            if (!in_array($even_char, ['(', '[', '{'])) {
                $flag = false;
                break;
            }
            //The singular string must match the value in the array
            if (!in_array($odd_char, [')', ']', '}'])) {
                $flag = false;
                break;
            }
            switch ($even_char) {
                case '(':
                    if ($odd_char != ')') {
                        $flag = false;
                    }
                    break;
                case '[':
                    if ($odd_char != ']') {
                        $flag = false;
                    }
                    break;
                case '{':
                    if ($odd_char != '}') {
                        $flag = false;
                    }
                    break;
            }
            if ($flag == false) {
                break;
            }
            $i += 2;
            $j += 2;
        }
        // Finally check if the stack is empty
        if ($flag == false) {
            return message_error(1, 'malformed request!');
        }
        return message_success([], 'Congratulations, the request format is correct!');
    }
}