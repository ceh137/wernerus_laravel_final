<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;

class LoadingSpinner extends Component
{
    public string $cssScope;

    public function mounted() {

        $this->cssScope = Str::random();
    }

    public function render()
    {
        return view('livewire.loading-spinner');
    }
}
