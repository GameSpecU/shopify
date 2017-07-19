<?php

namespace Dan\Shopify;

/**
 * Class Util
 */
class Util
{

    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];

    /**
     * Convert a string to snake case.
     *
     * @param  string  $value
     * @param  string  $delimiter
     * @return string
     */
    public static function snake($value, $delimiter = '_')
    {
        if (! ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', $value);

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value));
        }

        return $value;
    }

    /**
     * Convert the given string to lower-case.
     *
     * @param  string  $value
     * @return string
     */
    public static function lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * @param string $hmac
     * @param string $token
     * @param string $data
     * @return bool
     */
    public static function validWebhookHmac($hmac, $token, $data)
    {
        $calculated_hmac = hash_hmac(
            $algorithm = 'sha256',
            $data,
            $token,
            $raw_output = true
        );

        return $hmac == base64_encode($calculated_hmac);
    }

    /**
     * @param $hmac
     * @param $secret
     * @param array $data
     * @return bool
     */
    public static function validAppHmac($hmac, $secret, array $data)
    {
        $message = [];

        $keys = array_keys($data);
        sort($keys);
        foreach($keys as $key) {
            $message[] = "{$key}={$data[$key]}";
        }

        $message = implode('&', $message);

        $calculated_hmac = hash_hmac(
            $alorithm = 'sha256', 
            $message, 
            $secret
        );

        return $hmac == $calculated_hmac;
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function studly($value)
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param  array  $array
     * @param  int  $depth
     * @return array
     */
    public static function flatten($array, $depth = INF)
    {
        return array_reduce($array, function ($result, $item) use ($depth) {
            if (! is_array($item)) {
                return array_merge($result, [$item]);
            } elseif ($depth === 1) {
                return array_merge($result, array_values($item));
            } else {
                return array_merge($result, static::flatten($item, $depth - 1));
            }
        }, []);
    }

}