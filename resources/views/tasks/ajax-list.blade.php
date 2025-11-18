{{-- @foreach ($tasks as $task)
<li class="list-group-item border-0 d-flex align-items-center ps-0 task-item">

    <input class="form-check-input me-3 task-check"
           type="checkbox"
           data-id="{{ $task->id }}"
           {{ $task->status == 'completed' ? 'checked' : '' }}>

    <span class="task-title flex-grow-1 {{ $task->status == 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
        {{ $task->title }}
    </span>

    <span class="badge flex-shrink-0 ms-3 px-2 py-1  
        {{ $task->status === 'completed' ? 'bg-success' : ($task->status === 'in-progress' ? 'bg-info' : 'bg-warning') }}">
        {{ $task->status }}
    </span>
    <i class="fa fa-eye icon-btn show-desc" data-title="{{ $task->title }}" data-desc="{{ $task->description }}"></i>
    <i class="fa fa-pencil icon-btn edit-task" data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-desc="{{ $task->description }}"></i>

    <i class="fa fa-times-circle text-danger ml-auto delete-task"
       data-id="{{ $task->id }}"
       style="font-size:20px; cursor:pointer;"></i>
</li>
@endforeach
<div class="mt-3">
    {!! $tasks->links('pagination::bootstrap-4') !!}
</div> --}}
<table class="table table-bordered table-striped">
    <thead class="thead-light">
        <tr>
            <th></th> <!-- Checkbox -->
            <th>Title</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr>
            <!-- Checkbox -->
            <td>
                <input class="form-check-input task-check" type="checkbox"
                       data-id="{{ $task->id }}"
                       {{ $task->status == 'completed' ? 'checked' : '' }}>
            </td>

            <!-- Title -->
            <td class="{{ $task->status == 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                {{ $task->title }}
            </td>

            <!-- Status -->
            <td>
                <span class="badge 
                    {{ $task->status === 'completed' ? 'bg-success' : ($task->status === 'in-progress' ? 'bg-info' : 'bg-warning') }}">
                    {{ ucfirst($task->status) }}
                </span>
            </td>

            <!-- Actions -->
            <td>
                <i class="fa fa-eye icon-btn show-desc me-2"
                   data-title="{{ $task->title }}"
                   data-desc="{{ $task->description }}"></i>
                <i class="fa fa-pencil icon-btn edit-task me-2"
                   data-id="{{ $task->id }}"
                   data-title="{{ $task->title }}"
                   data-desc="{{ $task->description }}"></i>
                <i class="fa fa-times-circle text-danger delete-task"
                   data-id="{{ $task->id }}"
                   style="font-size:18px; cursor:pointer;"></i>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination -->
<div class="mt-3">
    {!! $tasks->links('pagination::bootstrap-4') !!}
</div>
