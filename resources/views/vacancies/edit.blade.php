<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Vacancies' => route('vacancies.index'),
        $vacancy->reference_number => route('vacancies.show', $vacancy->id),
        'Edit' => '',
    ]" />

    <x-ui.header>
        <h2 class="ml-5">Edit Vacancy {{ $vacancy->reference_number }}</h2>
    </x-ui.header>

    <x-ui.card>

        <form method="POST" action="{{ route('vacancies.update', $vacancy->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('vacancies._inputs')

            <div class="mt-4">
                <x-ui.button variant="darkBlue" type="submit">Save</x-ui.button>
                <x-ui.link variant="lightBlue" href="{{ route('vacancies.show', $vacancy->id) }}">Cancel</x-ui.link>
            </div>
        </form>
    </x-ui.card>

</x-layout>