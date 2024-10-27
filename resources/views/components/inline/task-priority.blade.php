@use(App\Enums\TaskPriority)

@props([
    'status',
])

@php
    $statusClass = 'rounded px-1 w-fit text-center ';
        switch (TaskPriority::from($status)->name){
            case TaskPriority::low->name:
                $statusClass .= 'bg-success text-white';
                break;
            case TaskPriority::normal->name:
                $statusClass .= 'bg-yellow text-white';
                break;
            case TaskPriority::high->name:
                $statusClass .= 'bg-warning text-white';
                break;
            case TaskPriority::important->name:
                $statusClass .= 'bg-danger text-white';
                break;
        }
@endphp

<span
    {{
        $attributes->merge([
            'class' => $statusClass
        ])
    }}
>

@if($slot->isEmpty())
    {{ __(TaskPriority::from($status)->name) }}
@else
    {{ $slot }}
@endif

</span>
