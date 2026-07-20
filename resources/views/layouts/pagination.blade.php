@if ($paginator->hasPages())
<nav class="pagination">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="page-btn disabled">‹</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">‹</a>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)

        @if (is_string($element))
            <span class="page-btn disabled">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="page-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                @endif
            @endforeach
        @endif

    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">›</a>
    @else
        <span class="page-btn disabled">›</span>
    @endif

</nav>
@endif

<style>
.pagination{
display:flex;
gap:6px;
align-items:center;
}
.page-btn{
padding:6px 10px;
border-radius:6px;
background:#f1f5f9;
text-decoration:none;
font-size:13px;
color:#334155;
}
.page-btn:hover{
background:#0f766e20;
color:#0f766e;
}
.page-btn.active{
background:#0f766e;
color:white;
font-weight:600;
border:1px solid #0f766e;
}
.page-btn.disabled{
opacity:0.4;
pointer-events:none;
}
</style>