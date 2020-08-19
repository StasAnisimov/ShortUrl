<?php


namespace App\Infrastructure;


class UrlWriteRepository
{
    public function insertUrl(string $url)
    {
        $now = date('Y-m-d h:i:s');
        $query = "INSERT INTO short_url (long_url,date_created) VALUES ('$url','$now')";
        $db = (DB::getInstance())->getConnection();
        $db->query($query);
        return $db->insert_id;
    }

    public function insertShortUrl(int $id,string $url, string $dateEnd) : void
    {
        $query = "UPDATE short_url SET short_code = '$url', date_end = '$dateEnd' WHERE id = '$id'";
        $db = (DB::getInstance())->getConnection();
        $db->query($query);
    }

    public function incrementCounter(int $id) {
        $query = "UPDATE short_url SET counter = counter + 1 WHERE id = '$id'";
        $db = (DB::getInstance())->getConnection();
        $db->query($query);
    }
}