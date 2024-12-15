<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Vacancy;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

// TODO: REVISIT THIS SUITE CAUSE EVERYTHING MIGHT BE BROKEN



class VacancyControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $company;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default user and company for use in tests
        $this->user = User::factory()->create();
        $this->company = Company::factory()->create();
    }

    /**
     * Test that vacancies are listed correctly.
     */
    public function testIndex_DisplaysVacancies()
    {
        // Create 3 vacancies
        Vacancy::factory()->count(3)->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->get(route('vacancies.index'));

        $response->assertStatus(200);
        $response->assertViewIs('vacancies.index');
        $response->assertViewHas('vacancies');
    }

    /**
     * Test that a vacancy can be created successfully.
     */
    public function testStore_CreatesValidVacancy()
    {
        $this->actingAs($this->user);

        $data = [
            'title' => 'New Vacancy',
            'company_id' => $this->company->id,
            'company_name' => $this->company->name,
            'skills_required' => 'PHP, Laravel',
            'application_open_date' => now()->toDateString(),
            'application_close_date' => now()->addDays(10)->toDateString(),
            'industry' => 'IT',
            'vacancy_type' => 'full-time',
        ];

        $response = $this->post(route('vacancies.store'), $data);

        $response->assertRedirect(route('vacancies.index'));
        $this->assertDatabaseHas('vacancies', ['title' => 'New Vacancy']);
    }

    /**
     * Test validation errors when creating a vacancy with invalid data.
     */
    public function testStore_HasValidationErrors()
    {
        $this->actingAs($this->user);

        $data = [
            'title' => '', // Title is required
            'company_id' => null, // Company ID is required
        ];

        $response = $this->post(route('vacancies.store'), $data);

        $response->assertSessionHasErrors(['title', 'company_id']);
    }

    /**
     * Test showing a specific vacancy.
     */
    public function testShowVacancy()
    {
        $vacancy = Vacancy::factory()->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->get(route('vacancies.show', $vacancy->id));

        $response->assertStatus(200);
        $response->assertViewIs('vacancies.show');
        $response->assertViewHas('vacancy', $vacancy);
    }

    /**
     * Test editing a vacancy.
     */
    public function testEditVacancy()
    {
        $vacancy = Vacancy::factory()->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->get(route('vacancies.edit', $vacancy->id));

        $response->assertStatus(200);
        $response->assertViewIs('vacancies.edit');
        $response->assertViewHas('vacancy', $vacancy);
    }

    /**
     * Test updating a vacancy.
     */
    public function testUpdateVacancy()
    {
        $vacancy = Vacancy::factory()->create(['company_id' => $this->company->id]);

        $updatedData = [
            'title' => 'Updated Vacancy Title',
            'company_id' => $this->company->id,
            'company_name' => $this->company->name,
            'application_open_date' => now()->toDateString(),
            'application_close_date' => now()->addDays(5)->toDateString(),
            'industry' => 'IT',
            'vacancy_type' => 'part-time',
        ];

        $response = $this->actingAs($this->user)->put(route('vacancies.update', $vacancy->id), $updatedData);

        $response->assertRedirect(route('vacancies.show', $vacancy->id));
        $this->assertDatabaseHas('vacancies', ['title' => 'Updated Vacancy Title']);
    }

    /**
     * Test deleting a vacancy. TODO: not working
     */
    public function testDestroyVacancy()
    {
        $vacancy = Vacancy::factory()->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->delete(route('vacancies.destroy', $vacancy->id));

        $response->assertRedirect(route('vacancies.index'));
        $this->assertDatabaseMissing('vacancies', ['id' => $vacancy->id]);
    }
}
