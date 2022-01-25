<?php

use app\controller\GameController;

include 'vendor/autoload.php';

include_once 'app\controller\GameController.php';

//print_r($res);
$items = new GameController();

$status = $_GET['status'] ?? die();
$stmt = $items->getAll($status);

print_r($stmt);
