
@props([
    'datetime',
    'format' => 'Y-m-d H:i:s'
])

<span>{{ \Morilog\Jalali\Jalalian::forge($datetime)->format($format) }}</span>
