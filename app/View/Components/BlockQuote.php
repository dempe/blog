<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BlockQuote extends Component
{
    public string $text;
    public string $caption;

    public function __construct(string $text, string $caption)
    {
        $this->text = $text;
        $this->caption = $caption;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.blockquote');
    }
}
