<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Mary\View\Components\Select;

class TestSelect extends Select
{
    public function render(): View|Closure|string
    {
        return <<<'BLADE'
<div class="input__with_label x-select">
    {{-- LABEL --}}
    @if ($label)
        <label class="{{ $input_name }}">{{ $label }}
            @if($attributes->get('required'))
                <span class="text-error">*</span>
            @endif
        </label>
    @endif

    {{-- SELECT VISUAL --}}
    <div id="{{ $uuid }}" class="form-input {{ $errors->has($errorFieldName()) ? 'input-error' : '' }}">

        <span class="selected_value">{{ $modelName() ?? '---'}}</span>

        {{-- ICON --}}
        @if($iconRight ?? $icon)
            <x-mary-icon :name="$iconRight ?? $icon" class="pointer-events-none w-4 h-4 opacity-40" />
        @endif
    </div>

    {{-- LIST --}}
    <div class="list">
        @if($placeholder)
            <div data-id="{{ $placeholderValue }}" class="item placeholder">{{ $placeholder }}</div>
        @endif

        @foreach ($options as $option)
            <div wire:click="$set('{{ $modelName() }}', '{{ data_get($option, $optionValue) }}')" value="{{ data_get($option, $optionValue) }}">{{ data_get($option, $optionLabel) }}</div>
        @endforeach

    </div>

    {{-- ERROR --}}
    @if(!$omitError && $errors->has($errorFieldName()))
        @foreach($errors->get($errorFieldName()) as $message)
            @foreach(\Illuminate\Support\Arr::wrap($message) as $line)
                <div class="{{ $errorClass }} text-error">{{ $line }}</div>
                @break($firstErrorOnly)
            @endforeach
            @break($firstErrorOnly)
        @endforeach
    @endif

    {{-- HINT --}}
    @if($hint)
        <div class="{{ $hintClass }}">{{ $hint }}</div>
    @endif
</div>
BLADE;
    }
}
