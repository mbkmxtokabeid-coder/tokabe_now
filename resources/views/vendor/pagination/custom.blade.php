@if ($paginator->hasPages())
    @php
        $start = max(1, $paginator->currentPage() - 2);
        $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
        if ($end - $start < 4) {
            if ($start == 1) {
                $end = min($paginator->lastPage(), 5);
            } else {
                $start = max(1, $paginator->lastPage() - 4);
            }
        }
    @endphp

    <div class="w-full flex justify-center py-4">
        <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="{{ __('Pagination Navigation') }}">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-3 sm:px-4 py-2 rounded-l-md border border-white/10 bg-[#1A0F07] text-sm font-medium text-gray-500 opacity-60 cursor-not-allowed" aria-disabled="true" aria-label="{{ __('Previous') }}">
                    <i class="fas fa-chevron-left text-xs" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('Previous') }}</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 sm:px-4 py-2 rounded-l-md border border-white/10 bg-[#2E1E10] text-sm font-medium text-gray-200 hover:bg-[#3D2514] hover:text-[#D4A569] transition-colors" aria-label="{{ __('Previous') }}">
                    <i class="fas fa-chevron-left text-xs" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('Previous') }}</span>
                </a>
            @endif

            {{-- Array Of Links (Max 5 items) --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $paginator->currentPage())
                    <span aria-current="page" class="relative inline-flex items-center px-4 py-2 border border-[#C8902A] bg-gradient-to-r from-[#D4A569] to-[#C8902A] text-sm font-extrabold text-[#1A0F07] z-10 shadow-inner">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $paginator->url($page) }}" class="relative inline-flex items-center px-4 py-2 border border-white/10 bg-[#2E1E10] text-sm font-medium text-gray-200 hover:bg-[#3D2514] hover:text-[#D4A569] transition-colors" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                        {{ $page }}
                    </a>
                @endif
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 sm:px-4 py-2 rounded-r-md border border-white/10 bg-[#2E1E10] text-sm font-medium text-gray-200 hover:bg-[#3D2514] hover:text-[#D4A569] transition-colors" aria-label="{{ __('Next') }}">
                    <i class="fas fa-chevron-right text-xs" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('Next') }}</span>
                </a>
            @else
                <span class="relative inline-flex items-center px-3 sm:px-4 py-2 rounded-r-md border border-white/10 bg-[#1A0F07] text-sm font-medium text-gray-500 opacity-60 cursor-not-allowed" aria-disabled="true" aria-label="{{ __('Next') }}">
                    <i class="fas fa-chevron-right text-xs" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('Next') }}</span>
                </span>
            @endif
        </nav>
    </div>
@endif
