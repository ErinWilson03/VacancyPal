<x-layout>
    <x-ui.breadcrumb class="my-3" :crumbs="[
        'Home' => '',
    ]" />
    <section class="bg-white">
        <div class="flex flex-col items-center justify-center py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
            <h1
                class="flex gap-2 items-baseline mb-4 text-4xl font-extrabold tracking-tight leading-none text-midBlue md:text-5xl lg:text-6xl ">
                <span>VacancyPal</span>
                <x-ui.svg logo size="lg" />
            </h1>

            <p class="mb-8 text-lg font-normal text-gray-600 lg:text-xl sm:px-16 lg:px-48">The only job-searching tool you need!</p>

            <p class="mb-3 text-md font-normal sm:px-16 lg:px-48 text-midBlue-500">Are you ready to find your next career pathway?</p>

            <a href="{{ route('vacancies.index') }}" role="button" class="mb-8 text-md sm:px-16 lg:px-48 text-lightBlue-500 font-bold underline hover:text-lightBlue-700 transition duration-300 ease-in-out">
                Start your journey now
            </a>
        </div>
    </section>
</x-layout>
