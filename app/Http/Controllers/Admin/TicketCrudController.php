<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\TicketRequest as StoreRequest;
use App\Http\Requests\TicketRequest as UpdateRequest;

class TicketCrudController extends CrudController
{
    public function setup()
    {

        $this->crud->setModel('App\Ticket');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/ticket');
        $this->crud->setEntityNameStrings('ticket', 'tickets');
        $this->crud->denyAccess(['create', 'update', 'delete']);
        $this->crud->setFromDb();
        $this->crud->addColumn([
            'label' => "Name",
            'type' => 'select',
            'name' => 'customer_id',
            'entity' => 'customer',
            'attribute' => 'name',
            'model' => "App\Customer"
        ]);
        $this->crud->addColumn([
            'label' => "Phone",
            'type' => 'select',
            'name' => 'phone',
            'entity' => 'customer',
            'attribute' => 'phone',
            'model' => "App\Customer"
        ]);
        $this->crud->addColumn([
            'label' => "Departure Time",
            'type' => 'select',
            'name' => 'boarding_time',
            'entity' => 'departureTime',
            'attribute' => 'boarding_time',
            'model' => "App\Models\Departure_time",
        ]);
        $this->crud->addColumn([
            'label' => "Destination",
            'type' => 'select',
            'name' => 'to',
            'entity' => 'destination',
            'attribute' => 'to',
            'model' => "App\Models\Destination"
        ]);
        $this->crud->addColumn([
            'label' => "Status",
            'type' => 'ticket_status'
        ]);
        $this->crud->removeColumns(['user_id', 'destination_id', 'departure_time_id']);
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
        $redirect_location = parent::storeCrud($request);
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $redirect_location = parent::updateCrud($request);
        return $redirect_location;
    }
}
