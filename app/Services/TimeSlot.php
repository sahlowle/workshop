<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class TimeSlot
{
    public static function create($start, $end, int $interval, string $format = 'H:i', array $excludes = []): Collection
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        // +1 day if the end time is before the start time AND both are without date/on the same date
        if ($start->isSameDay($end) && $end->isBefore($start)) {
            $end = $end->addDay();
        }

        $period = CarbonInterval::minutes($interval)->toPeriod($start, $end);

        /** @phpstan-ignore-next-line */
        return collect($period)
            ->reject(function (Carbon $carbon) use ($excludes) {
                foreach ($excludes as $exclude) {
                    if ($carbon->is(Carbon::parse($exclude))) {
                        return true;
                    }
                }

                return false;
            })
            ->map->format($format)
            ->values();
    }
}