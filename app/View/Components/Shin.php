<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Shin extends Component
{
    public string $shin;

    public function __construct(string $shin)
    {
        $this->shin = $shin;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shin');
    }
}
