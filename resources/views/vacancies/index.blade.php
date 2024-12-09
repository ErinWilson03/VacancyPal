<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Vacancies' => '',
    ]" />

    <x-ui.header>
        <h1>Vacancies</h1>
        @can('create', App\Models\Vacancy::class)
            <x-ui.link variant="light" href="{{ route('vacancies.create') }}" class="flex gap-1 items-center">
                <x-ui.svg plus size="sm" />
                <span>Add New Vacancy</span>
            </x-ui.link>
        @endcan
    </x-ui.header>


    {{-- TODO: fix search functionality --}}
    @include('vacancies._search')

   

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-mid_blue-500 mb-6">Job Vacancies</h1>

        <!-- Vacancy Listings -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($vacancies as $vacancy)
                <div class="bg-light_blue-200 p-6 rounded-lg shadow-lg hover:shadow-2xl transition ease-in-out duration-300">
                    <h2 class="text-2xl font-semibold text-dark_blue-500 mb-2">{{ $vacancy->title }}</h2>
                    <p class="text-mid_blue-500 mb-4">{{ Str::limit($vacancy->description, 150) }}</p>
                    <a href="{{ route('vacancies.show', $vacancy->id) }}" class="text-dark_blue-600 hover:text-dark_blue-700">Read more</a>
                </div>
            @endforeach
        </div>
    </div>
    
</x-layout>