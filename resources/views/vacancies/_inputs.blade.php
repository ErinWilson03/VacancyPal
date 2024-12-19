<div class="mt-2">
    <x-ui.form.input label="Title" name="title" type="text" value="{{ old('title', $vacancy->title) }}" />
</div>

{{-- Vacancy Type and Industry Inputs --}}
<div class="flex gap-4 mt-4">
    <div class="w-1/2">
        <x-ui.form.select label="Industry" name="industry" :options="$industries" 
            value="{{ old('industry', $vacancy->industry) }}">
            @foreach($industries as $industry)
                <option value="{{ $industry->value }}" {{ old('industry') == $industry->value ? 'selected' : '' }}>
                    {{ $industry->name }}
                </option>
            @endforeach
        </x-ui.form.select>
    </div>
    
    <div class="w-1/2">
        <x-ui.form.select label="Vacancy Type" name="vacancy_type" :options="$vacancyTypes"
            value="{{ old('vacancy_type', $vacancy->vacancy_type) }}">
            @foreach($vacancyTypes as $vacancyType)
                <option value="{{ $vacancyType->value }}" {{ old('vacancy_type') == $vacancyType->value ? 'selected' : '' }}>
                    {{ $vacancyType->name }}
                </option>
            @endforeach
        </x-ui.form.select>
    </div>
    
</div>

{{-- Open and Close Dates --}}
<div class="flex gap-4 mt-4">
    <div class="w-1/2">
        <x-ui.form.input label="Opening Date" name="application_open_date" type="datetime-local"
            value="{{ old('application_open_date', $vacancy->application_open_date ? \Carbon\Carbon::parse($vacancy->application_open_date)->format('Y-m-d\TH:i') : '') }}" />
    </div>
    <div class="w-1/2">
        <x-ui.form.input label="Closing Date" name="application_close_date" type="datetime-local"
            value="{{ old('application_close_date', $vacancy->application_close_date ? \Carbon\Carbon::parse($vacancy->application_close_date)->format('Y-m-d\TH:i') : '') }}" />
    </div>
</div>


{{-- Textareas for Description and Skills Required --}}
<div class="mt-4">
    <x-ui.form.textarea label="Description" name="description"
        rows="6">{{ old('description', $vacancy->description) }}</x-ui.form.textarea>
</div>

<div class="mt-4">
    <x-ui.form.textarea label="Skills Required" name="skills_required"
        rows="4">{{ old('skills_required', $vacancy->skills_required) }}</x-ui.form.textarea>
</div>

{{-- Company Dropdown --}}
<div class="flex gap-4 items-start mt-4">
    <div class="w-full">
        <x-ui.form.select label="Company" name="company_id" :options="$companies"
            value="{{ old('company_id', $vacancy->company_id) }}" />
    </div>
</div>
