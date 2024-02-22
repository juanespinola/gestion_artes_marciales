<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;
use Illuminate\Support\Facades\App;

class Table extends Component
{
    public $headers = [];
    public $columns = [];
    public $entity;
    public $elements = [];
    public $order = false;
    public $statusColumns = false;
    /**
     * Create a new component instance.
     */

    public function __construct($headers, $columns = null, $entity, $order){
        $this->headers = $headers;
        $this->columns = $columns;
        $this->entity = $entity;
        $this->order = $order;
        
        $this->getAll();
    }

    private function paginate($data) {
        // Puedes ajustar la cantidad de elementos por página según tus necesidades
        $perPage = 5;

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $options = [
            'path' => ''
        ];
        
        
        return new LengthAwarePaginator(
            $currentItems, 
            $data->count(), 
            $perPage, 
            $currentPage, 
            $options);
    }

    public function getAll($filters = null){
        
        $model = App::make('App\\Models\\' . ucfirst($this->entity));
        $this->elements = $this->paginate($model::all());    
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }

    public function customFunction()  {

        return "estamos aca";
    }

      /**
     * @description Allows you to add the sort by column functionality on the view
    */
    private function orderBy() {
        
    }
}
