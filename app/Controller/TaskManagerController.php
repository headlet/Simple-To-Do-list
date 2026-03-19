<?php
require_once __DIR__ . '/../Models/task.php';
class TaskManagerController {
    private $storageFile;

    public function __construct()
    {
        $this->storageFile = require __DIR__ . '/../../storage/task.json';
    }

    public function index(){

    }

    public function create(){

    }

    public function update(){

    }

    public function delete(){
        
    }

}
