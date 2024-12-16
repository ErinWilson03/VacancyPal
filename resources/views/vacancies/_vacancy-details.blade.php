<x-ui.card>

    <x-ui.card>
        <div class="flex items-center gap-4 m-4">
            {{-- Company Logo and Name --}}
            <div class="flex items-center gap-4 w-1/3">
                <img src="{{ asset($vacancy->company->logo) }}" alt="{{ $vacancy->company->company_name }} Logo"
                    class="w-24 h-24 rounded-full object-cover shadow-md">

                <h2 class="font-semibold text-darkBlue-700 text-xl">
                    {{ $vacancy->company->company_name }}
                </h2>
            </div>
                <div class="w-1/3">
                    <h3 class="text-sm text-gray-500">Reference Number: {{ $vacancy->reference_number }}</h3>

                    <div class="inline-flex">
                        <x-ui.badge class="text-sm text-gray-500" variant="indigo">
                            {{ $vacancy->industry }}
                            Industry
                        </x-ui.badge>
                        <x-ui.badge class="ml-2 text-sm">{{ $vacancy->vacancy_type }}</x-ui.badge>
                    </div>
                </div>
                <div class="w-1/3">
                    <a href="{{ route('applications.create', $vacancy->id) }}"
                        class="w-full text-white text-lg font-medium bg-darkBlue hover:bg-darkBlue-200 px-4 py-2 rounded-lg flex items-center justify-center">
                        Apply for Vacancy
                    </a>
                </div>
        </div>
    </x-ui.card>


    <div class="flex gap-2 mt-2">
        <div class="w-1/2">
            <h3 class="text-2xl font-semibold text-darkBlue-500">Job Description</h3>
            <p class="text-lg text-gray-700 mt-2">{{ $vacancy->description }}</p>
        </div>

        <div class="w-1/2">
            <h3 class="text-2xl font-semibold text-darkBlue-500">Skills Required</h3>
            <p class="text-lg text-gray-700 mt-2">{{ $vacancy->skills_required }}</p>
        </div>
    </div>

    <div class="my-6">
        <h3 class="text-2xl font-semibold text-darkBlue-500">Application Period</h3>
        <p class="text-lg text-gray-700 mt-2">Open:
            {{ \Carbon\Carbon::parse($vacancy->application_open_date)->format('F j, Y') }}</p>
        <p class="text-lg text-gray-700">Close:
            {{ \Carbon\Carbon::parse($vacancy->application_close_date)->format('F j, Y') }}</p>
    </div>

    {{-- Company Contact Info --}}
    <div class="my-6">
        <h3 class="text-2xl font-semibold text-darkBlue-500">Company Contact Info</h3>
        <p class="text-lg text-gray-700 mt-2">
            <strong>Email:</strong> <a href="mailto:{{ $vacancy->company->email }}"
                class="text-blue-500 hover:underline">{{ $vacancy->company->email }}</a>
        </p>
        <p class="text-lg text-gray-700">
            <strong>Phone:</strong> <a href="tel:{{ $vacancy->company->phone_number }}"
                class="text-blue-500 hover:underline">{{ $vacancy->company->phone_number }}</a>
        </p>
        <p class="text-lg text-gray-700">
            <strong>Website:</strong> <a href="{{ $vacancy->company->website }}" class="text-blue-500 hover:underline"
                target="_blank">{{ $vacancy->company->website }}</a>
        </p>
    </div>
</x-ui.card>
