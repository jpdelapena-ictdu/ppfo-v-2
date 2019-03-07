<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Component;
use App\Computer;
use App\Building;
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
        $buildings = Building::all();
        $partsArr = [];
        $x = 0;

        foreach ($components as $row) {
            $pc_num = Computer::find($row->pc_id);
            $room = Room::find($row->room_id);
            if($row->pc_id == '' || !isset($pc_num)){

                $partsArr[$x++] = [
                'id' => $row->id,
                'room' => $room->name,
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
            ->with('parts', $partsArr)
            ->with('rooms', $rooms)
            ->with('computers', $computers)
            ->with('buildings', $buildings);

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
        $room = Room::find($computer->room_id);
    	$parts = New Component;
        $parts->room_id = $room->id;
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
        $buildings = Building::all();
        $rooms = Room::all();
        $computers = Computer::all();
        $room = Room::find($component->room_id);
        $b = Room::where('building_id', $room->building_id)->get();

        return view('admin.computers.parts.edit')
            ->with('component', $component)
            ->with('buildings', $buildings)
            ->with('rooms', $rooms)
            ->with('room', $room)
            ->with('b', $b)
            ->with('computers', $computers);
    }

     public function update(Request $request, $id) {
        abort_if(Auth::user()->user_type == 2, 404);

        $this->validate($request, [
            'type' => 'required|not_in:none',
            'brand' => 'required',
            'category' => 'required|not_in:none',
            'description' => 'required',
            'date_purchased' => 'required'
        ]);

        $component = component::find($id);
        $component->room_id = $request->room;
        $component->pc_id = $request->computer;
        $component->category = $component->category;
        $component->type = $component->type;
        $component->brand = $request->brand;
        $component->description = $request->description;
        $component->amount = $request->amount;
        $component->date_purchased = $request->date_purchased;
        $component->serial = $request->serial;
        $component->date_issued = $request->date_issued;
        $component->remarks = $request->remarks;
        $component->save();

        // show a success message
        \Alert::success('The component has been modified successfully.!')->flash();

        return redirect()->route('component.index');
    }

     public function destroy($id) {
        abort_if(Auth::user()->user_type == 2, 404);
        
        $component = Component::find($id);
        $component->delete();

        // show a success message
        \Alert::success('Component has been deleted.')->flash();

        return redirect()->route('component.index');
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
        $room = Room::find($computer->room_id);
        $parts = New Component;
        $parts->room_id = $room->id;
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
        $buildings = Building::all();
        $rooms = Room::all();
        $computers = Computer::all();
        return view('admin.computers.parts.excesscreate')
        ->with('buildings', $buildings)
        ->with('rooms', $rooms)
        ->with('computers', $computers);
    }

    public function excessstore(Request $request) {
        abort_if(Auth::user()->user_type == 2, 404);

        $this->validate($request, [
            'room' => 'required|not_in:none',
            'type' => 'required|not_in:none',
            'brand' => 'required',
            'category' => 'required|not_in:none',
            'description' => 'required',
            'date_purchased' => 'required'
        ]);

        $parts = New Component;
        $parts->room_id = $request->room;
        $parts->pc_id = $request->computer;
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
            'room' => 'required|not_in:none',
            'type' => 'required|not_in:none',
            'brand' => 'required',
            'category' => 'required|not_in:none',
            'description' => 'required',
            'date_purchased' => 'required'
        ]);

        $parts = New Component;
        $parts->room_id = $request->room;
        $parts->pc_id = $request->computer;
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

    public function add(Request $request, $id) {
        abort_if(Auth::user()->user_type == 2, 404);

        $this->validate($request, [
            'computer' => 'required'
        ]);

        $component = Component::find($id);
        $component->pc_id = $request->computer;
        $component->save();

        // show a success message
        \Alert::success('The component has been modified successfully.!')->flash();

        return redirect()->route('component.index');
    }

    public function test(){
        $component = Component::all();
        $computer = Computer::all();

        foreach($component as $part){
            foreach($computer as $pc){
                $computer1 = Computer::find($part->pc_id);
                    if(!isset($computer1->id)){
                        $part->room_id = 1;
                        $part->save();
                    }
            }
            
        }
    }
}
