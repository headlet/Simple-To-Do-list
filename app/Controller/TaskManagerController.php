<?php
require_once __DIR__ . '/../Models/task.php';
class TaskManagerController
{
    private $storageFile;

    public function __construct()
    {
        $this->storageFile = __DIR__ . '/../../storage/task.json';
    }

    public function index()
    {
        if (!file_exists($this->storageFile)) {
            file_put_contents($this->storageFile, json_encode([]));
        }
        $data = file_get_contents($this->storageFile);
        return json_decode($data, true) ?? [];
    }

    public function create() {}

    public function update() {}

    public function delete() {}
}
