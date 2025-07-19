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
    </div>
    <div class="x-table-footer pt-30">
        {{ $items->links() }}
    </div>
</div>

