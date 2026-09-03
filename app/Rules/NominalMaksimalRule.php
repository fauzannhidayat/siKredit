<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class NominalMaksimalRule implements ValidationRule
{
    private const MAKSIMAL_NOMINAL = 200000000;
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value > self::MAKSIMAL_NOMINAL) {
            $fail('Nominal pinjaman yang dapat disetujui tidak boleh melebihi Rp 200.000.000');
        }
    }
}
