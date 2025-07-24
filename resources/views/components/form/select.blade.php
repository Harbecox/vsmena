@php
    $input_name = \Illuminate\Support\Str::uuid();
@endphp
<div class="input__with_label x-select">
    <label class="{{ $input_name }}">{{ $label }}</label>
    <div id="{{ $input_name }}" class="form-input">
        <input type="hidden" name="{{ $name }}">
        <span class="selected_value">---</span>
        <x-icon name="arrow_down"></x-icon>
    </div>
    <div class="list">
        @foreach($values as $id => $name)
            <div data-id="{{ $id }}" class="item">{{ $name }}</div>
        @endforeach
    </div>
</div>
