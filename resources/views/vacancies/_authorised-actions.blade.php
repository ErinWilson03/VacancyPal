@can('edit', App\Models\Vacancy::class)
    <x-ui.link variant="light" href="{{ route('vacancies.edit', $vacancy->id )}}"
        class="flex gap-1 items-center text-lightBlue-600 hover:text-lightBlue-800">
        <x-ui.svg plus size="sm" />
        <span>Edit this Vacancy</span>
    </x-ui.link>
@endcan

@can('delete', App\Models\Vacancy::class)
    <x-ui.link variant="light" href="{{ route('vacancies.destroy', $vacancy->id) }}"
        class="flex gap-1 items-center text-lightBlue-600 hover:text-lightBlue-800">
        <x-ui.svg minus size="sm" />
        <span>Delete this Vacancy</span>
    </x-ui.link>
@endcan
