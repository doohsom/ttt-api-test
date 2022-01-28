<?php

use app\controller\GameController;

include_once __DIR__ . '/app/controller/GameController.php';

//print_r($res);
$items = new GameController();

$status = $_GET['status'] ?? die();
$stmt = $items->getAll($status);

print_r($stmt);
