@use(App\Enums\TaskStatus)

@props([
    'status',
])

@php
    $statusClass = 'rounded px-1 w-fit text-center ';
        switch ($status){
            case TaskStatus::completed->name:
                $statusClass .= 'bg-success text-white';
                break;
            case TaskStatus::pending->name:
                $statusClass .= 'bg-info text-white';
                break;
            case TaskStatus::suspended->name:
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
    {{ __($status) }}
@else
    {{ $slot }}
@endif

</span>
