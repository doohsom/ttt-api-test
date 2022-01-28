<?php

namespace app\controller;


include_once 'app/Model.php';
include_once 'app/helpers/helpers.php';
include_once 'app/traits/ResponseTrait.php';

use app\Model;
use app\traits\ResponseTrait;


class GameController {

    use ResponseTrait;
    private $db_table = "game";

    private $model;
    public $required = ['user_x', 'user_o'];


    public function __construct()
    {
        $this->model = new Model();
    }

    /**
     * Trims and Validates input
     * Store Usernames
     *
     */
    public function storeUser($data) : string
    {
        $data = validateInput($data);
        $requiredField = requiredFields($data, $this->required);
        if(!empty($requiredField)) {
            $this->failed('Validation error', 422, $requiredField);
        }else{
            $app = $this->model->insert($this->db_table, $data);
            if($app){
                $this->success('User created');
            }else{
                $this->failed('Unable to create user');
            }
        }
    }

    /**
     * Get all games if they are completed or active by status
     * status = ACTIVE OR COMPLETED
     *
     */

    public function getAll(string $status) : string
    {
        if(!in_array($status, ['COMPLETED', 'ACTIVE'])){
            $this->validation('Invalid status string');
        }
        $where = 'status';
        $fields = "*";
        $whereValue = "'".$status."'";
        $app = $this->model->selectWithWhere($this->db_table, $fields, $where, $whereValue);
        if($app){
            $this->success('Data retrieved successfully', 200, $app);
        }else{
            $this->failed('Unable to retrieve data');
        }
    }

    /**
     * Get the content of a game by id
     *
     */

    public function read(int $id) : string
    {
        $where = 'id';
        $whereValue = $id;
        $fields = "*";
        $app = $this->model->selectWithWhere($this->db_table, $fields, $where, $whereValue);
        if($app){
            $this->success('Data retrieved successfully', 200, $app);
        }else{
            $this->failed('Unable to retrieve data');
        }
    }
}