<?php

namespace App\Service;

use App\Repository\Contracts\CustomerRepoInterface;

class CustomerService
{
    protected CustomerRepoInterface $customerRepo;
    
    public function __construct(CustomerRepoInterface $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function getAllCustomers()
    {
        return $this->customerRepo->getAllCustomers();
    }

    public function findCustomerByName(string $name)
    {
        return $this->customerRepo->findCustomerByName($name);
    }

    public function searchCustomersByName(string $name, int $limit = 8)
    {
        if (mb_strlen(trim($name)) < 3) {
            return collect();
        }
 
        return $this->customerRepo->searchCustomerByName(trim($name), $limit);
    }
    
}
