copy all files to your own repository
spin-up docker
run docker-compose up --build
run npm i
website runs at http://localhost:8888
phpmyadmin runs at http://localhost:8080
Import tic-tac-toe.sql

The project contains 5 endpoint
:/api/store-game
:/api/empty-positions
:/api/store-location
:/api/list-games?status=COMPLETED
:/api/read-game?game_id=1

AND 5 UIs
:/
:/list-empty-positions
:/post-locations
:/all-games
:/read-game

2 Controllers
GameController
    storeUser() : string --creates a game and stores user
    getAll() : string -- get games by status['COMPLETED','ACTIVE']
    read() : string -- get a game by id
GameProgress.php
    emptyPositions() : string -- returns a list of empty positions available during a game
    getGameProgress() : string -- returns an array of positions played by a user
    checkTurn() : bool -- check if the user's play is a valid play or his turn
    getGameCount() : int -- return number of turns by a player
    getPlayerWin() : bool -- return true if a user has won a game
    getArrayPosition() : array -- returns the list of positions
    checkUser() : bool -- returns if user is a valid user for the game
    checkCompleteGame() : bool -- check if game is complete of active
    store() : string -- stores position for a turn
    getPositions() : array -- returns array of positions
helpers.php
    validateInput() -- trims input
    requiredFields() -- check if field is filled
    validTile() -- check if tile is valid
    isVerticalWin() -- check if win is vertical
    isHorizontalWin() -- check if win is horizontal 
    isDiagonalWin() -- check if win is diagonal
