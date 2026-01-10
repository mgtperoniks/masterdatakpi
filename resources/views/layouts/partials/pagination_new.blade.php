@if ($paginator->hasPages())
    <div class="flex items-center justify-between py-6 px-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="text-xs font-semibold text-slate-300 dark:text-slate-600 flex items-center cursor-default">
                <span class="material-icons-outlined text-sm mr-1">chevron_left</span> Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="text-xs font-semibold text-slate-400 dark:text-slate-500 flex items-center hover:text-primary transition-colors">
                <span class="material-icons-outlined text-sm mr-1">chevron_left</span> Previous
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex space-x-2">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="w-8 h-8 flex items-center justify-center text-slate-400 text-xs font-medium">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="w-8 h-8 rounded-xl flex items-center justify-center bg-primary text-white text-xs font-bold shadow-md shadow-primary/20">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="w-8 h-8 rounded-xl flex items-center justify-center bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-medium border border-slate-100 dark:border-slate-700 hover:border-primary transition-all">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="text-xs font-semibold text-primary flex items-center hover:opacity-80 transition-opacity">
                Next <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
            </a>
        @else
            <span class="text-xs font-semibold text-slate-300 dark:text-slate-600 flex items-center cursor-default">
                Next <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
            </span>
        @endif
    </div>
@endif