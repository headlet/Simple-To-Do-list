<?php
require_once __DIR__ . '/../Models/task.php';
class TaskManagerController {
    private $storageFile;

    public function __construct()
    {
        $this->storageFile = require __DIR__ . '/../../storage/task.json';
    }

    public function index(){
        if(file_exists($this->storageFile)){
            file_put_contents($this->storageFile, json_encode([]));
            }

        return json_decode(file_get_contents($this->storageFile, true));
    }

    public function create(){

    }

    public function update(){

    }

    public function delete(){
        
    }

}
