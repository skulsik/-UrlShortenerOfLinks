<?php

namespace app\services;

use app\models\ShortLinks;

class GeneratorShortLink
{
    public function __construct(object $model, string $algorithm = 'md5', int $length = 8)
    {
        /** Длина токена */
        $this->length = $length;
        /** Ошибки */
        $this->error = null;
        /** Токен */
        $this->short_link = null;
        /** Ссылка */
        $this->url_path = null;
        /** Алгоритм */
        $this->algorithm = $algorithm;

        /** Разбирает url ссылку, на массив */
        $this->url_array = parse_url($model->link);
        /** Собирает хост */
        $this->host = $this->url_array['scheme'].'://'.$this->url_array['host'];
    }

    protected function search_short_link()
    {
        /** Поиск короткой ссылки в БД */
        return ShortLinks::find()->where(['link' => $this->short_link])->one();
    }

    public function generate_hash_link()
    {
        if ($this->url_array['path'])
        {
            /** Строка - путь после хоста */
            $this->url_path = $this->url_array['path'];


            /** Выбор алгоритма
             * Генерация токена
             */
            switch ($this->algorithm)
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

        /** Если в бд существует такая ссылка, запуск рекурсии */
        if ($this->search_short_link()) $this->generate_hash_link();
    }

    /** Алгоритм md5 */
    protected function generate_hash_md5()
    {
        return substr(md5($this->url_path), 0, $this->length);
    }

    /** Алгоритм sha256 */
    protected function generate_hash_sha256() {
        return substr(hash("sha256", $this->url_path), 0, $this->length);
    }

    /** Алгоритм crc32 */
    protected function generate_hash_crc32() {
        $crc32_hash = crc32($this->url_path);
        return substr(dechex($crc32_hash), 0, $this->length);
    }

    /** Запрос токена */
    public function get_short_link()
    {
        return ['errors' => $this->error, 'host' => $this->host, 'short_link' => $this->short_link];
    }
}
