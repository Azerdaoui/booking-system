<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Http\Request;

use function Termwind\render;

class CheckoutController extends Controller
{
    public function __invoke(Service $service, Employee $employee)
    {
        return inertia()->render('Checkout', [
            'service' =>  ServiceResource::make($service),
            'employee' => EmployeeResource::make($employee),
        ]);
    }
}
