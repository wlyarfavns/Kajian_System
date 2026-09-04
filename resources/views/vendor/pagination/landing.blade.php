@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; justify-content: center; align-items: center; gap: 8px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" aria-label="@lang('pagination.previous')" style="padding: 10px 16px; border-radius: 12px; background: var(--paper); border: 1px solid var(--line); color: var(--line); cursor: not-allowed; display: inline-flex; align-items: center; font-size: 14px; font-weight: 600;">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')" style="padding: 10px 16px; border-radius: 12px; background: var(--paper); border: 1px solid var(--gold); color: var(--ink); display: inline-flex; align-items: center; font-size: 14px; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='var(--gold-pale)'" onmouseout="this.style.background='var(--paper)'">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span aria-disabled="true" style="padding: 10px 16px; border-radius: 12px; background: transparent; color: var(--ink-soft); display: inline-flex; align-items: center; font-size: 14px; font-weight: 600;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" style="padding: 10px 16px; border-radius: 12px; background: var(--jade-950); color: var(--parchment); display: inline-flex; align-items: center; font-size: 14px; font-weight: 700; box-shadow: 0 4px 12px rgba(10,43,32,0.15);">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}" style="padding: 10px 16px; border-radius: 12px; background: var(--paper); border: 1px solid var(--line); color: var(--ink-soft); display: inline-flex; align-items: center; font-size: 14px; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='rgba(184,134,59,.1)'; this.style.color='var(--ink)'" onmouseout="this.style.background='var(--paper)'; this.style.color='var(--ink-soft)'">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')" style="padding: 10px 16px; border-radius: 12px; background: var(--paper); border: 1px solid var(--gold); color: var(--ink); display: inline-flex; align-items: center; font-size: 14px; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='var(--gold-pale)'" onmouseout="this.style.background='var(--paper)'">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        @else
            <span aria-disabled="true" aria-label="@lang('pagination.next')" style="padding: 10px 16px; border-radius: 12px; background: var(--paper); border: 1px solid var(--line); color: var(--line); cursor: not-allowed; display: inline-flex; align-items: center; font-size: 14px; font-weight: 600;">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </span>
        @endif
    </nav>
@endif
