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
        <ul class="space-y-3">

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

    <!-- ADD TASK -->
    <div class="flex justify-center mt-10 px-4">

        <div class="w-full max-w-sm bg-white shadow-lg rounded-2xl p-6">

            <div class="flex items-center justify-between mb-6">
                <a href="index.php"
                    class="text-sm text-white bg-blue-600 hover:bg-blue-700 transition px-3 py-2 rounded-lg">
                    ← Back Home
                </a>


            </div>

            <form action="" method="post" class="space-y-5">
                <h2 class="text-2xl font-bold text-blue-600 text-center">Add Task</h2>
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-600 mb-1">
                        Task Title
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        placeholder="Enter your task..."
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-400"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">
                        Status
                    </label>
                    <input
                        type="text"
                        name="status"
                        value="pending"
                        readonly
                        class="w-full bg-slate-100 border border-slate-200 rounded-lg px-3 py-2 text-slate-500">
                </div>

                <button
                    type="submit"
                    class="w-full bg-teal-500 hover:bg-teal-600 text-white font-medium py-2 rounded-lg transition">
                    Save Task
                </button>

            </form>

        </div>

    </div>

</section>