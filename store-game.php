<?php

use app\controller\GameController;


include_once __DIR__ . '/app/controller/GameController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$item = new GameController();
$post = [
    'user_x' => $_POST['user_x'],
    'user_o' => $_POST['user_o']
];
$data = isset($_POST['user_x']) ? $post: (array)json_decode((file_get_contents("php://input"))) ;
$data['status'] = 'ACTIVE';
$data['created_at'] = date('Y-m-d H:i:s');
$data['updated_at'] = date('Y-m-d H:i:s');

$store = $item->storeUser($data);

print_r($store);
