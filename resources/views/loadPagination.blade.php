@if ($paginator->lastPage() > 1)
    <ul class="pagination">


        @if ( $paginator->currentPage() == 1)
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="javascript:void(0);" data-page="{{ $paginator->currentPage()-1 }}" rel="prev">&laquo;</a></li>
        @endif

        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            @if ($i == $paginator->currentPage())
                <li class="active"><span>{{ $i }}</span></li>
            @else
                <li>
                    <a href="javascript:void(0);" data-page="{{ $i }}" class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
                </li>
            @endif
        @endfor

        @if ($paginator->lastPage())
            <li class="disabled"><span>&raquo;</span></li>
        @else
            <li><a href="javascript:void(0);" data-page="{{ $paginator->currentPage()+1 }}" rel="next">&raquo;</a></li>
        @endif

    </ul>
@endif

