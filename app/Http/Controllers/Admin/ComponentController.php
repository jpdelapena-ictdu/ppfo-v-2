<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Component;
use App\Computer;
use App\Room;
use Auth;
use Alert;

class ComponentController extends Controller
{
    public function index() {
        abort_if(Auth::user()->user_type == 2, 404);

        $computers = Computer::orderBy('updated_at', 'desc')->get();
        $components = Component::orderBy('updated_at', 'desc')->get();
        $rooms = Room::orderBy('updated_at', 'desc')->get();
        $partsArr = [];
        $x = 0;

        foreach ($components as $row) {
            if($row->pc_id == ''){

                $partsArr[$x++] = [
                'id' => $row->id,
                'room' => '',
                'pc_number' => '',
                'category' => $row->category,
                'type' => $row->type,
                'description' => $row->description,
                'brand' => $row->brand,
                'serial' => $row->serial,
                'date_purchased' => $row->date_purchased,
                'amount' => $row->amount,
                'date_issued' => $row->date_issued,
                'remarks' => $row->remarks
                ];
            }else{
            $pc = Computer::find($row->pc_id);
            $room = Room::find($pc->room_id);
            
            $partsArr[$x++] = [
                'id' => $row->id,
                'room' => $room->name,
                'pc_number' => $pc->pc_number,
                'category' => $row->category,
                'type' => $row->type,
                'description' => $row->description,
                'brand' => $row->brand,
                'serial' => $row->serial,
                'date_purchased' => $row->date_purchased,
                'amount' => $row->amount,
                'date_issued' => $row->date_issued,
                'remarks' => $row->remarks
            ];
        }
    }   

        $partsArr = json_decode(json_encode($partsArr));

        return view('admin.computers.parts.index')
            ->with('parts', $partsArr);

    }

    public function create($id) {
	abort_if(Auth::user()->user_type == 2, 404);

		$computer = Computer::find($id);

    	return view('admin.computers.parts.create')
    		->with('computer', $computer);
    }

    public function store(Request $request, $id) {
    	abort_if(Auth::user()->user_type == 2, 404);

    	$this->validate($request, [
    		'type' => 'required|not_in:none',
    		'brand' => 'required',
            'category' => 'required|not_in:none',
    		'description' => 'required',
    		'date_purchased' => 'required'
    	]);
    	$computer = Computer::find($id);
    	$parts = New Component;
    	$parts->pc_id = $computer->id;
        $parts->category = $request->category;
    	$parts->type = $request->type;
    	$parts->brand = $request->brand;
    	$parts->description = $request->description;
        $parts->amount = $request->amount;
    	$parts->date_purchased = $request->date_purchased;
        $parts->serial = $request->serial;
        $parts->date_issued = $request->date_issued;
        $parts->remarks = $request->remarks;
    	$parts->save();

    	// show a success message
        Alert::success('The Component has been added successfully.')->flash();

    	return redirect()->route('computer.index');

    }

     public function edit($id) {
        abort_if(Auth::user()->user_type == 2, 404);

        $component = Component::find($id);

        return view('admin.computers.parts.edit')
            ->with('component', $component);
    }

     public function update(Request $request, $id) {
        abort_if(Auth::user()->user_type == 2, 404);

        $this->validate($request, [
            'room' => 'required',
            'pc_number' => 'required',
            'status' => 'required|max:191'

        ]);

        $computer = Computer::find($id);
        $computer->room_id = $request->room;
        $computer->pc_number = $request->pc_number;
        $computer->status = $request->status;
        $computer->save();

        // show a success message
        \Alert::success('The computer has been modified successfully.!')->flash();

        return redirect()->route('computer.index');
    }



    public function storenew(Request $request, $id) {
        abort_if(Auth::user()->user_type == 2, 404);

        $this->validate($request, [
            'type' => 'required|not_in:none',
            'brand' => 'required',
            'category' => 'required|not_in:none',
            'description' => 'required',
            'date_purchased' => 'required'
        ]);
        $computer = Computer::find($id);
        $parts = New Component;
        $parts->pc_id = $computer->id;
        $parts->category = $request->category;
        $parts->type = $request->type;
        $parts->brand = $request->brand;
        $parts->description = $request->description;
        $parts->amount = $request->amount;
        $parts->date_purchased = $request->date_purchased;
        $parts->serial = $request->serial;
        $parts->date_issued = $request->date_issued;
        $parts->remarks = $request->remarks;
        $parts->save();

        // show a success message
        Alert::success('The Component has been added successfully.')->flash();

        return redirect()->route('component.create', $computer->id);

    }

    public function excesscreate() {
    abort_if(Auth::user()->user_type == 2, 404);

        return view('admin.computers.parts.excesscreate');
    }

    public function excessstore(Request $request) {
        abort_if(Auth::user()->user_type == 2, 404);

        $this->validate($request, [
            'type' => 'required|not_in:none',
            'brand' => 'required',
            'category' => 'required|not_in:none',
            'description' => 'required',
            'date_purchased' => 'required'
        ]);

        $parts = New Component;
        $parts->category = $request->category;
        $parts->type = $request->type;
        $parts->brand = $request->brand;
        $parts->description = $request->description;
        $parts->amount = $request->amount;
        $parts->date_purchased = $request->date_purchased;
        $parts->serial = $request->serial;
        $parts->date_issued = $request->date_issued;
        $parts->remarks = $request->remarks;
        $parts->save();

        // show a success message
        Alert::success('The Component has been added successfully.')->flash();

        return redirect()->route('component.index');

    }

    public function excessstorenew(Request $request) {
        abort_if(Auth::user()->user_type == 2, 404);

        $this->validate($request, [
            'type' => 'required|not_in:none',
            'brand' => 'required',
            'category' => 'required|not_in:none',
            'description' => 'required',
            'date_purchased' => 'required'
        ]);

        $parts = New Component;
        $parts->category = $request->category;
        $parts->type = $request->type;
        $parts->brand = $request->brand;
        $parts->description = $request->description;
        $parts->amount = $request->amount;
        $parts->date_purchased = $request->date_purchased;
        $parts->serial = $request->serial;
        $parts->date_issued = $request->date_issued;
        $parts->remarks = $request->remarks;
        $parts->save();

        // show a success message
        Alert::success('The Component has been added successfully.')->flash();

        return redirect()->route('excess.component.create');
    }
}
