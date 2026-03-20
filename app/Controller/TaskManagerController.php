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

    public function create($title, $status)
{
    try {
        $tasks = $this->index();

        $newId = empty($tasks) ? 1 : end($tasks)['id'] + 1;

        $task = new Task($newId, $title, $status);

        $tasks[] = $task->toArray();

        file_put_contents($this->storageFile, json_encode($tasks, JSON_PRETTY_PRINT));

        return true;

    } catch (Exception $e) {
        return false;
    }
}

    public function update() {}

    public function delete() {}
}
