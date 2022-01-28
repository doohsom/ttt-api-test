<?php
use app\controller\GameProgress;

include_once __DIR__ . '/app/controller/GameProgress.php';


$items = new GameProgress();

$game_id = isset($_GET['game_id']) ?: die();
$stmt = $items->emptyPositions($game_id);


print_r($stmt);
