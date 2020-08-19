<?php

require 'config/autoload.php';

use App\UI\AppController;

$controller = new AppController();
echo json_encode($controller->makeUrlShort());