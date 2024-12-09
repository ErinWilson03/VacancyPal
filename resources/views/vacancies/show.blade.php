<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Vacancies' => route('vacancies.index'),
        $vacancy->reference_number => '' // TODO: fix this so it actually says the ref number
    ]" />

<x-ui.header>
    <h1 class="text-4xl font-bold text-dark_blue-500">{{ $vacancy->title }}</h1>
</x-ui.header>

<div class="flex items-center gap-4 mt-4">
    {{-- TODO: fix logo path here and also the colours and things--}}
    <img src="{{ asset($vacancy->logo) }}" alt="{{ $vacancy->company->company_name }} Logo" class="w-16 h-16 rounded-full object-cover shadow-md">
    <div>
        {{-- TODO: need to add model and controller etc. and a view to look at company info  --}}
        <h2 class="text-xl font-semibold text-dark_blue-700"> <a href="{{ route('vacancies.show', $vacancy->id) }}" >{{ $vacancy->company->company_name }}</a></h2>
        <h3 class="text-sm text-gray-500">Reference Number: {{ $vacancy->reference_number }}</h3>
        <p class="text-sm text-gray-500">{{ $vacancy->industry }} Industry</p>
        <p class="text-sm text-gray-500">{{ $vacancy->vacancy_type }}</p>
    </div>
</div>


</x-layout>