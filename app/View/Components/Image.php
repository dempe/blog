<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Image extends Component
{
    // Using Constructor Promotion (PHP 8.0 and Above)
    public function __construct(
        public string $src,
        public string $alt,
        public string $width,
        public string $title,
        public string $caption
    ) {}


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.img');
    }
}
