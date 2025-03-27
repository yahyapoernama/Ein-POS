<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableActions extends Component
{
    /**
     * Create a new component instance.
     */
    public $id, $editRoute, $deleteRoute, $editFields;

    public function __construct($id, $editRoute = null, $deleteRoute = null, $editFields = [])
    {
        $this->id = $id;
        $this->editRoute = $editRoute;
        $this->deleteRoute = $deleteRoute;
        $this->editFields = $editFields;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-actions', [
            'id' => $this->id,
            'editRoute' => $this->editRoute,
            'deleteRoute' => $this->deleteRoute,
            'editFields' => $this->editFields,
        ]);
    }
}
