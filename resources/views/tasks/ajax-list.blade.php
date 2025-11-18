
<div id="tasksContainer">
    <table class="table table-bordered table-striped align-middle">
        <thead class="thead-light">
            <tr>
                <th style="width:40px;"></th> <!-- Checkbox -->
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