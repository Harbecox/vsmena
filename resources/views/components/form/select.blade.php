@php
    $input_name = \Illuminate\Support\Str::uuid();
@endphp
<div class="input__with_label x-select {{ $class }}">
    <label for="{{ $input_name }}">{{ $label }}</label>
    <div id="{{ $input_name }}" class="form-input">
        <input type="hidden" name="{{ $name }}" value="{{ $selected }}">
        @if($selected && isset($values[$selected]))
            <span class="selected_value">{{ $values[$selected] }}</span>
        @else
            <span class="selected_value">---</span>
        @endif
        <x-icon name="arrow_down"></x-icon>
    </div>
    <div class="list">
        @foreach($values as $id => $name)
            @if($selected && $selected == $id)
                <div data-id="{{ $id }}" class="item selected">{{ $name }}</div>
            @else
                <div data-id="{{ $id }}" class="item">{{ $name }}</div>
            @endif
        @endforeach
    </div>
</div>
