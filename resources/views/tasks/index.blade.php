<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background-color: #3da2c3;
        }

        .card {
            border-radius: 10px;
        }

        .card-body {
            padding: 2rem;
        }

        #taskList {
            padding-left: 0;
            margin-bottom: 0;
        }

        #addTaskForm input,
        #addTaskForm textarea,
        #search,
        #statusFilter {
            width: 100%;
            margin-bottom: 1rem;
        }

        .task-item {
            display: grid !important;
            grid-template-columns: 1fr minmax(100px, auto) 40px 40px;

            align-items: center;
            gap: 10px;
            width: 100%;
            box-sizing: border-box;
            padding: 0.5rem 1rem;
        }

        #taskList .task-title {

            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }


        .task-status {
            width: 120px;
            text-align: center;
            padding: 5px 8px;
            border-radius: 6px;
            color: #fff;
            font-size: 12px;
        }

        .task-title.completed {
            text-decoration: line-through;
            color: #6c757d;
        }

        .icon-btn {
            cursor: pointer;
            font-size: 18px;
            color: #333;
        }

        .icon-btn:hover {
            color: #000;
        }
    </style>
</head>

<body class="vh-500">
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="editTaskForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="task_id" id="editTaskId">
                        <div class="form-group">
                            <label for="editTaskTitle">Title</label>
                            <input type="text" class="form-control" id="editTaskTitle" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="editTaskDescription">Description</label>
                            <textarea class="form-control" id="editTaskDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-10">
                <div class="card shadow-lg">
                    <div class="card-body">

                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3>My Tasks</h3>
                            <span class="badge badge-danger">Checklist</span>
                        </div>

                        

                        <input type="text" id="search" class="form-control" placeholder="Search tasks...">
                        <select id="statusFilter" class="form-control mb-3">
                            <option value="all">Show All</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>

                        <!-- Add Task Form -->
                        <form id="addTaskForm" class="mb-4">
                            @csrf
                            <input type="text" name="title" class="form-control" placeholder="Task Title" required>
                            <textarea name="description" class="form-control" rows="2" placeholder="Task Description"></textarea>
                            <button class="btn btn-primary mt-2">Add Task</button>
                        </form>

                        
                        <div id="tasksContainer">
    <table class="table table-bordered table-striped align-middle">
        <thead class="thead-light">
            <tr>
                <th style="width:40px;"></th> 
                <th>Title</th>
                <th style="width:120px;">Status</th>
                <th style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                
                <td class="text-center">
                    <input class="form-check-input task-check" type="checkbox"
                           data-id="{{ $task->id }}"
                           {{ $task->status == 'completed' ? 'checked' : '' }}>
                </td>

                
                <td class="{{ $task->status == 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                    {{ $task->title }}
                </td>

                
                <td class="text-center">
                    <span class="badge
                        {{ $task->status === 'completed' ? 'bg-success' : ($task->status === 'in-progress' ? 'bg-info' : 'bg-warning') }}">
                        {{ ucfirst($task->status) }}
                    </span>
                </td>

                
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <i class="fa fa-eye icon-btn show-desc"
                           data-title="{{ $task->title }}"
                           data-desc="{{ $task->description }}"></i>
                        <i class="fa fa-pencil icon-btn edit-task"
                           data-id="{{ $task->id }}"
                           data-title="{{ $task->title }}"
                           data-desc="{{ $task->description }}"></i>
                        <i class="fa fa-times-circle text-danger delete-task"
                           data-id="{{ $task->id }}"
                           style="font-size:18px; cursor:pointer;"></i>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    
    <div class="mt-3">
        {!! $tasks->links('pagination::bootstrap-4') !!}
    </div>
</div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descriptionModalLabel">Task Description</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalDescription"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        // Add Task
        $('#addTaskForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('tasks.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    $('input[name="title"], textarea[name="description"]').val("");
                    loadTasks(1);
                },
                error: function(err) {
                    alert("Error adding task");
                }
            });
        });

        // Toggle Task Status
        $(document).on('change', '.task-check', function() {
            let id = $(this).data('id');
            let checked = $(this).is(":checked");
            let status = checked ? "completed" : "pending";
            $.ajax({
                url: "/tasks/" + id,
                type: "PUT",
                data: {
                    title: "temp",
                    status: status,
                    user_id: "{{ auth()->id() }}",
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    loadTasks();
                }
            });
        });

        // Delete Task
        $(document).on('click', '.delete-task', function() {
            let id = $(this).closest('li').find('.task-check').data('id');
            let element = $(this).closest('li');
            $.ajax({
                url: "/tasks/" + id,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    element.fadeOut(200, function() {
                        $(this).remove();
                    });
                }
            });
        });

        // Show Description in Modal
        $(document).on('click', '.show-desc', function() {
            let title = $(this).data('title');
            let desc = $(this).data('desc');
            $('#descriptionModalLabel').text(title);
            $('#modalDescription').text(desc ? desc : 'No description added.');
            $('#descriptionModal').modal('show');
        });

        // Load Tasks
        function loadTasks(page = 1) {
            $.ajax({
                url: "{{ route('tasks.index') }}?page=" + page,
                type: "GET",
                data: {
                    search: $('#search').val(),
                    status: $('#statusFilter').val()
                },
                success: function(res) {
                    $("#tasksContainer").html(res);
                }
            });
        }

        // Search & Filter
        $('#search').on('keyup', function() {
            loadTasks();
        });
        $('#statusFilter').on('change', function() {
            loadTasks();
        });
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            loadTasks(page);
        });
    </script>
    <script>
        $(document).on('click', '.edit-task', function() {
            let id = $(this).data('id');
            let title = $(this).data('title');
            let desc = $(this).data('desc');

            $('#editTaskId').val(id);
            $('#editTaskTitle').val(title);
            $('#editTaskDescription').val(desc);

            $('#editTaskModal').modal('show');
        });

        // Submit Edit Form
        $('#editTaskForm').on('submit', function(e) {
            e.preventDefault();

            let id = $('#editTaskId').val();
            let title = $('#editTaskTitle').val();
            let description = $('#editTaskDescription').val();

            $.ajax({
                url: '/tasks/' + id,
                type: 'PUT',
                data: {
                    title: title,
                    description: description,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    $('#editTaskModal').modal('hide');
                    loadTasks(); // refresh the task list
                },
                error: function(err) {
                    alert('Error updating task');
                }
            });
        });
    </script>
</body>

</html>
