<?php
require_once __DIR__ . '/../../app/Controller/TaskManagerController.php';
$taskManager = new TaskManagerController();
$tasks = $taskManager->index();
?>
<section class="w-full h-full">
    <div class="w-full bg-white px-6 py-4">
        <h1 class="text-2xl font-bold text-blue-600 text-center">
            My To-Do Task
        </h1>
    </div>
    <div class="max-w-2xl mx-auto mt-6">
        <ul class="space-y-3">

            <?php foreach ($tasks as $task): ?>
                <li class="flex items-center justify-between bg-white shadow-sm border rounded-lg px-4 py-3 hover:shadow-md transition">
                    <span class="text-slate-700 font-medium">
                        <?= $task['title'] ?>
                    </span>

                    <i class="fa-solid fa-circle-check 
                    <?= ($task['status'] ?? '') === 'complete' ? 'text-green-500' : 'text-red-500' ?>">
                    </i>

                </li>
            <?php endforeach; ?>

        </ul>
    </div>

</section>