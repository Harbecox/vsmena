<div class="d-flex justify-content-between mb-20 w-100">
    @if($backUrl)
        <div class="d-flex flex-column gap-5">
            <a href="{{ $backUrl }}" class="text-secondary d-flex gap-5 align-items-center">
                <x-icon name="back"/>
                <span class="text-secondary">Вернуться в</span>
                <span class="text-success">{{ $backText }}</span>
            </a>
            <h1 class="text-primary">{{ $titlePrimary }}</h1>
        </div>
    @else
        <div class="d-flex flex-column gap-5">
            <h1 class="text-primary">{{ $titlePrimary }}</h1>
            <h3 class="text-secondary">{{ $titleSecondary }}</h3>
        </div>
    @endif
    @if($exportUrl)
        <div class="filter d-flex d-xl-none align-items-center justify-content-center export_button_mobile">
            <a href="{{ $exportUrl }}">
                <x-icon name="export"/>
            </a>
        </div>
    @endif
</div>
