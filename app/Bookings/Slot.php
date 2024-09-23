<?php

namespace App\Bookings;

use Carbon\Carbon;

class Slot
{
    public $employees = array();

    public function __construct(
        public Carbon $time
    ) {}
}
