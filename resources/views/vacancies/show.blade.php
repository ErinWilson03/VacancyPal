<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Vacancies' => route('vacancies.index'),
        $vacancy->reference_number => '', // Show the reference number
    ]" />

    <div class="mx-5">
        <x-ui.header>
            <h1 class="text-4xl font-bold text-darkBlue-500 ml-4">{{ $vacancy->title }}</h1>
        </x-ui.header>

        @include('vacancies._vacancy-details', ['vacancy' => $vacancy])

        @can('edit', App\Models\Vacancy::class)
            <x-ui.link variant="light" href="{{ route('vacancies.edit', $vacancy->id) }}"
                class="flex gap-1 items-center text-lightBlue-600 hover:text-lightBlue-800">
                <x-ui.svg plus size="sm" />
                <span>Edit this Vacancy</span>
            </x-ui.link>
        @endcan

        @include('vacancies._delete', ['vacancy' => $vacancy])
    </div>
</x-layout>
