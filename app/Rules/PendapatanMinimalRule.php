<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PendapatanMinimalRule implements ValidationRule
{

    private const MINIMAL_PENDAPATAN = 1000000; 
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value < self::MINIMAL_PENDAPATAN) {
            $fail('Nasabah belum dapat mengajukan pinjaman');
        }
    }
}
