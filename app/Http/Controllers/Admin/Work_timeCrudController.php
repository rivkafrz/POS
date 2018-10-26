<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Work_timeRequest as StoreRequest;
use App\Http\Requests\Work_timeRequest as UpdateRequest;

class Work_timeCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\Work_time');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/work_time');
        $this->crud->setEntityNameStrings('work_time', 'work_times');
        $this->crud->setFromDb();

        $this->crud->addField(
        [
            'label' => "Assign Location",
            'type' => 'select2',
            'name' => 'assign_location_id', // field
            'entity' => 'assignLocation', // fungsi model
            'attribute' => 'assign_location',
            'model' => "App\Models\Assign_location"
        ]);

        $this->crud->addColumn(
        [
            'label' => "Assign Location",
            'type' => 'select',
            'name' => 'assign_location_id', // field
            'entity' => 'assignLocation', // fungsi model
            'attribute' => 'assign_location',
            'model' => "App\Models\Assign_location"
        ]);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
