<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sample Email</title>
</head>
<body> 

    <p>Hi, {{$data['first_name']}}</p>
    
    <p>{{$data['body']}}</p>

    <h2>Task Details<h2>
    <p>Task title: {{$data['task_title']}}</p>
    <p>Description: {{$data['task_description']}}</p>
    <p>Submission Due Date: {{$data['due_date']}}</p>
</body>
</html>