<?php

use app\controller\GameProgress;

include_once __DIR__ . '/app/controller/GameProgress.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$item = new GameProgress();

$post = [
    'game_id' => $_POST['game_id'],
    'user_id' => $_POST['user_id'],
    'positions' => $_POST['positions']
];
$data = isset($_POST['game_id']) ? $post: (array)json_decode((file_get_contents("php://input"))) ;


$store = $item->store($data);

print_r($store);
