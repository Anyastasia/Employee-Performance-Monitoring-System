<!DOCTYPE html>
<html lang="en">
<head>
    @include('include.head')
</head>
<body>
    @php
     $message = "marisa";   
    @endphp
    <x-sample :message="$message" class="enlarge">
        wahahahhahaha  
    </x-sample>
    Body content
</body>
<footer>
    @include('include.footer')
</footer>
</html>