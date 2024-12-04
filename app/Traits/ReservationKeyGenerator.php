<?php

namespace App\Traits;

trait ReservationKeyGenerator
{
    protected function formatDate($date): string
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }

    protected function formatTime($time): string
    {
        return \Carbon\Carbon::parse($time)->format('H:i');
    }

    public function generateTableKey($tableId, $date, $startTime, $endTime): string
    {
        $formattedDate = $this->formatDate($date);
        $formattedStartTime = $this->formatTime($startTime);
        $formattedEndTime = $this->formatTime($endTime);

        return "reservation:table:$tableId:$formattedDate:$formattedStartTime-$formattedEndTime";
    }

    public function generateHallKey($hallId, $date, $startTime, $endTime): string
    {
        $formattedDate = $this->formatDate($date);
        $formattedStartTime = $this->formatTime($startTime);
        $formattedEndTime = $this->formatTime($endTime);

        return "reservation:hall:$hallId:$formattedDate:$formattedStartTime-$formattedEndTime";
    }
}
