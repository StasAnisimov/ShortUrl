<?php


namespace App\Infrastructure;


class UrlShortenerRepository
{

    public function shortUrl(int $id,string $url,string $chars): string
    {
        $id = intval($id);
        $length = strlen($chars);
        $code = "";
        while ($id > $length - 1) {
            $code = $chars[fmod($id,$length)] . $code;
            $id = floor($id / $length);
        }
        return $chars[$id] . $code;
    }
}