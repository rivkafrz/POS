<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserRequest as StoreRequest;
use App\Http\Requests\UserRequest as UpdateRequest;

class UserCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/user');
        $this->crud->setEntityNameStrings('user', 'users');
        $this->crud->setFromDb();

        $this->crud->removeFields(['section', 'work_time_id']);
        $this->crud->removeColumns(['section','location', 'shift']);

        $this->crud->addField(
        [
            'label' => "Employee Name",
            'type' => 'select2',
            'name' => 'employee_id', // field
            'entity' => 'employee', // fungsi model
            'attribute' => 'employee_name',
            'model' => "App\Models\Employee"
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
