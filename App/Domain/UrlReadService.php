<?php


namespace App\Domain;


use App\Infrastructure\UrlEncoderRepository;
use App\Infrastructure\UrlReadRepository;
use App\Infrastructure\UrlWriteRepository;

class UrlReadService
{
    private $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";

    /**
     * @var UrlEncoderRepository
     */
    private $encodeRepository;
    /**
     * @var UrlReadRepository
     */
    private $readRepository;
    /**
     * @var UrlWriteRepository
     */
    private $writeRepository;

    public function __construct()
    {
        $this->encodeRepository = new UrlEncoderRepository();
        $this->readRepository = new UrlReadRepository();
        $this->writeRepository = new UrlWriteRepository();
    }

    public function shortToUrl($url) {
        if(!preg_match("|[" . $this->chars . "]+|", $url)) {
            return ['status' => 'error','message' => 'Url format is not right'];
        }


        $data = $this->readRepository->getDataForShortUrl($url);
        if($data[0]) {
            $this->writeRepository->incrementCounter($data[0]);
        }
        return $data[1];
    }

    public function getCounter(string $url) {
        return $this->readRepository->getCounter($url);
    }
}