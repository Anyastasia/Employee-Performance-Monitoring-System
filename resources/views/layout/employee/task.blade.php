<!DOCTYPE html>
<html lang="en">
<head>
    @include('include/head')
    <title>Home | EPMS</title>
</head>
<body>
    <div class="master-grid">
        <header>
            <nav class="dropdown flex flex-right mt-1 mr-3">
                <span class="dropdown-button">
                    <img src="{{url('images/profile-placeholder.png')}}" alt="">
                </span>

                <ul class="dropdown-content">
                    <li class="dropdown-item">Settings</li>
                    <li class="dropdown-item">Log out</li>
                </ul>
            </nav>  
        </header>

    
        @include('include/employee/sidebar')
    
        <main class="px-3"> 
            <section>
                <h1 class="my-2">Task 1</h1>
                <h3 class="my-1">Task Description</h3>
            </section>
            
            <section class="task-submission-container">
                <div>
                    <label for="attachments">Attachments</label>
                    <input type="file" name="attachments" id="attachments">
                </div>

                <div>
                    <label for="notes">Notes (Optional)</label>
                    <textarea name="notes" id="notes" cols="50" rows="5"></textarea>
                </div>
            </section>

            <button type="submit" class="button button-primary">Submit</button>

        </main> 
    </div>
    <script src="{{url('js/dialog.js')}}"></script>
    <script src="{{url('js/dropdown.js')}}"></script>
</body>
</html>