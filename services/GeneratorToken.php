<?php

namespace app\services;

class GeneratorToken
{
    public function __construct($algorithm = 'md5', $length = 8, $url)
    {
        /** Длина токена */
        $this->length = $length;

        //$cleanUrl = parse_url($url, PHP_URL_PATH);
        /** Длинный url */
        $this->url = $url;

        /** Выбор алгоритма
         * Генерация токена
         */
        switch ($algorithm)
        {
            case 'md5':
                $this->token = $this->generate_hash_md5();
                break;
            case 'sha256':
                $this->token = $this->generate_hash_sha256();
                break;
            case 'crc32':
                $this->token = $this->generate_hash_crc32();
                break;
            default:
                $this->error = ['hash' => 'Не правильно задан алгоритм шифрования.'];
        }
    }

    /** Алгоритм md5 */
    function generate_hash_md5()
    {
        return substr(md5($this->url), 0, $this->length);
    }

    /** Алгоритм sha256 */
    function generate_hash_sha256() {
        return substr(hash("sha256", $this->url), 0, $this->length);
    }

    /** Алгоритм crc32 */
    function generate_hash_crc32() {
        $crc32_hash = crc32($this->url);
        return substr(dechex($crc32_hash), 0, $this->length);
    }

    /** Запрос токена */
    public function getToken()
    {
        return $this->token;
    }
}
