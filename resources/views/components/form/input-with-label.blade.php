@php
    $input_name = \Illuminate\Support\Str::uuid();
@endphp
<div class="input__with_label {{ $class }}">
    <label class="{{ $input_name }}">{{ $label }}@if($required)<span class="required">*</span>@endif</label>
    <input @if($looked) readonly @endif @if($required) required @endif id="{{ $input_name }}" class="form-input" type="{{ $type }}" value="{{ $value }}" name="{{ $name }}" placeholder="{{ $placeholder }}">
    @if($icon)
        <x-icon name="{{ $icon }}" />
    @endif
    <div class="error text-danger @if($errors->has($name)) d-block @else d-none @endif">@if($errors->has($name)){{ $errors->first($name) }}@endif</div>
</div>
