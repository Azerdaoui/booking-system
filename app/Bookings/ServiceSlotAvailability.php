<?php

namespace App\Bookings;

use App\Models\Employee;
use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Support\Collection;
use Spatie\Period\Period;

class ServiceSlotAvailability
{
    public function __construct(
        protected Collection $employees,
        protected Service $service
    ) {}

    public function forPeriod(Carbon $startsAt, Carbon $endsAt)
    {
        $range = (new SlotRangeGenerator($startsAt, $endsAt))->generate($this->service->duration);

        $this->employees->each(function (Employee $employee) use ($startsAt, $endsAt, &$range) {
            // get the availability for the empployee
            $periods = (new ScheduleAvailability($employee, $this->service))
                ->forPeriod($startsAt, $endsAt);

            foreach ($periods as $period) {
                $this->addAvailabilityEmployeeForPeriod($range, $period, $employee);
            }
            // remove appointments from the period collection
            // add the available employees to the range
            // removing emoty slots
        });

        return $range;
    }

    protected function addAvailabilityEmployeeForPeriod(
        Collection $range,
        Period $period,
        Employee $employee,
    ) {
        $range->each(function ($date) use ($period, $employee) {
            $date->slots->each(function ($slot) use ($period, $employee) {
                // periods contains the slot time.
                if ($period->contains($slot->time)) {
                    $slot->addEmployee($employee);
                }
            });
        });
    }
}
