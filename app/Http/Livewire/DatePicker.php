<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Haringsrob\LivewireDatepicker\Http\Livewire\DatePickerComponent;

class DatePicker extends DatePickerComponent
{
    public string $type = self::TYPE_RANGE_PICKER;

    public function onDatesSet(): void
    {
        $this->emit('rangeSet', ['from' => $this->startRange->format('Y-m-d'), 'till' => $this->endRange->format('Y-m-d')]);
    }
}
