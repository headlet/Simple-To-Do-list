<?php
require_once __DIR__ . '/../../app/Controller/TaskManagerController.php';
$taskManager = new TaskManagerController();
$tasks = $taskManager->index();
?>

<section class="min-h-screen bg-slate-100">

    <!-- HEADER -->
    <div class="w-full bg-white px-6 py-4">
        <h1 class="text-2xl font-bold text-blue-600 text-center">
            My To-Do Task
        </h1>
    </div>

    <!-- TASK LIST -->
    <div class="max-w-2xl mx-auto mt-6">
        <ul class="space-y-4">

            <?php foreach ($tasks as $task): ?>
                <li class="flex items-center justify-between bg-white shadow-sm border rounded-lg px-4 py-3 hover:shadow-md transition">

                    <span class="text-slate-700 font-medium">
                        <?= $task['title'] ?>
                    </span>

                    <span class="flex items-center gap-3">

                        <a href="index.php?view=edit&id=<?= $task['id'] ?>"
                            class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="delete.php?id=<?= $task['id'] ?>"
                            class="text-red-500 hover:text-red-700 delete-btn">
                            <i class="fa-solid fa-trash"></i>
                        </a>

                        <i class="fa-solid fa-circle-check 
                        <?= ($task['status'] ?? '') === 'complete' ? 'text-green-500' : 'text-red-500' ?>">
                        </i>

                    </span>

                </li>
            <?php endforeach; ?>

        </ul>
    </div>

    <!-- Add Task -->
    <div id="taskModal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm">

        <div class="flex items-center justify-center min-h-screen">

            <div class="bg-white w-full max-w-sm rounded-2xl shadow-lg p-6 relative">

                <!-- Close Button -->
                <button id="closeTaskModal"
                    class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-xl">
                    ✕
                </button>

                <h2 class="text-2xl font-bold text-blue-600 text-center mb-4">
                    Add Task
                </h2>

                <form action="" method="post" class="space-y-4">

                    <input type="text" name="title"
                        placeholder="Enter task..."
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400"
                        required>

                    <input type="text" name="status"
                        value="pending"
                        readonly
                        class="w-full bg-gray-100 border rounded-lg px-3 py-2 text-gray-500">

                    <button type="submit"
                        class="w-full bg-teal-500 hover:bg-teal-600 text-white py-2 rounded-lg">
                        Save Task
                    </button>

                </form>

            </div>

        </div>
    </div>

</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {

        $("#openTaskModal").click(function() {
            $("#taskModal").fadeIn(200).removeClass("hidden");
        });

        $("#closeTaskModal").click(function() {
            $("#taskModal").fadeOut(200);
        });

    });
</script>