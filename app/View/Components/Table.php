<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Table extends Component
{
    public $headers = [];
    public $columns = [];
    public $entity;
    /**
     * Create a new component instance.
     */

    public function __construct($headers, $columns = null, $entity){
        $this->headers = $headers;
        $this->columns = $columns;
        // $this->entity = $this->paginate($entity); // paginado si es que viene un array
        $this->entity = $entity;
        
        $this->getAll();
    }

    private function paginate($data) {
        // Puedes ajustar la cantidad de elementos por página según tus necesidades
        $perPage = 3;

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

    private function getAll($filters = null){
        $data = app()->bound('users');
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
