<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\UserRequest as StoreRequest;
use App\Http\Requests\UserRequest as UpdateRequest;
use App\User;
use App\Role;
use App\Models\Employee;
use Alert;

class UserCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/user');
        $this->crud->setEntityNameStrings('user', 'users');
        $this->crud->setFromDb();

        $this->crud->removeFields(['section', 'work_time_id']);
        $this->crud->removeColumns(['section','location', 'shift', 'employee_id', 'work_time_id']);

        $this->crud->addField(
        [
            'label' => "Employee Name",
            'type' => 'select2',
            'name' => 'employee_id', // field
            'entity' => 'employee', // fungsi model
            'attribute' => 'employee_name',
            'model' => "App\Models\Employee"
        ]);

        $this->crud->addField(
            [
                'label' => "Role",
                'type' => 'radio',
                'name' => 'role_id',
                'options' => [
                    '1' => 'Admin',
                    '2' => 'Leader',
                    '3' => 'Ticketing'
                ],
                'inline' => true,
                'default' => 3
            ]);
    }

    public function store(StoreRequest $request)
    {
        if (!is_null(Employee::find($request->employee_id)->user)) {
            Alert::error('An account already attached to selected Employee')->flash();
            return redirect()->back();
        }
        $redirect_location = parent::storeCrud($request);
        $user = User::where('email', $request->email)->first();
        $user->roles()->attach(Role::find($request->role_id));
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        return $redirect_location;
    }
}
