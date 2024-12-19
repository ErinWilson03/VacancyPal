<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Vacancies' => route('vacancies.index'),
        'Create Vacancy' => '',
    ]" />

    <x-ui.header>
        <h2 class="ml-5 text-darkBlue-500 font-bold">Create a New Vacancy</h2>
    </x-ui.header>

    <x-ui.card>
        <form method="POST" action="{{ route('vacancies.store') }}" enctype="multipart/form-data">
            @csrf
            @include('vacancies._inputs')

            <div class="flex mt-4 gap-4 items-center">
                <x-ui.button variant="darkBlue" type="submit">Save Vacancy</x-ui.button>
                <x-ui.link variant="lightBlue" href="{{ route('vacancies.index') }}">Cancel</x-ui.link>
            </div>
        </form>
    </x-ui.card>

</x-layout>