<?php

/**
 * Crypt class
 *
 *
 * @author Qexy admin@qexy.org
 *
 * @copyright © 2021 Alonity
 *
 * @package alonity\eventhandler
 *
 * @license MIT
 *
 * @version 1.0.0
 *
 */

namespace alonity\crypt;

class Crypt {
    const VERSION = '1.0.0';

    /**
     * Random string by data
     *
     * @param int|null $length
     *
     * @param string $data
     *
     * @return string
     */
    public static function rand(?int $length = null, string $data = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZабвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ~!@#$%^&*()_+\/.,`?><}{[]') : string {

        $len = mb_strlen($data, 'UTF-8');

        if(is_null($length)){
            $length = mt_rand(0, $len-1);
        }

        $string = "";

        for($i = 0; $i < $length; $i++){
            $string .= $data[mt_rand(0, $len-1)];
        }

        return $string;
    }

    /**
     * Random string
     *
     * @param int|null $length
     *
     * @return string
     */
    public static function random(?int $length = null) : string {
        return self::rand($length);
    }

    /**
     * Random int
     *
     * @param int $min
     *
     * @param int $max
     *
     * @return int
     */
    public static function randomInt(int $min = 0, int $max = 1) : int {
        return mt_rand($min, $max);
    }

    /**
     * Random string
     *
     * @param int|null $length
     *
     * @return string
     */
    public static function randomLatin(?int $length = null) : string {
        return self::rand($length, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
    }

    /**
     * Encode string
     *
     * @param string $data
     *
     * @param string $key
     *
     * @return string
    */
    public static function encodeString(string $data, string $key) : string {
        $method = "AES-128-CBC";

        $ivlen = openssl_cipher_iv_length($method);

        $iv = openssl_random_pseudo_bytes($ivlen);

        $ciphertext_raw = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);

        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, true);

        return base64_encode($iv.$hmac.$ciphertext_raw);
    }

    /**
     * Decode string
     *
     * @param string $data
     *
     * @param string $key
     *
     * @return string
     */
    public static function decodeString(string $data, string $key) : string {
        $decode = base64_decode($data);

        $method = "AES-128-CBC";

        $ivlen = openssl_cipher_iv_length($method);

        $iv = substr($decode, 0, $ivlen);

        $hmac = substr($decode, $ivlen, $sha2len = 32);

        $ciphertext_raw = substr($decode, $ivlen + $sha2len);

        $plaintext = openssl_decrypt($ciphertext_raw, $method, $key, OPENSSL_RAW_DATA, $iv);

        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, true);

        return hash_equals($hmac, $calcmac) ? $plaintext : '';
    }

    /**
     * Generate password hash
     *
     * @param string $password
     *
     * @param string|int $type
     *
     * @param int $cost
     *
     * @return string|null
     */
    public static function createPassword(string $password, $type = PASSWORD_BCRYPT, int $cost = 12) : ?string {
        $hash = password_hash($password, $type, ['cost' => $cost]);

        return $hash === false ? null : $hash;
    }

    /**
     * Verification password hash
     *
     * @param string $password
     *
     * @param string $hash
     *
     * @return bool
     */
    public static function verifyPassword(string $password, string $hash) : bool {
        return password_verify($password, $hash);
    }
}

?>