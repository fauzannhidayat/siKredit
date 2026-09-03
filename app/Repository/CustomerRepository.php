<?php

namespace App\Repository;

use App\Models\Customer;
use App\Repository\Contracts\CustomerRepoInterface;
use Illuminate\Support\Collection;

class CustomerRepository implements CustomerRepoInterface
{
    public function getAllCustomers()
    {
       return Customer::all();
    }

    public function findCustomerByName(string $name): ?Customer
    {
        return Customer::where('nama_lengkap', $name)->first();
    }

    public function firstOrCreate(array $data): Customer
    {
        return Customer::firstOrCreate(
            ['nama_lengkap' => $data['nama_lengkap']],
            ['pendapatan_per_bulan' => $data['pendapatan_per_bulan']]
        );
    }

    public function searchCustomerByName(string $name, int $limit = 8): Collection
    {
        return Customer::where('nama_lengkap', 'like', '%' . $name . '%')
            ->orderBy('nama_lengkap')
            ->limit($limit)
            ->get(['id', 'nama_lengkap', 'pendapatan_per_bulan']);
    }
}
    
