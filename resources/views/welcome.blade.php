<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="['Home' => '']" />

    <section class="bg-white">
        <div class="flex flex-col items-center justify-center py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
            <h1
                class="flex gap-2 items-baseline mb-4 text-4xl font-extrabold tracking-tight leading-none text-midBlue md:text-5xl lg:text-6xl ">
                <span>VacancyPal</span>
                <x-ui.svg logo size="lg" />
            </h1>

            @can('create', App\Models\Vacancy::class)
            
            @endcan

            {{-- Check if user is an Author --}}
            @can('create', App\Models\Vacancy::class)
                <h1>Welcome, Author</h1>
                <h2>View applications for all vacancies available in the company</h2>
                <x-ui.link variant="light" href="{{ route('vacancies.create') }}"
                    class="flex gap-1 items-center text-lightBlue-600 hover:text-lightBlue-800">
                    <span>View Applications</span>
                </x-ui.link>

                <x-ui.link variant="light" href="{{ route('vacancies.create') }}"
                    class="flex gap-1 mt-2 items-center text-lightBlue-600 hover:text-lightBlue-800">
                    <span>View All Vacancies on Site</span>
                </x-ui.link>
            @endcan

            {{-- Check if user is authenticated but not an Author --}}
            @auth
                <p class="mb-8 text-lg font-normal text-gray-600 lg:text-xl sm:px-16 lg:px-48">The only job-searching tool
                    you need!</p>
                <a href="{{ route('vacancies.index') }}" role="button"
                    class="mb-8 text-md sm:px-16 lg:px-48 text-lightBlue-500 font-bold underline hover:text-lightBlue-700 transition duration-300 ease-in-out">
                    Continue your job-hunting journey now!
                </a>
            @endauth

            {{-- Check if the user is a guest --}}
            @guest
                <p class="mb-8 text-lg font-normal text-gray-600 lg:text-xl sm:px-16 lg:px-48">The only job-searching tool
                    you need!</p>
                <p class="mb-3 text-md font-normal sm:px-16 lg:px-48 text-midBlue-500">Are you ready to find your next
                    career pathway?</p>
                <a href="{{ route('vacancies.index') }}" role="button"
                    class="mb-8 text-md sm:px-16 lg:px-48 text-lightBlue-500 font-bold underline hover:text-lightBlue-700 transition duration-300 ease-in-out">
                    Start your journey now
                </a>
            @endguest
        </div>
    </section>
</x-layout>
