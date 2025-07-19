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
    <div class="list flex-column">
        @foreach($values as $id => $name)
            @if($id == -1)
                @if(is_null($selected_value))
                    <a href="{{ $clear_url }}" class="item selected">{{ $name }}</a>
                @else
                    <a href="{{ $clear_url }}" class="item">{{ $name }}</a>
                @endif
            @else
                @if(!is_null($selected_value) && $selected_value == $id)
                    <a href="{{ $base_url }}{{ $id }}" class="item selected">{{ $name }}</a>
                @else
                    <a href="{{ $base_url }}{{ $id }}" class="item">{{ $name }}</a>
                @endif
            @endif
        @endforeach
    </div>
</div>
