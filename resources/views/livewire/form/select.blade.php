@php
    $input_name = \Illuminate\Support\Str::uuid();
@endphp
<div class="input__with_label x-select">
    <label for="{{ $input_name }}">{{ $label }}</label>
    <div id="{{ $input_name }}" class="form-input">
        <input name="{{ $var }}" wire:key="{{ $var }}" type="hidden" wire:model.live="value">
        @if($value && isset($options[$value]))
            <span class="selected_value">{{ $options[$value] }}</span>
        @else
            <span class="selected_value">---</span>
        @endif
        <x-icon name="arrow_down"></x-icon>
    </div>
    <div class="list">
        @foreach($options as $id => $name)
            @if($value && $value == $id)
                <div data-id="{{ $id }}" class="item selected">{{ $name }}</div>
            @else
                <div data-id="{{ $id }}" class="item">{{ $name }}</div>
            @endif
        @endforeach
    </div>
</div>
