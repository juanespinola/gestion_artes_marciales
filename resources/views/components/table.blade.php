<table class="table table-striped">
    <thead>
        <tr>
            @foreach($headers as $header)
                
                <th>{{ Str::ucfirst($header->title) }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        
        @foreach($headers as $item)
            <tr>
                @foreach($headers as $header)
                    {{-- <td>{{ $item->{$header} }}</td> --}}
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
<div class="d-flex justify-content-center">
    {{-- <nav aria-label="...">
        <ul class="pagination">
          <li class="page-item disabled">
            <a class="page-link" href="{{$columns->nextPageUrl()}}" tabindex="-1">Previous</a>
          </li>
          <li class="page-item"><a class="page-link" href="{{$columns->firstItem()}}">1</a></li>
          <li class="page-item active">
            <a class="page-link" href="#"><span class="sr-only">{{$columns->currentPage()}}</span></a>
          </li>
          <li class="page-item"><a class="page-link" href="">{{$columns->lastItem()}}</a></li>
          <li class="page-item">
            <a class="page-link" href="{{$columns->previousPageUrl()}}">Next</a>
          </li>

        </ul>
    </nav> --}}
    {{-- {{$columns->links()}} --}}
</div>

