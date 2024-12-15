<div class="flex items-center gap-4 text-sm text-darkBlue-600">
    @if ($vacancies->onFirstPage())
        <span class="text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 18l-6-6 6-6"></path>
            </svg>
        </span>
    @else
        <a href="{{ $vacancies->previousPageUrl() }}" class="hover:text-darkBlue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 18l-6-6 6-6"></path>
            </svg>
        </a>
    @endif

    <span class="text-sm text-gray-700 font-medium">Page {{ $currentPage }} of
        {{ $totalPages }}</span>

    @if ($vacancies->hasMorePages())
        <a href="{{ $vacancies->nextPageUrl() }}" class="hover:text-darkBlue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18l6-6-6-6"></path>
            </svg>
        </a>
    @else
        <span class="text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 18l6-6-6-6"></path>
            </svg>
        </span>
    @endif
</div>