<?php
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnumIn implements ValidationRule
{
    protected $enumClass;

    public function __construct($enumClass)
    {
        $this->enumClass = $enumClass;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Get the valid values from the enum class
        $validValues = array_map(fn($enum) => $enum->value, $this->enumClass::cases());

        // If the value doesn't exist in the valid enum values, validation fails
        if (!in_array($value, $validValues)) {
            $fail("The selected {$attribute} is invalid.");
        }
    }

    public function message(): string
    {
        return 'The selected value is invalid.';
    }
}
