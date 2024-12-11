<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Vacancies' => '',
    ]" />

    <div class="mx-5">
        <x-ui.header>
            <h1>Vacancies</h1>
            @can('create', App\Models\Vacancy::class)
                <x-ui.link variant="light" href="{{ route('vacancies.create') }}" class="flex gap-1 items-center">
                    <x-ui.svg plus size="sm" />
                    <span>Add New Vacancy</span>
                </x-ui.link>
            @endcan
        </x-ui.header>

        {{-- TODO: fix search and filter and sort functionality --}}
        @include('vacancies._search')

        <div class="mt-6 flex justify-between items-center">
            <!-- Vacancies Found Text on the Left -->
            <p class="text-sm text-gray-500">{{ $vacancyCount }} vacancies found</p>
        
            <!-- Right Section with SortBy and Pagination -->
            <div class="flex items-center gap-4">
                <!-- Sort By Dropdown -->
                <form method="GET" action="{{ route('vacancies.index') }}" class="flex items-center gap-2">
                    <label for="sort_by" class="text-sm text-gray-600">Sort By:</label>
                    <select name="sort_by" id="sort_by" class="p-2 border rounded text-sm text-gray-600">
                        <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                        <option value="application_open_date" {{ request('sort_by') == 'application_open_date' ? 'selected' : '' }}>Opening Date</option>
                        <option value="application_close_date" {{ request('sort_by') == 'application_close_date' ? 'selected' : '' }}>Closing Date</option>
                        <option value="vacancy_type" {{ request('sort_by') == 'vacancy_type' ? 'selected' : '' }}>Vacancy Type</option>
                    </select>
                    <button type="submit" class="bg-darkBlue-600 text-white p-2 rounded hover:bg-darkBlue-700">Sort</button>
                </form>
        
                <!-- Pagination with Arrows -->
                <div class="flex items-center gap-4 text-sm text-darkBlue-600">
                    <!-- Previous Page Link with Left Arrow -->
                    @if ($vacancies->onFirstPage())
                        <span class="text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 18l-6-6 6-6"></path>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $vacancies->previousPageUrl() }}" class="hover:text-darkBlue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 18l-6-6 6-6"></path>
                            </svg>
                        </a>
                    @endif
        
                    <!-- Pagination Information -->
                    <span class="text-sm text-gray-700 font-medium">Page {{ $currentPage }} of {{ $totalPages }}</span>
        
                    <!-- Next Page Link with Right Arrow -->
                    @if ($vacancies->hasMorePages())
                        <a href="{{ $vacancies->nextPageUrl() }}" class="hover:text-darkBlue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"></path>
                            </svg>
                        </a>
                    @else
                        <span class="text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"></path>
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        

        
        <div class="container mx-auto px-4 py-8 flex flex-col lg:flex-row gap-6">
            <!-- Filters Section -->
            <aside class="w-full lg:w-1/4 bg-white p-4 rounded-lg shadow-md border border-gray-200">
                <h3 class="text-xl font-semibold text-darkBlue-700 mb-4">Filter Vacancies</h3>

                <form method="GET" action="{{ route('vacancies.index') }}">

                    <!-- Industry Filter -->
                    <div class="mb-4">
                        <h4 class="text-md font-medium mb-2">Industry</h4>
                        <select name="industry" class="w-full p-2 border rounded">
                            <option value="">All Industries</option>
                            @foreach (App\Enums\IndustryEnum::cases() as $industry)
                                <option value="{{ $industry->value }}"
                                    {{ request('industry') == $industry->value ? 'selected' : '' }}>
                                    {{ $industry->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Vacancy Type Filter -->
                    <div class="mb-4">
                        <h4 class="text-md font-medium mb-2">Vacancy Type</h4>
                        <select name="vacancy_type" class="w-full p-2 border rounded">
                            <option value="">All Types</option>
                            @foreach (App\Enums\VacancyTypeEnum::cases() as $type)
                                <option value="{{ $type->value }}"
                                    {{ request('vacancy_type') == $type->value ? 'selected' : '' }}>
                                    {{ ucfirst($type->value) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TODO: change variant --}}
                    <button type="submit" class="w-full">
                        Apply Filters
                    </button>
                </form>
            </aside>

            <!-- Vacancy Listings Section -->
            <div class="w-full lg:w-3/4">
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($vacancies as $vacancy)
                        <div class="bg-lightBlue-200 p-6 rounded-lg shadow-lg hover:shadow-2xl transition ease-in-out duration-300">
                            <h2 class="text-2xl font-semibold text-darkBlue-500 mb-2">{{ $vacancy->title }}</h2>
                            <p class="text-midBlue-500 mb-4">{{ Str::limit($vacancy->description, 150) }}</p>
                
                            <div class="flex flex-col gap-2">
                                <x-ui.badge class="w-fit text-sm">Industry: {{ $vacancy->industry }}</x-ui.badge>
                                <x-ui.badge class="w-fit text-sm">Type: {{ ucfirst($vacancy->vacancy_type->value) }}</x-ui.badge>
                                <x-ui.badge class="w-fit text-sm">Opening Date: {{ $vacancy->application_open_date }}</x-ui.badge>
                                <x-ui.badge class="w-fit text-sm">Closing Date: {{ $vacancy->application_close_date }}</x-ui.badge>
                            </div>
                
                            @if ($vacancy->isDeadlineApproaching)
                                <p class="text-red-600 mt-2">Hurry! The application deadline is approaching.</p>
                            @elseif ($vacancy->isDeadlinePassed)
                                <p class="text-gray-600 mt-2">Sorry, the application deadline has passed.</p>
                            @endif
                
                            <a href="{{ route('vacancies.show', $vacancy->id) }}" class="text-darkBlue-600 hover:text-darkBlue-700 mt-2 inline-block">
                                Read more
                            </a>
                        </div>
                    @endforeach
                
                    @if($vacancies->isEmpty())
                        <p class="text-gray-500">Oops! No vacancies matching the selected criteria.</p>
                    @endif
                </div>
                
                
            </div>
        </div>
    </x-layout>
