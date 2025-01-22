<?php

namespace App\Bookings;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Period\Boundaries;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Spatie\Period\Precision;

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
            $periods = (new ScheduleAvailability($employee, $this->service))
                ->forPeriod($startsAt, $endsAt);

            $periods = $this->removeAppointments($periods, $employee);

            foreach ($periods as $period) {
                $this->addAvailabilityEmployeeForPeriod($range, $period, $employee);
            }

            // remove appointments from the period collection

            // removing empty slots
            $range = $this->removeEmptySlots($range);

            // add the available employees to the range
        });

        return $range;
    }

    protected function removeAppointments(PeriodCollection $period, Employee $employee)
    {
        $employee->appointments->whereNull('cancelled_at')->each(function (Appointment $appointment) use (&$period) {
            $period = $period->subtract(
                Period::make(
                    $appointment->starts_at->copy()->subMinutes($this->service->duration)->addMinute(),
                    $appointment->ends_at,
                    Precision::MINUTE(),
                    Boundaries::EXCLUDE_ALL(),
                )
            );
        });

        return $period;
    }

    protected function removeEmptySlots(Collection $range)
    {
        return $range->filter(function (Date $date) {
            $date->slots = $date->slots->filter(function (Slot $slot) {
                return $slot->hasEmployees();
            });

            return true;
        });
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
