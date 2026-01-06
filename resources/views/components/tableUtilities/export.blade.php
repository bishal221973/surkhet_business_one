<div class="rounded shadow d-flex px-2 py-1 align-items-center"style="background-color:#1919708d">

    <div style="position: relative; display: inline-block;">
        <button type="button" id="{{ $id }}-export-btn" class="bg-transparent border-0">
            <small class="table-label">Export</small>
            <i class="fa fa-angle-down"></i>
        </button>
        <ul id="{{ $id }}-export-menu"
            style="display: none; position: absolute; background: white; border: 1px solid #ccc; list-style: none; padding: 5px 0; margin: 0; z-index: 1000; min-width: 85px;margin-left:-8px;margin-top:5px">
            <li class="export-list" style="padding: 5px 10px; cursor:pointer;" data-action="copy"> <i
                    class="fa fa-copy export-icon"></i> Copy</li>
            <li class="export-list" style="padding: 5px 10px; cursor:pointer;" data-action="csv"> <i
                    class="fa fa-file-csv export-icon"></i>CSV</li>
            <li class="export-list" style="padding: 5px 10px; cursor:pointer;" data-action="excel"><i
                    class="fa fa-file-excel export-icon"></i>Excel</li>
            <li class="export-list" style="padding: 5px 10px; cursor:pointer;" data-action="pdf"><i
                    class="fa fa-file-pdf export-icon"></i>PDF</li>
            <li class="export-list" style="padding: 5px 10px; cursor:pointer;" data-action="print"><i
                    class="fa fa-print export-icon"></i>Print</li>
        </ul>
    </div>
</div>
