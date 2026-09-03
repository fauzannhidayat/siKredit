<?php

namespace App\Http\Controllers;

use App\Service\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function search(Request $request)
    {
        $name = (string) $request->query('nama_lengkap', '');
 
        $customers = $this->customerService->searchCustomersByName($name);
    
        return response()->json($customers);
    }
}
