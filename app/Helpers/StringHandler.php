<?php

namespace App\Helpers;

class StringHandler
{
    /**
     * function base64Decode
     *
     * @param mixed $content
     * @return null|bool|string
     */
    public static function base64Decode(mixed $content): null|bool|string
    {
        try {
            $data = \base64_decode((string) $content);

            if (json_encode($data) === false) {
                return \null;
            }

            return (string) $data;
        } catch (\Throwable $th) {
            return \null;
        }
    }
}
