<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class HostStatus extends Component
{
    public string|null $status = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.host-status', ['status' => $this->status]);
    }
}
