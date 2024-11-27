<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;
    
    protected $table = 'applications';

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'supporting_statement',
        'cv_path',
        'vacancy_id', // This links to the Vacancy model
    ];

    // Define the relationship with the Vacancy model (one application belongs to one vacancy)
    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
