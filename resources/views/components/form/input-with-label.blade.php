@php
    $input_name = \Illuminate\Support\Str::uuid();
@endphp
<div class="input__with_label">
    <label class="{{ $input_name }}">{{ $label }}</label>
    <input @if($required) required @endif id="{{ $input_name }}" class="form-input" type="{{ $type }}" value="{{ $value }}" name="{{ $name }}" placeholder="{{ $placeholder }}">
    @if($icon)
        <x-icon name="{{ $icon }}" />
    @endif
    @if($errors->has($name))
        <div class="error text-danger">{{ $errors->first($name) }}</div>
    @endif
</div>
