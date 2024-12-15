<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'supporting_statement',
        'cv_path',
        'vacancy_reference',
        'user_id', // New field for user relationship
    ];

    // Relationship with Vacancy
    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_reference');
    }

    // Relationship with User (Applicant)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
