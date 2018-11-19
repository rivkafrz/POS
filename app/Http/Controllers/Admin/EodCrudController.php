<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\EodRequest as StoreRequest;
use App\Http\Requests\EodRequest as UpdateRequest;

class EodCrudController extends CrudController
{
    public function setup()
    {

        $this->crud->setModel('App\EOD');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/eod');
        $this->crud->setEntityNameStrings('eod', 'End of Day');
        $this->crud->denyAccess(['create', 'update', 'delete']);
        $this->crud->addColumn([
            'label' => "Ticketing",
            'type' => "employee",
            'name' => 'user_id'
         ]);
         $this->crud->addColumn([
            'label' => "Open Transaction",
            'type' => "open_transaction",
            'name' => 'open_transaction'
         ]);
         $this->crud->addColumn([
            'label' => "End of Day",
            'type' => "text",
            'name' => 'created_at'
         ]);
         $this->crud->addColumn([
            'label' => "Status",
            'type' => 'eod_status'
         ]);
         $this->crud->addColumn([
            'label' => "",
            'name' => 'pdf',
            'type' => 'eod_pdf'
         ]);
         $this->crud->addButtonFromView('line', 'approve', 'eod_approve', 'end');
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
