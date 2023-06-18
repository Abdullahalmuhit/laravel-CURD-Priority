@extends('layouts.app')

@section('content')
    <h1>Create Task</h1>

    <form action="{{ route('tasks.store') }}" method="post">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" class="" id="name" required>
        </div>
        <br>
        <button type="submit">Create</button>
    </form>
@endsection
