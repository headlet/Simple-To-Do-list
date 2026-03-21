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

    public function httpRequest($action)
    {
        switch ($action) {
            case 'create':
                return $this->handleCreateForm();
                break;

            case 'edit':
                return $this->handleEditForm();
                break;

            case 'delete':
                return $this->handleDeleteForm();
                break;

            default:
                return $this->index();
        }
    }


    public function handleCreateForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($_POST['title'] === '') {
                $_SESSION['formCreateError'] = [
                    'message' => 'Title empty.. Please add title'
                ];
                header("Location: index.php");
                exit;
            }

            if (!in_array($_POST['status'], ['pending', 'complete'])) {
                $_SESSION['formCreateError'] = [
                    'message' => 'Please select status.'
                ];
                header("Location: index.php");
                exit;
            }

            if (isset($_POST['title'], $_POST['status'])) {

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
        }
    }

    public function create($title, $status)
    {
        try {
            $tasks = $this->index();

            $newId = empty($tasks) ? 1 : end($tasks)['id'] + 1;

            $task = new Task($newId, htmlspecialchars(trim($title)), $status);

            $tasks[] = $task->toArray();

            file_put_contents($this->storageFile, json_encode($tasks, JSON_PRETTY_PRINT));

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function handleEditForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty(trim($_POST["title"]))) {
                $_SESSION['formEditError'] = [
                    'message' => 'Title empty.. Please add title'
                ];

                header("Location: index.php");
                exit;
            }
            if (!in_array($_POST['status'], ['pending', 'complete'])) {
                $_SESSION['formEditError'] = [
                    'message' => 'Invalid Status'
                ];
                header("Location: index.php");
                exit;
            }
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
    }

    public function update($id, $title, $status)
    {
        try {
            $tasks = $this->index();

            foreach ($tasks as $key => $task) {
                if ($task['id'] == $id) {
                    $tasks[$key]['title'] = htmlspecialchars(trim($title));
                    $tasks[$key]['status'] = $status;
                    file_put_contents(
                        $this->storageFile,
                        json_encode($tasks, JSON_PRETTY_PRINT)
                    );

                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function handleDeleteForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['id'])) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Missing task ID'
                ];
                header("Location: index.php");
                exit;
            }

            $result = $this->removeTask((int)$_POST['id']);

            $_SESSION['flash'] = [
                'type' => $result ? 'success' : 'error',
                'message' => $result ? 'Task deleted successfully!' : 'Failed to delete task!'
            ];

            header("Location: index.php");
            exit;
        }
    }

    private function removeTask($id)
    {
        try {
            $tasks = $this->index();
            $originalCount = count($tasks);
            $tasks = array_filter($tasks, fn($task) => $task['id'] !== $id);
            if (count($tasks) === $originalCount) {
                return false;
            }

            file_put_contents(
                $this->storageFile,
                json_encode(array_values($tasks), JSON_PRETTY_PRINT)
            );

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
