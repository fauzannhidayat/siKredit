<?php

namespace App\Repository\Contracts;

use App\Models\Customer;
use Illuminate\Support\Collection;

interface CustomerRepoInterface
{
    public function getAllCustomers();
    public function findCustomerByName(string $name): ?Customer;
    public function searchCustomerByName(string $name, int $limit): Collection;
    public function firstOrCreate(array $data): Customer;
}
