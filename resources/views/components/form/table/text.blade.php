<div class="x-table-cell text-center">
    @if(strlen($text) == 0)
        -
    @else
        {{ \Illuminate\Support\Str::limit($text,$limit) }}
    @endif
</div>
