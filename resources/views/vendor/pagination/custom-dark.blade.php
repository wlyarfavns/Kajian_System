    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" style="display: flex; align-items: center; justify-content: center; margin-top: 1.5rem; margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; background-color: #2f3640; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); overflow: hidden;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span style="display: inline-flex; align-items: center; justify-content: center; padding: 0.5rem 1rem; color: #8a929e; background-color: #2f3640; cursor: not-allowed;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display: inline-flex; align-items: center; justify-content: center; padding: 0.5rem 1rem; color: #8a929e; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#252a32'; this.style.color='#ffffff'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#8a929e'">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            @endif

            {{-- Current Page Number --}}
            <span style="display: inline-flex; align-items: center; justify-content: center; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 600; color: #8fb1f3; background-color: #3f4a59; border-left: 1px solid #3a4454; border-right: 1px solid #3a4454;">
                {{ $paginator->currentPage() }}
            </span>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display: inline-flex; align-items: center; justify-content: center; padding: 0.5rem 1rem; color: #8a929e; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#252a32'; this.style.color='#ffffff'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#8a929e'">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </a>
            @else
                <span style="display: inline-flex; align-items: center; justify-content: center; padding: 0.5rem 1rem; color: #8a929e; background-color: #2f3640; cursor: not-allowed;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </span>
            @endif
        </div>
    </nav>
