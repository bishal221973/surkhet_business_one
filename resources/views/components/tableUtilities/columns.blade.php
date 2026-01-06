<div class="rounded shadow d-flex px-2 py-1 align-items-center"style="background-color:#1919708d">

    <div style="position: relative; display: inline-block; margin-left: 10px;">
        <button type="button" id="{{ $id }}-colvis-btn" class="bg-transparent border-0">
            <small class="table-label">Columns</small>
            <i class="fa fa-angle-down"></i>
        </button>
        <ul id="{{ $id }}-colvis-menu"
            style="display: none; position: absolute; background: white; border: 1px solid #ccc; list-style: none; padding: 5px 0; margin: 0; z-index: 1000; min-width: 110px;margin-left:-18px;margin-top:5px">
            @foreach ($headers as $index => $header)
                <li style="padding: 5px 10px; cursor:pointer;" data-column="{{ $index }}">
                    <input type="checkbox" checked> {{ $header }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
