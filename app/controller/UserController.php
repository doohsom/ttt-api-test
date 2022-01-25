<?php

namespace app\controller;

use app\Model;

require 'vendor\autoload.php';

include_once 'app\Model.php';
include_once 'app\helpers\helpers.php';

class UserController {


    public $username;
    public $email;
    public $wins;
    public $loss;
    public $draw;
    public $created_at;
    public $updated_at;

    private $db_table = "users";
    public $required = ['username', 'email'];
    /**
     * @var Model
     */
    private $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function store($data)
    {
        $data = validateInput($data);
        $requiredField = requiredFields($data, $this->required);
        if(!empty($requiredField)) {
            return ['status' => 'failed', 'message' => 'Validation error', 'data' => $requiredField];
        }else{
            $app = $this->model->insert($this->db_table, $data);
            if($app){
                return ['status' => 'success', 'message' => 'User created'];
            }
            return ['status' => 'failed', 'message' => 'User not created'];
        }
    }

    public function read()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }


}