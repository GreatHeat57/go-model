{{ Html::style(config('app.cloud_url').'/css/custom_pagination.css') }}
<?php  $link_limit = 7; ?>

@if (isset($paginator) and $paginator->getCollection()->count() > 0)
    @if ($paginator->lastPage() > 1)
        <div class="pagination">
            <ul>
                <li >
                    <a href="{{ $paginator->url(1) }}" class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}" >Previous</a>
                </li>
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <?php
                        
                        $half_total_links = floor($link_limit / 2);
                        $from = $paginator->currentPage() - $half_total_links;
                        $to = $paginator->currentPage() + $half_total_links;
                        if ($paginator->currentPage() < $half_total_links) {
                           $to += $half_total_links - $paginator->currentPage();
                        }
                        if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                            $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                        }
                    ?>

                    @if ($from < $i && $i < $to)
                        <li >
                            <a href="{{ $paginator->url($i) }}" class="{{ ($paginator->currentPage() == $i) ? ' active disabled' : '' }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor
                <li >
                    <a href="{{ $paginator->url($paginator->currentPage()+1) }}" class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">Next</a>
                </li>
            </ul>
        </div>
    @endif
@endif

