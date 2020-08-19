<?php


namespace App\Domain;


use App\Infrastructure\DB;
use App\Infrastructure\UrlReadRepository;
use App\Infrastructure\UrlShortenerRepository;
use App\Infrastructure\UrlWriteRepository;

class UrlWriteService
{
    private $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
    /**
     * @var UrlShortenerRepository
     */
    private $shortenerRepository;
    /**
     * @var UrlWriteRepository
     */
    private $writeRepository;
    /**
     * @var UrlReadRepository
     */
    private $readRepository;

    public function __construct()
    {
        $this->shortenerRepository = new UrlShortenerRepository();
        $this->writeRepository = new UrlWriteRepository();
        $this->readRepository = new UrlReadRepository();
    }

    public function writeShortUrL(string $url, string $dateEnd) {
        if(!$this->readRepository->urlExists($url)) {
            return ['status' => 'error','message' => 'Url does not exists'];
        }
        if($this->readRepository->urlExistsDb($url)) {
           return ['status' => 'error','message' => 'Url exist in database'];
        }

        return $this->addUrlToBase($url,$dateEnd);

    }


    private function addUrlToBase(string $url, string $dateEnd) {
        $db = (DB::getInstance())->getConnection();
        $db->begin_transaction();
        try {
            $id = $this->writeRepository->insertUrl($url);
            $url = $this->shortenerRepository->shortUrl($id,$url,$this->chars);
            $this->writeRepository->insertShortUrl($id,$url,$dateEnd);
            $db->commit();
            $response = ['status' => 'success','message' => $url];
        } catch (\Exception $e) {
            $db->rollback();
            var_dump(['status' => 'error','message' => $e->getMessage()]);
        }
        return $response;
    }
}