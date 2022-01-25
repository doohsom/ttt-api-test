<?php

namespace app\controller;

use app\Model;
use app\traits\ResponseTrait;

require 'vendor\autoload.php';

include_once 'app\Model.php';
include_once 'app\helpers\helpers.php';
include_once 'app\traits\ResponseTrait.php';

class GameProgress {

    use ResponseTrait;
    // Table
    private $db_table = "game_progress";

    private $model;
    public $required = ['game_id', 'positions', 'user_id'];
    public $tiles = [11, 12, 13, 21, 22, 23, 31, 32, 33];

    public function __construct()
    {
        $this->model = new Model();
    }


    public function emptyPositions($game_id)
    {
        $app = $this->getPositions($game_id);
        if($app){
            $this->success('Data retrieved', 200, $app);
        }else{
            $this->failed('Data not found');
        }
    }

    public function getAll()
    {
        $app = $this->model->selectAll($this->db_table);
        $this->success($app);
    }

    public function readGame($game_id)
    {
        $where = 'id';
        $whereValue = $game_id;
        $fields = '*';
        $app = $this->model->selectWithWhere($this->db_table, $fields, $where, $whereValue);
        $this->success($app);
    }

    public function getGameProgress($game_id, $player)
    {
        $condition = ' WHERE game_id='.$game_id.' AND user_id='."'".$player."'";
        $fields = '*';
        $app = $this->model->selectWithMultipleWhere($this->db_table, $fields, $condition);
        return $app;
    }

    public function checkTurn($game_id, $turn)
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
            return true;
        }else{
            return true;
        }
    }

    public function getGameCount($game_id, $player)
    {
        $count = $this->getGameProgress($game_id, $player);
        return count($count);
    }

    public function getPlayerWin($game_id, $player, $current)
    {
        if($this->getGameCount($game_id, $player) >= 3){
            $progress = $this->getGameProgress($game_id, $player);

            $playerPosition = $this->getArrayPosition($progress);
            return isVerticalWin($playerPosition, $current) || isHorizontalWin($playerPosition, $player) || isDiagonalWin($playerPosition);
        }
    }

    public function getArrayPosition($positions)
    {
        $data = array();
        foreach ($positions as $pos){
            $data[] = $pos->positions;
        }
        return array_values($data);
    }


    public function store($data)
    {
        $data = validateInput($data);
        $validTile = validTile($data['positions'], $this->tiles);
        $requiredField = requiredFields($data, $this->required);
        if(!$validTile){
            $this->failed('Invalid tile value');
        }else if(!empty($requiredField)) {
            $this->validation('Validation error', 422, $requiredField);
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
                    return ['status' => 'failed', 'message' => 'Location not created'];
                }
            }

        }
    }



    public function update()
    {

    }

    public function delete()
    {

    }

    private function getPositions($game_id)
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