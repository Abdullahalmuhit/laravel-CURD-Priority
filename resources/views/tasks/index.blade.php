<!-- resources/views/tasks/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Task Management</h1>

    <form action="{{ route('tasks.index') }}" method="get">
        <label for="project">Filter by Project:</label>
        <select name="project" id="project" onchange="this.form.submit()">
            <option value="">All Projects</option>
            <!-- Add project options dynamically here -->
        </select>
    </form>

    <ul id="sortable">
        @foreach ($tasks as $task)
            <li class="ui-state-default" data-task-id="{{ $task->id }}">{{ $task->name }}</li>
        @endforeach
    </ul>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#sortable").sortable({
                update: function(event, ui) {
                    var taskIds = [];

                    $(this).find("li").each(function() {
                        taskIds.push($(this).data("task-id"));
                    });

                    $.ajax({
                        url: "{{ route('tasks.updatePriorities') }}",
                        method: "POST",
                        data: { taskIds: taskIds },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Priorities updated successfully.');
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            }).disableSelection();
        });
    </script>
@endsection
