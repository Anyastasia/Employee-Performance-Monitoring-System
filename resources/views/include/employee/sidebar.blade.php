<x-sidebar>
    <x-sidebar.list class="dialog-button" icon="bi bi-bell-fill" >Notifications</x-sidebar.list>
    <x-sidebar.list href="{{ url('/employee/profile')}}" icon="bi bi-person-circle" >Profile</x-sidebar.list>
    <x-sidebar.list href="{{ url('/employee/tasks')}}" icon="bi bi-journal" >Tasks</x-sidebar.list>
</x-sidebar>