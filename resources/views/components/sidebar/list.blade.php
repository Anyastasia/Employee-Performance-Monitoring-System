@props(['icon' => "bi bi-circle-fill"])
<a {{$attributes->class('sidebar-item')}}>
    <div>
        <i class="{{$icon}}"></i>
        <li>{{$slot}}</li>
    </div>
</a>
