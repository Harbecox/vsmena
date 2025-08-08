@php
    $id = \Illuminate\Support\Str::uuid()
@endphp
<div>
    <span data-bs-toggle="modal"  style="cursor: pointer" data-bs-target="#modal_{{ $id }}">
        {{ $button ?? "Model open button" }}
    </span>
    <div class="modal fade" id="modal_{{ $id }}" tabindex="-1" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <span class="close" data-bs-dismiss="modal" aria-label="Close">
                        <x-icon name="modal_close"></x-icon>
                    </span>
                </div>
                <div class="modal-body">
                    {{ $body }}
                </div>
                @if(isset($footer))
                    {{ $footer }}
                @else
                <div class="modal-footer d-flex justify-content-between gap-15">
                    <button data-bs-toggle="modal" data-bs-target="#modal_{{ $id }}" type="button" class="btn btn-light">Отменить</button>
                    @if($type == 'success')
                        <button id="button_{{ $id }}" type="submit" class="btn btn-success">Сохранить</button>
                    @elseif($type == 'danger')
                        <button type="submit" class="btn btn-danger">Подтвердить</button>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
