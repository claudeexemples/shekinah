@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;justify-content:space-between;padding:var(--space-2) 0;">
    <div style="font-size:var(--text-sm);color:var(--color-neutral-500);">
        A mostrar {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de {{ $paginator->total() }} registos
    </div>
    <div style="display:flex;gap:var(--space-1);">
        @if ($paginator->onFirstPage())
            <span style="padding:6px 10px;border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-300);">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding:6px 10px;border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-600);text-decoration:none;">‹</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="padding:6px 10px;font-size:var(--text-sm);color:var(--color-neutral-400);">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding:6px 10px;background:var(--color-primary-600);color:white;border-radius:var(--radius-md);font-size:var(--text-sm);font-weight:600;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding:6px 10px;border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-600);text-decoration:none;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding:6px 10px;border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-600);text-decoration:none;">›</a>
        @else
            <span style="padding:6px 10px;border:1px solid var(--color-neutral-200);border-radius:var(--radius-md);font-size:var(--text-sm);color:var(--color-neutral-300);">›</span>
        @endif
    </div>
</nav>
@endif
