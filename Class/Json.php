<?php

class Json
{
    public static function encode($data, $encodeOptions = 0)
    {
        $jsonData = @json_encode($data, $encodeOptions);
        $jsonError = json_last_error();
        if (JSON_ERROR_NONE !== $jsonError) {
            throw new InvalidArgumentException(self::jsonErrorToString($jsonError));
        }

        return $jsonData;
    }

    public static function encodeObj($data, $encodeOptions = 0)
    {
        $result = array();

        foreach ($data as $index => $value) {
            array_push($result, $value->to_array());
        }

        $jsonData = @json_encode($result, $encodeOptions);
        $jsonError = json_last_error();
        if (JSON_ERROR_NONE !== $jsonError) {
            throw new InvalidArgumentException(self::jsonErrorToString($jsonError));
        }

        return $jsonData;
    }

    public static function decode($jsonData, $assocArray = true)
    {
        $data = json_decode($jsonData, $assocArray);
        $jsonError = json_last_error();
        if (JSON_ERROR_NONE !== $jsonError) {
            throw new InvalidArgumentException(self::jsonErrorToString($jsonError));
        }

        return $data;
    }

    public static function decodeFile($fileName, $assocArray = true)
    {
        $jsonData = @file_get_contents($fileName);
        if (false === $jsonData) {
            throw new RuntimeException("unable to read file");
        }

        return self::decode($jsonData, $assocArray);
    }

    public static function isValidJson($jsonData)
    {
        try {
            self::decode($jsonData);

            return true;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    public static function jsonErrorToString($code)
    {
        switch ($code) {
            case JSON_ERROR_NONE:
                $msg = "No error has occurred";
                break;
            case JSON_ERROR_DEPTH:
                $msg = "The maximum stack depth has been exceeded";
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $msg = "Invalid or malformed JSON";
                break;
            case JSON_ERROR_CTRL_CHAR:
                $msg = "Control character error, possibly incorrectly encoded";
                break;
            case JSON_ERROR_SYNTAX:
                $msg = "Syntax error";
                break;
            case JSON_ERROR_UTF8:
                $msg = "Malformed UTF-8 characters, possibly incorrectly encoded";
                break;
            default:
                $msg = "Other error ($code)";
                break;
        }

        return $msg;
    }
}
