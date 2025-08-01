<div class="x-table">
    <div class="x-table-header">
        <div class="x-table-row">
            @foreach($columns as $column)
                <div class="x-table-cell">{{ $column }}</div>
            @endforeach
        </div>
    </div>
    <div class="x-table-body">
        @foreach($items as $row)
            <div class="x-table-row">
                @foreach($row as $item)
                    @if($item instanceof Illuminate\View\Component)
                        {!! $item->render() !!}
                    @else
                        <div class="x-table-cell">{{ $item }}</div>
                    @endif
                @endforeach
            </div>
        @endforeach
        @if(count($items) == 0)
            <div class="x-table-row">
                <div class="x-table-cell fs-16 text-secondary">Нет данных</div>
            </div>
        @endif
    </div>
    <div class="x-table-footer pt-30 position-relative">
        @if(strlen($fbTitle) > 0)
            <div class="position-absolute left-0 bottom-0 z-1">
                <a class="btn btn-light" href="{{ $fbUrl }}">
                    {{ $fbTitle }}
                </a>
            </div>
        @endif
        {{ $items->links() }}
    </div>
</div>

