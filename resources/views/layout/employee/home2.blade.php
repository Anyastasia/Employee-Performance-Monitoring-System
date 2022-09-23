@extends('layout.employee.master')
@section('title', 'Home | EPMS')
@section('main')
<main class="px-3">
<h1>Tasks</h1>

<section class="py-1">
    <div>
        <button class="button button-text button-text-underlined">Active</button>
        <button class="button button-text">Completed</button>
    </div>
</section>
<x-tasks>
    <x-tasks.item href="{{url('/employee/tasks/task')}}">
        <x-slot:header>Task</x-slot>
        <x-slot:deadline>September 17, 2021</x-slot>
    </x-tasks.item>
</x-tasks>
</main>
@endsection
