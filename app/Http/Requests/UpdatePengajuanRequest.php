<?php

namespace App\Http\Requests;

use App\Rules\NominalMaksimalRule;
use App\Rules\PendapatanMinimalRule;
use App\Rules\TenorMaksimalRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'pendapatan_per_bulan' => ['required', 'numeric', new PendapatanMinimalRule()],
            'tipe_pengajuan' => ['required', 'string', 'in:Sepeda Motor,Mobil,Multiguna'],
            'nominal_pengajuan' => ['required', 'numeric', new NominalMaksimalRule()],
            'tenor' => ['required', 'integer', new TenorMaksimalRule()],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
