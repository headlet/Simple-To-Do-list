<?php
session_start();
require_once __DIR__ . '/../../app/Controller/TaskManagerController.php';
$taskManager = new TaskManagerController();

$action = $_GET['action'] ?? 'index';

$tasks = $taskManager->httpRequest($action);

?>

<section class="min-h-screen bg-slate-100 p-4">

    <!-- HEADER -->
    <div class="w-full  px-6 py-4">
        <h1 class="text-2xl font-bold text-blue-600 text-center">
            My To-Do Task
        </h1>
    </div>

    <!-- TASK LIST -->
    <div class="max-w-2xl mx-auto mt-6">
        <ul class="space-y-4">
            <?php if (!empty($tasks)): ?>

                <?php foreach ($tasks as $task): ?>
                    <li class="flex items-center justify-between bg-white shadow-sm border rounded-lg px-4 py-3 hover:shadow-md transition">

                        <span class="text-slate-700 font-medium">
                            <?= $task['title'] ?>
                        </span>

                        <span class="flex items-center gap-3">

                            <button
                                class="openEdit text-blue-500 hover:text-blue-700" data-id="<?= $task['id'] ?>"
                                data-title="<?= $task['title'] ?>"
                                data-status="<?= $task['status'] ?>">

                                <i class="fas fa-edit"></i>
                            </button>

                            <form id="deleteForm_<?= $task['id'] ?>" action="index.php?action=delete" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <button type="button" class="text-red-500 hover:text-red-700 deleteBtn"
                                    data-form-id="deleteForm_<?= $task['id'] ?>">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                            <i class="fa-solid fa-circle-check 
                    <?= ($task['status'] ?? '') === 'complete' ? 'text-green-500' : 'text-red-500' ?>">
                            </i>

                        </span>

                    </li>
                <?php endforeach; ?>

            <?php else: ?>

                <li class="text-center  bg-white shadow-sm border rounded-lg px-4 py-3 hover:shadow-md transition">
                    Please add Task
                </li>

            <?php endif; ?>

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

                <form action="index.php?action=create" method="post" class="space-y-4">
                    
                    <?php if (isset($_SESSION['formError'])): ?>
                        <p class="text-red-500 text-sm mb-3">
                            <?= $_SESSION['formError']['message'] ?>
                        </p>
                        <?php unset($_SESSION['formError']); ?>
                    <?php endif; ?>

                    <input type="text" name="title"
                        placeholder="Enter task..."
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">

                    <select name="status" id="edit_status"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">

                        <option value="pending" defa>Pending</option>
                        <option value="complete">Complete</option>

                    </select>

                    <button type="submit"
                        class="w-full bg-teal-500 hover:bg-teal-600 text-white py-2 rounded-lg">
                        Save Task
                    </button>

                </form>

            </div>

        </div>
    </div>

    <!-- Edit Task -->
    <div id="editForm"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm">

        <div class="flex items-center justify-center min-h-screen">

            <div class="bg-white w-full max-w-sm rounded-2xl shadow-lg p-6 relative">

                <!-- Close Button -->
                <button id="closeEditForm"
                    class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-xl">
                    ✕
                </button>

                <h2 class="text-2xl font-bold text-blue-600 text-center mb-4">
                    Edit Task
                </h2>

                <form action="index.php?action=edit" method="post" class="space-y-4">

                    <!-- Hidden ID -->
                    <input type="hidden" name="id" id="edit_id">

                    <input type="text" name="title" id="edit_title"
                        placeholder="Enter task..."
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">

                    <select name="status" id="edit_status"
                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-400">

                        <option value="pending" defa>Pending</option>
                        <option value="complete">Complete</option>

                    </select>

                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg">
                        Update Task
                    </button>

                </form>

            </div>

        </div>
    </div>

</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {

        $("#openTaskModal").click(function() {
            $("#taskModal").fadeIn(200).removeClass("hidden");
        });

        $("#closeTaskModal").click(function() {
            $("#taskModal").fadeOut(200).addClass('hidden');
        });

        $(".openEdit").click(function() {
            $("#editForm").fadeIn(200).removeClass("hidden");

            let id = $(this).data("id");
            let title = $(this).data("title");
            let status = $(this).data("status");

            $("#edit_id").val(id);
            $("#edit_title").val(title);
            $("#edit_status").val(status);
        });

        $("#closeEditForm").click(function() {
            $("#editForm").fadeOut(200).addClass('hidden');
        });

        // DELETE WITH SWAL
        $(".deleteBtn").click(function(e) {
            e.preventDefault();
            let formId = $(this).data("form-id");

            Swal.fire({
                title: 'Delete Task?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        });

    });
</script>