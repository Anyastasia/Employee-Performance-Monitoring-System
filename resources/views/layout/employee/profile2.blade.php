@extends('layout.employee.master')
@section('title', 'Profile | EPMS')

@section('main')
<main class="px-3"> 
    <h1>Profile</h1>
    <section class="profile-container">
        <div class="profile-img-container">
            <img class="bi bi-person-circle" src="{{ url('/images/profile-placeholder.png')}}" alt="">
            <article class="display-inline-block">
                <h2 class="h2">employee_name</h2>
                <p>employee_position | email@email.com</p>
            </article>
        </div>
    </section>
</main> 
@endsection
