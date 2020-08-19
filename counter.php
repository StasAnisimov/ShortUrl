<?php

require 'config/autoload.php';

use App\UI\AppController;

$controller = new AppController();
$counter = $controller->getCounter();
echo "Количество переходов . $counter";