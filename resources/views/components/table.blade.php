<style>
    .sort th:not(.ignore) {
    cursor: pointer;
    position: relative;
}

.sort th:not(.ignore):hover::after {
    content: '\25BC'; /* Flecha hacia abajo */
    /* position: relative; */
    top: 50%;
    right: 8px;
    transform: translateY(-50%);
}

.sort th.asc::after {
    content: '\25B2'; /* Flecha hacia arriba */
}

.sort th.desc::after {
    content: '\25BC'; /* Flecha hacia abajo */
}

</style>


<div class="d-flex justify-content-end">
    <div>
        <div> 
            <button class="btn btn-sm btn-info" tabindex="0" aria-controls="sqltable" type="button" title="Help">
                <span><i class="bi bi-question"></i></span>
            </button> 
            <div class="btn-group">
                <button class="btn btn-sm buttons-collection dropdown-toggle buttons-colvis btn-outline-secondary" tabindex="0" id="sqltable" data-bs-toggle="dropdown" type="button" title="Column visibility" aria-haspopup="dialog">
                    <span><i class="bi bi-columns"></i></span>
                </button>
                <div class="dropdown-menu" aria-labelledby="sqltable" aria-modal="true" role="dialog">
                    
                        <div>
                            <button onclick="">{{ $customFunction() }}</button>
                        </div>
                        <ul class="list-group list-group-flush">
                            <div class="container">
                                @foreach ($columns as $column)
                                    <li class="list-group-item">
                                        <input type="checkbox" name="chkColum_{{ $loop->index }}" id="chkColum_{{ $loop->index }}" value="{{ $column->key }}" checked="{{$column->visible}}">
                                            <label for="">
                                                <span>{{ $column->title }}</span>
                                            </label>
                                    </li>
                                @endforeach
                            </div>
                        </ul>
                </div>
            </div> 
            {{-- <button class="btn btn-sm buttons-copy buttons-html5 btn-outline-secondary" tabindex="0" aria-controls="sqltable" type="button" title="Copy to clipboard">
                <span><i class="bi bi-clipboard"></i></span>
            </button>  --}}
            {{-- <button class="btn btn-sm buttons-pdf buttons-html5 btn-secondary" tabindex="0" aria-controls="sqltable" type="button" title="Export to PDF">
                <span><i class="bi bi-file-earmark-pdf"></i></span>
            </button>  --}}
            {{-- <button class="btn btn-sm buttons-excel buttons-html5 btn-secondary" tabindex="0" aria-controls="sqltable" type="button" title="Export to spreadsheet">
                <span><i class="bi bi-file-earmark-excel"></i></span>
            </button>  --}}
            {{-- <button class="btn btn-sm buttons-print btn-secondary" tabindex="0" aria-controls="sqltable" type="button" title="Print">
                <span><i class="bi bi-printer"></i></span>
            </button>  --}}
            {{-- <button class="btn btn-sm buttons-select-none btn-info disabled" tabindex="0" aria-controls="sqltable" type="button" title="Deselect all" disabled="">
                <span><i class="bi bi-x"></i></span>
            </button>  --}}
            {{-- <button class="btn btn-sm buttons-select-all btn-info" tabindex="0" aria-controls="sqltable" type="button" title="Select all">
                <span><i class="bi bi-check"></i></span>
            </button>  --}}
        </div>
    </div>
</div>

<table class="table table-striped">
    <thead class={{ isset($order) && $order ? "sort":""}}>
        <tr >
            @foreach($headers as $header)
                <th 
                    class='{{ isset($header->ignore) && $header->ignore ? "ignore":"" }} {{ isset($header->active) ? "active":"" }} {{ isset($header->order) && $header->order === "asc" ? "asc":""}}{{ isset($header->order) && $header->order === 'desc' ? "desc":""}}'
                    data-order="{{ $header->key }}" 
                >
                    {{ Str::ucfirst($header->title) }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        
        @foreach($elements as $item)
            <tr>
                @foreach($headers as $header)
                    <td>{{ $item->{$header->key} }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-end">
    {{$elements->links()}}
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const columns = document.querySelectorAll('table th:not(.ignore)');
            let filter = '';
            let sort = '';
            columns.forEach((column) => {
                column.onclick = (event) => {
                    const target = event.target;
                    filter = target.getAttribute('data-order');
                    if (filter !== null) {
                        const active = target.classList.contains('active');
                        if (active) {
                            const down = target.classList.contains('asc');
                            target.classList.remove('asc', 'desc');
                            const className = down === true ? 'desc' : 'asc';
                            sort = className;
                            target.classList.add(className);
                        } else {
                            columns.forEach((th) => {
                                th.classList.remove('active');
                            });
                            target.classList.add('active', 'asc');
                            sort = 'asc';
                        }
                        // Aquí, actualiza los filtros
                        // Puedes usar AJAX para enviar los filtros al servidor Laravel
                        const filters = {
                            page: 1,
                            orderBy: filter,
                            order: sort,
                        };
                        
                        {{ getAll(filters); }}
                    }
                };
            });
        });
    
</script>

