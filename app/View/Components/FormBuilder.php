<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormBuilder extends Component
{
    /**
     * Create a new component instance.
     */

    public $model;
    public $fields;
    public $action;
    public $method;
    public $formId;
    public $withModal;

    public function __construct($model, $fields, $action = '#', $method = 'POST', $formId = null, $withModal = false)
    {
        $this->model = $model;
        $this->fields = $fields;
        $this->action = $action;
        $this->method = strtoupper($method);
        $this->formId = $formId;
        $this->withModal = $withModal;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-builder', [
            'model' => $this->model,
            'fields' => $this->fields,
            'action' => $this->action,
            'method' => $this->method,
            'formId' => $this->formId,
            'withModal' => $this->withModal
        ]);
    }
}
