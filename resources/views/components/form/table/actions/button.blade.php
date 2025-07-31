<div>
    @if($url)
        <a class="btn btn-{{ $type }}" href="{{ $url }}">
            {{ $title }}
        </a>
    @else
        <button class="btn btn-{{ $type }}">
            {{ $title }}
        </button>
    @endif
</div>
