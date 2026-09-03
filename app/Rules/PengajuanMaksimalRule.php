<?php

namespace App\Rules;

use App\Repository\Contracts\CustomerRepoInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PengajuanMaksimalRule implements ValidationRule
{
    private const MAKSIMAL_PENGAJUAN = 3;

    public function __construct(private readonly CustomerRepoInterface $customerRepository)
    {

    }
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $customer = $this->customerRepository->findCustomerByName($value);
        if ($customer && $customer->pengajuans()->count() >= self::MAKSIMAL_PENGAJUAN) {
            $fail('Nasabah sudah mencapai batas 3 kali pengajuan pinjaman');
        }
    }
}
