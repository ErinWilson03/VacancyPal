<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;
    
    protected $table = 'applications';

    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'supporting_statement',
        'cv_path',
        'vacancy_reference',
    ];

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }

}
