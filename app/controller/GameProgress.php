<?php

namespace app\controller;

include_once 'app/Model.php';
include_once 'app/helpers/helpers.php';
include_once 'app/traits/ResponseTrait.php';

use app\Model;
use app\traits\ResponseTrait;

class GameProgress {

    use ResponseTrait;
    // Table
    private $db_table = "game_progress";

    private $model;
    /**
     * Required fields for validation
     *
     */
    public $required = ['game_id', 'positions', 'user_id'];

    /**
     * Allowed tiles value
     *
     */
    public $tiles = [11, 12, 13, 21, 22, 23, 31, 32, 33];

    public function __construct()
    {
        $this->model = new Model();
    }


    /**
     * @param int $game_id
     * @return string
     * Get the empty position available to be played
     */
    public function emptyPositions(int $game_id) : string
    {
        $app = $this->getPositions($game_id);
        if($app){
            $this->success('Data retrieved', 200, $app);
        }else{
            $this->failed('Data not found');
        }
    }

    /**
     * @param int $game_id
     * @param string $player
     * @return array
     * Returns an array of positions played by a user
     *
     */
    public function getGameProgress(int $game_id, string $player): array
    {
        $condition = ' WHERE game_id='.$game_id.' AND user_id='."'".$player."'";
        $fields = '*';
        $app = $this->model->selectWithMultipleWhere($this->db_table, $fields, $condition);
        return $app;
    }

    /**
     * @param int $game_id
     * @param string $turn
     * @return bool
     * Check if the user has a valid turn
     */
    public function checkTurn(int $game_id, string $turn): bool
    {
        $where = 'game_id';
        $whereValue = $game_id;
        $fields = '*';
        $app = $this->model->selectWithWhere('game_progress', $fields, $where, $whereValue);
        if($app){
            $latest = end( $app);

            if($latest->user_id === $turn){
                return false;
            }
        }
        return true;
    }

    /**
     * @param int $game_id
     * @param string $player
     * @return int
     * Returns number of turns by current player
     */
    public function getGameCount(int $game_id, string $player): int
    {
        $count = $this->getGameProgress($game_id, $player);
        return count($count);
    }


    /**
     * @param $game_id
     * @param $player
     * @param $current
     * @return bool
     * Checks if the current player has won the game
     */
    public function getPlayerWin($game_id, $player, $current) : bool
    {
        if($this->getGameCount($game_id, $player) >= 3){
            $progress = $this->getGameProgress($game_id, $player);

            $playerPosition = $this->getArrayPosition($progress);
            return isVerticalWin($playerPosition, $current) || isHorizontalWin($playerPosition, $player) || isDiagonalWin($playerPosition);
        }
        return false;
    }

    /**
     * @param $positions
     * @return array
     * Returns an array of column 'positions'only
     */
    public function getArrayPosition($positions): array
    {
        $data = array();
        foreach ($positions as $pos){
            $data[] = $pos->positions;
        }
        return array_values($data);
    }


    /**
     * @param int $game_id
     * @param string $player
     * @return bool
     * check if user is a valid user
     */
    public function checkUser(int $game_id, string $player) : bool
    {
        $condition = ' WHERE id='.$game_id;
        $fields = '*';
        $app = $this->model->selectWithMultipleWhere('game', $fields, $condition);
        if($app[0]->user_o === $player || $app[0]->user_x === $player){
            return true;
        }
        return false;
    }

    public function checkCompleteGame(int $game_id) : bool
    {
        $condition = ' WHERE id='.$game_id;
        $fields = '*';
        $app = $this->model->selectWithMultipleWhere('game', $fields, $condition);
        if($app[0]->status === 'COMPLETED'){
            return true;
        }
        return false;
    }



    /**
     * @param $data
     * Validates input
     * Validates tile
     * Check if required fields are filled
     * Checkturn() validates if the currnt user has the right turn
     * Duplicate position checks if there is no duplication position in current game
     * Player win checks if player has won, it is triggered after game 3
     * Game is updated as completed and user is assigned as winner
     */
    public function store($data) : string
    {
        $data = validateInput($data);
        $validTile = validTile($data['positions'], $this->tiles);
        $requiredField = requiredFields($data, $this->required);
        if($this->checkCompleteGame($data['game_id'])){
            $this->failed('Game has ended');
        }else if(!$validTile){
            $this->failed('Invalid tile value');
        }else if(!empty($requiredField)) {
            $this->validation('Validation error', 422, $requiredField);
        }else if(!$this->checkUser($data['game_id'], $data['user_id'])) {
            $this->failed('Invalid User/Game');
        }else{
            $checkTurn = $this->checkTurn($data['game_id'], $data['user_id']);
            if(!$checkTurn){
                $this->failed('Wrong turn');
            }else{
                $duplicate = $this->getPositions($data['game_id']);
                if(!in_array($data['positions'], $duplicate)){
                    $this->failed('Duplicate position');
                }
                $app = $this->model->insert($this->db_table, $data);
                if($app){
                    $win = $this->getPlayerWin($data['game_id'], $data['user_id'], $data['positions']);
                    if($win){
                        $clause = "status="."'COMPLETED'".",winner="."'".$data['user_id']."'";
                        $where = "id=".$data['game_id'];
                        $this->model->update('game', $clause, $where);
                        $this->success('Player '.$data['user_id']. ' won');
                    }else{
                        $this->success('location created');
                    }
                }else{
                    $this->failed('Unable to create location');
                }
            }

        }
    }

    private function getPositions($game_id) : array
    {
        if(empty($game_id) || !isset($game_id)) {
            return ['status' => 'failed', 'message' => 'Game Id is not set'];
        }
        $where = 'game_id';
        $whereValue = $game_id;
        $fields = 'positions';
        $positions = $this->model->selectWithWhere($this->db_table,$fields, $where, $whereValue);
        $data = array();
        foreach ($positions as $pos){
            $data[] = $pos->positions;
        }
        return array_values(array_diff($this->tiles,$data));
    }
}