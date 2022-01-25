Create Game table
    id,user_x, user_o, status, created_at, updated_at
Create User table
    id, username, email, wins, loss, draw, created_at, updated_at
Create Game progress table
    id, game_id, positions, user_id


Create game by settting usernames

Check if tile is tile array
Check if user is the last one to play
Check if user has won


Store Play
    validdate input
    valid tiles
    required field
    check if user is meant to play i.e turn
    check winner
    if(winner) : return message
    continue

GameController
    storeUser()
    emptyPositions
    storePositions
    list all games(active, inactive)
    getGameById

GameService
    validateStoreGame
    validateTiles
    validateRequiredFields
    checkTurn
    checkWinner(vertical, horizontal, diagonal)

Helper
    vertical
    horizontal
    diagoinal
    
    get recordCOuntByGame()