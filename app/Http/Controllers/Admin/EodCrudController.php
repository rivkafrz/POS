<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

use App\Http\Requests\EodRequest as StoreRequest;
use App\Http\Requests\EodRequest as UpdateRequest;
use Carbon\Carbon;
use App\AssignLocation;
use App\WorkTime;
use Auth;

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
        if (Auth::user()->hasRole('admin')) {
            $this->crud->addButtonFromView('line', 'approve', 'eod_approve', 'end');
            $this->crud->addFilter([
                'type' => 'date',
                'name' => 'created_at',
                'label'=> 'Date'
            ],
            false,
            function($value) {
                $this->crud->addClause('where', 'created_at', 'like', $value .'%');
            });
    
            $assign_locations = [];
            foreach (AssignLocation::all() as $assign_location) {
                $assign_locations = array_merge($assign_locations, [$assign_location->code_location => $assign_location->assign_location]);
            }
            $this->crud->addFilter([
                'type' => 'dropdown',
                'name' => 'assign_location',
                'label'=> 'Assign Location'
            ],
            $assign_locations,
            function($value) {
                $value = AssignLocation::where('code_location', $value)->first();
                $this->crud->addClause('where', 'assign_location_id', $value->id);
            });
    
            $work_times = [];
            foreach (WorkTime::all() as $work_time) {
                $work_times = array_merge($work_times, ["'" . $work_time->id . "'" => $work_time->work_time . " - " . $work_time->assignLocation->assign_location]);
            }
            $this->crud->addFilter([
                'type' => 'dropdown',
                'name' => 'work_time',
                'label'=> 'Work Time'
            ],
            $work_times,
            function($value) {
                $value = WorkTime::find(str_replace("'", "", $value));
                $this->crud->addClause('where', 'work_time_id', $value->id);
            });
        } else {
            $this->crud->addClause('where', 'user_id', Auth::user()->id);
        }
        $this->crud->enableExportButtons();
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
