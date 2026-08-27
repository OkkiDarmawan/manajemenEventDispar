@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-gray-700 dark:font-bold']) }}>
    {{ $value ?? $slot }}
</label>
