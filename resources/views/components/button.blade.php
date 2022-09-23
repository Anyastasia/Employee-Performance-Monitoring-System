
@props(['variant' => 'primary', 'dropdownButton' => false, 'dialogButton' => false])
<button {{ $attributes->class(['dropdown-button' => $dropdownButton, 'dialog-button' => $dialogButton])->merge([
    'class' =>'button button-'.$variant
])}}>
    {{$slot}}
</button>