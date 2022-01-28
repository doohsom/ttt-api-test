<?php

use app\controller\GameController;

include_once __DIR__ . '/app/controller/GameController.php';

//print_r($res);
$items = new GameController();

$game_id = $_GET['game_id'] ?? die();
$stmt = $items->read($game_id);

print_r($stmt);
