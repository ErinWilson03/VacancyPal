<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => route('home'),
        'Vacancies' => route('vacancies.index'),
        $vacancy->reference_number => route('vacancies.show', $vacancy->id),
        'Application' => '',
    ]" />

    <div class="mx-5">
        <x-ui.header>
            <h1 class="text-4xl font-bold text-darkBlue-500 ml-4">Application for {{ $vacancy->title }}</h1>
        </x-ui.header>
    </div>

    {{-- Overview of Vacancy Details --}}
    <x-ui.card>
        <div class="flex flex-col md:flex-row items-center gap-4 md:gap-8 m-1">

            {{-- Company Logo and Name --}}
            <div class="flex flex-col items-center gap-4 w-full md:w-1/4">
                <img src="{{ asset($vacancy->company->logo) }}" alt="{{ $vacancy->company->company_name }} Logo"
                    class="w-24 h-24 rounded-full object-cover shadow-md">

                <h2 class="font-semibold text-darkBlue-700 text-xl">
                    {{ $vacancy->company->company_name }}
                </h2>
            </div>

            {{-- Job Title --}}
            <div class="w-full md:w-1/4">
                <h2 class="text-darkBlue-200">{{ $vacancy->title }}</h2>
            </div>

            {{-- Vacancy Details (Reference, Industry, Type) --}}
            <div class="w-full md:w-1/4">
                <h3 class="text-sm text-gray-500">Reference Number: {{ $vacancy->reference_number }}</h3>

                <div class="inline-flex gap-2">
                    <x-ui.badge class="text-sm text-gray-500" variant="indigo">
                        {{ $vacancy->industry }}
                        Industry
                    </x-ui.badge>
                    <x-ui.badge class="text-sm">{{ $vacancy->vacancy_type }}</x-ui.badge>
                </div>
            </div>

            {{-- Location and Salary --}}
            <div class="w-full md:w-1/4">
                <h3 class="text-sm text-gray-500">Location: {{ $vacancy->location }}</h3>
                <h3 class="text-sm text-gray-500">Salary: £{{ $vacancy->salary }}</h3>
            </div>
        </div>
    </x-ui.card>

    <x-ui.card>
        <form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data">
            @csrf
            @include('applications._inputs')

            <div class="flex mt-4 gap-4 items-center">
                <x-ui.button variant="darkBlue" type="submit">Submit Application</x-ui.button>
                {{-- TODO: add a modal or something saying that your details will not be saved if you leave this page --}}
                <x-ui.link variant="lightBlue"
                    href="{{ route('vacancies.show', ['id', $vacancy->id]) }}">Cancel</x-ui.link>
            </div>
        </form>
    </x-ui.card>

</x-layout>
