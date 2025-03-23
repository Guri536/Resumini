@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm disabled:border-gray-200 disabled:bg-gray-400 disabled:text-gray-500 disabled:shadow-none']) !!}>
{{$slot}}