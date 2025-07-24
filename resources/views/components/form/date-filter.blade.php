<div class="filter filter-date d-flex align-items-center gap-20">
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
    <input style="opacity:0;z-index: -1;position: absolute; bottom: 0" id="datePicker" value="{{ $selected_value }}" data-base-url="{{ $base_url }}">
</div>
