<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ServerStatus extends Component
{
    public string $status;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('components.server-status', [
            'status' => $this->status
        ]);
    }
}
