<?php


namespace App\UI;

use App\Domain\UrlReadService;
use App\Domain\UrlWriteService;

class AppController
{
    /**
     * @var UrlWriteService
     */
    private $writeService;
    /**
     * @var UrlReadService
     */
    private $readService;

    public function __construct()
    {
        $this->writeService = new UrlWriteService();
        $this->readService = new UrlReadService();
    }

    public function makeUrlShort() {
        $valid = filter_var($_POST['url'],FILTER_VALIDATE_URL,FILTER_FLAG_HOST_REQUIRED);
        if(!$valid) {
            $response = ['status' => 'error','message' => 'Url has no valid format','data' => ''];
        } else {
            $response = $this->writeService->writeShortUrl((string) $_POST['url'],(string) $_POST['date_end']);
        }
        return $response;
    }


    public function readShortUrl() {
        if(isset($_GET['c'])) {
            return $this->readService->shortToUrl($_GET['c']);
        }
    }

    public function getCounter() {
        return $this->readService->getCounter((string)$_GET['url']);
    }

}