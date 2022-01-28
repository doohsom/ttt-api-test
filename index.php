<?php
namespace app;

$request = $_SERVER['REQUEST_URI'];
$parameters = '';
if(strpos($request,'?')){
    $explode = explode('?', $request);
    $parameters = '?'.$explode[1];
}


switch ($request) {
    case '/' :
        require __DIR__ . '/app/views/create-user.php';
        break;
    case '/list-empty-positions' :
        require __DIR__ . '/app/views/list-empty-positions.php';
        break;
    case '/post-locations' :
        require __DIR__ . '/app/views/post-form-location.php';
        break;
    case '/all-games' :
        require __DIR__ . '/app/views/list-active-games.php';
        break;
    case '/read-game' :
        require __DIR__ . '/app/views/game-by-id.php';
        break;
    case '/api' :
        require __DIR__ . '/store-game.php';
        break;
    case '/api/list-games'.$parameters :
        require __DIR__ . '/list-games.php';
        break;
    case '/api/empty-positions'.$parameters :
        require __DIR__ . '/empty-positions.php' ;
        break;
    case '/api/read-game'.$parameters :
        require __DIR__ . '/read-game.php';
        break;
    case '/api/store-location' :
        require __DIR__ . '/store-location.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/app/views/404.php';
        break;
}