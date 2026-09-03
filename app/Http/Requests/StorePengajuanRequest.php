<?php

namespace App\Http\Requests;

use App\Repository\Contracts\CustomerRepoInterface;
use App\Rules\NominalMaksimalRule;
use App\Rules\PendapatanMinimalRule;
use App\Rules\PengajuanMaksimalRule;
use App\Rules\TenorMaksimalRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:255', new PengajuanMaksimalRule(app(CustomerRepoInterface::class))],
            'pendapatan_per_bulan' => ['required', 'numeric', new PendapatanMinimalRule()],
            'tipe_pengajuan' => ['required', 'string', 'in:Sepeda Motor,Mobil,Multiguna'],
            'nominal_pengajuan' => ['required', 'numeric', new NominalMaksimalRule()],
            'tenor' => ['required', 'integer', new TenorMaksimalRule()],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
