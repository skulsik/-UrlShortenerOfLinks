<?php

namespace app\services;

class GeneratorShortLink
{
    public function __construct($model, $algorithm = 'md5', $length = 8)
    {
        /** Длина токена */
        $this->length = $length;
        /** Ошибки */
        $this->error = null;
        /** Токен */
        $this->short_link = null;

        /** Разбирает url ссылку, на массив */
        $url_array = parse_url($model->link);
        /** Собирает хост */
        $this->host = $url_array['scheme'].'://'.$url_array['host'];

        if ($url_array['path'])
        {
            /** Строка - путь после хоста */
            $this->url_path = $url_array['path'];


            /** Выбор алгоритма
             * Генерация токена
             */
            switch ($algorithm)
            {
                case 'md5':
                    $this->short_link = $this->generate_hash_md5();
                    break;
                case 'sha256':
                    $this->short_link = $this->generate_hash_sha256();
                    break;
                case 'crc32':
                    $this->short_link = $this->generate_hash_crc32();
                    break;
                default:
                    $this->error = ['hash' => 'Не правильно задан алгоритм шифрования.'];
            }
        } else $this->error = ['url' => 'Не правильно задан url. Введите ссылку после домена (пример https://домен.ru/ваша_ссылка).'];
    }

    /** Алгоритм md5 */
    function generate_hash_md5()
    {
        return substr(md5($this->url_path), 0, $this->length);
    }

    /** Алгоритм sha256 */
    function generate_hash_sha256() {
        return substr(hash("sha256", $this->url_path), 0, $this->length);
    }

    /** Алгоритм crc32 */
    function generate_hash_crc32() {
        $crc32_hash = crc32($this->url_path);
        return substr(dechex($crc32_hash), 0, $this->length);
    }

    /** Запрос токена */
    public function get_short_link()
    {
        return ['errors' => $this->error, 'host' => $this->host, 'short_link' => $this->short_link];
    }
}
