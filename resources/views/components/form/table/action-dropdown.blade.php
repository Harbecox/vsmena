<div class="dropdown x-table-cell text-center">
    <div class="x-table-action-btn" data-bs-toggle="dropdown">
        <x-icon name="action"/>
    </div>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        @foreach($items as $item)
            <li>
                <a class="dropdown-item" href="#">
                    {!! $item->render() !!}
                </a>
            </li>
        @endforeach
    </ul>
</div>
