<x-ui.layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Vacancies' => route('vacancies.index'),
        $vacancy->reference_number => route('vacancies.show', ), // Show the reference number
        'Application' => '',
    ]" />

<div class="mx-5">
    <x-ui.header>
        <h1 class="text-4xl font-bold text-darkBlue-500 ml-4">Application for {{ $vacancy->title }}</h1>
    </x-ui.header>

</div>
</x-ui.layout>