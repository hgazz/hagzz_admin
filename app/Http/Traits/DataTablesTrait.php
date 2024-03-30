<?php

namespace App\Http\Traits;

trait DataTablesTrait
{
    private function makeHideButtons($array)
    {
        $data = [];
        foreach($array as $index => $element)
        {
            $data []= [
                'text' =>$element,
                'className' => 'dt-button btn btn-primary btn-sm toggle-vis mb-3',
                'action' => "function(e, dt, node, config) {
                    var column = dt.column($index);
                    column.visible(!column.visible());
                }"
            ];
        }
        return $data;
    }
}
