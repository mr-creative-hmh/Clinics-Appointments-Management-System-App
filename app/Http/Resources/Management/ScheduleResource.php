<?php

namespace App\Http\Resources\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "DayOfWeek" => $this->day_of_week,
            "StartTime" => $this->start_time,
            "EndTime" => $this->end_time,
        ];
    }
}
