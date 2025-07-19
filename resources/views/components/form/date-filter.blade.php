<div class="filter d-flex align-items-center gap-20">
    @if($icon)
        <x-icon name="{{ $icon }}"></x-icon>
    @endif
    <div class="d-flex flex-column gap-5">
        <div class="title">{{ $title }}</div>
        <div class="selected">{{ $selected_label }}</div>
    </div>
    <span class="open_icon">
        <x-icon name="arrow_down"></x-icon>
    </span>
    <input style="z-index: -1;opacity: 0;position: absolute; bottom: 0" id="datePicker">
</div>
