<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManifestRequest as StoreRequest;
use App\Http\Requests\ManifestRequest as UpdateRequest;

class ManifestCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Manifest');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/history-manifest');
        $this->crud->setEntityNameStrings('history-manifest', 'history manifest');
        $this->crud->denyAccess(['create', 'update', 'delete']);
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();
        $this->crud->removeAllBUttons();
        $this->crud->addColumn([
            'label' => "Destination",
            'type' => 'select',
            'name' => 'destination_id',
            'entity' => 'destination',
            'attribute' => 'to',
            'model' => "App\Destination"
        ]);
        $this->crud->addColumn([
            'label' => "Departure Time",
            'type' => 'select',
            'name' => 'departure_time_id',
            'entity' => 'departureTime',
            'attribute' => 'boarding_time',
            'model' => "App\DepartureTime",
        ]);
        $this->crud->addColumn([
            'label' => "Assign Location",
            'type' => 'select',
            'name' => 'assign_location_id',
            'entity' => 'assignLocation',
            'attribute' => 'assign_location',
            'model' => "App\AssignLocation",
        ]);
         

        $this->crud->addColumn([
            'label' => 'Passengers Canceled',
            'type' => 'canceled'
        ]);
         $this->crud->addColumn([
            'label' => 'Total Passengers',
            'type' => 'passenger'
        ]);

        $this->crud->removeColumn('user_id'); 

        $this->crud->removeColumn('work_time_id'); 
 
 
         $this->crud->addFilter([
            'type' => 'date',
            'name' => 'date',
            'label'=> 'Date'
        ],
        false,
        function($value) {
            $this->crud->addClause('where', 'created_at', 'like', $value . "%");
        });
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
