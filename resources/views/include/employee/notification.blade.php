<x-notification>
    
    <x-slot:header>Notifications</x-slot:header>
    @foreach ($data as $item)
    <x-notification.item href="">
        <x-slot:description>{{$item['description']}}</x-slot>
        <x-slot:time>{{$item['time']}}</x-slot:time>
    </x-notification.item>
    @endforeach
</x-notification>