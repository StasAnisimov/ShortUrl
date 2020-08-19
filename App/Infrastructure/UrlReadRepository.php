<?php


namespace App\Infrastructure;


class UrlReadRepository
{
    public function urlExists(string $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }

    public function urlExistsDb(string $url) {
        $dateNow =date ('Y-m-d h:i:s');
        $query = "SELECT id,short_code FROM short_url WHERE long_url = '$url' AND date_end > '$dateNow'";
        $db = (DB::getInstance())->getConnection();
        return $db->query($query)->fetch_row()[0];
    }

    public function getDataForShortUrl(string $url) {
        $query = "SELECT id,long_url FROM short_url WHERE short_code = '$url'";
        $db = (DB::getInstance())->getConnection();
        return $db->query($query)->fetch_row();
    }

    public function getCounter(string $url) {
        $dateNow = date ('Y-m-d h:i:s');
        $query = "SELECT counter FROM short_url WHERE short_code = '$url' AND date_end > '$dateNow'";
        $db = (DB::getInstance())->getConnection();
        return $db->query($query)->fetch_row()[0];
    }
}