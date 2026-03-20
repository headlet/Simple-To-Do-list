<?php
require_once __DIR__ . '/../Models/task.php';
class TaskManagerController
{
    private $storageFile;

    public function __construct()
    {
        $this->storageFile = __DIR__ . '/../../storage/task.json';
    }

    public function httpRequest($action)
    {
        switch ($action) {
            case 'create':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    $result = $this->create($_POST['title'], $_POST['status']);

                    if ($result === true) {
                        $_SESSION['flash'] = [
                            'type' => 'success',
                            'message' => 'Task added successfully!'
                        ];
                    } else {
                        $_SESSION['flash'] = [
                            'type' => 'error',
                            'message' => 'Something went wrong while adding task!'
                        ];
                    }

                    header("Location: index.php");
                    exit;
                }
                break;

            case 'edit':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                    $result = $this->update(
                        $_POST['id'],
                        $_POST['title'],
                        $_POST['status']
                    );

                    if ($result) {
                        $_SESSION['flash'] = [
                            'type' => 'success',
                            'message' => 'Task updated successfully!'
                        ];
                    } else {
                        $_SESSION['flash'] = [
                            'type' => 'error',
                            'message' => 'Failed to update task!'
                        ];
                    }

                    header("Location: index.php");
                    exit;
                }
                break;
        }
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


    public function update($id, $title, $status)
    {
        try {
            $tasks = $this->index();

            foreach ($tasks as $key => $task) {

                if ($task['id'] == $id) {

                    $tasks[$key]['title'] = htmlspecialchars(trim($title));

                    if (!in_array($status, ['pending', 'complete'])) {
                        throw new Exception("Invalid status");
                    }

                    $tasks[$key]['status'] = $status;

                    file_put_contents(
                        $this->storageFile,
                        json_encode($tasks, JSON_PRETTY_PRINT)
                    );

                    return true; // STOP immediately
                }
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete() {}
}
