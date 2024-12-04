<?php

namespace App\Models;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\VacancyTypeEnum;
use App\Enums\IndustryEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vacancy extends Model
{
    /** @use HasFactory<\Database\Factories\VacancyFactory> */
    /** @use App\Traits\Sortable  **/
    use HasFactory;
    use Sortable;

    protected $guarded = ['id'];

    protected $casts = [
        'vacancy_type' => VacancyTypeEnum::class,
        'industry' => IndustryEnum::class,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }


     // scope search method
     public function scopeSearch($query, $value)
     {
         if ($value) {
             return $query
                 ->where('title', 'like', "%{$value}%")
                 ->orWhere('description', 'like', "%{$value}%")
                 ->orWhere('year', 'like', "%{$value}%")
                 ->orWhere('email', 'like', "%{$value}%")
                 ->orWhereHas(
                     'category',
                     fn($q) =>
                     $q->where('name', 'like', "%{$value}%")
                 );
         }
         return $query;
     }
}
