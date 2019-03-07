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

class ComponentPersonnelController extends Controller
{

	public function index() {
		$buildings = Building::find(Auth::user()->building_id);
		$components = Component::all();
		$rooms = Room::where('building_id', $buildings->id)->get();
		$computers = Computer::all();
		$partsArr = [];
		$x = 0;

		foreach($rooms as $room){
		foreach ($components as $row) {
			if($row->room_id == $room->id){
            $pc_num = Computer::find($row->pc_id);
            $room = Room::find($row->room_id);
            if($row->pc_id == '' || !isset($pc_num)){

                $partsArr[$x++] = [
                'id' => $row->id,
                'room' => $room->name,
                'room_id' => $room->id,
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
                        'room_id' => $room->id,
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
    }
}

		$partsArr = json_decode(json_encode($partsArr));

		

		return view('personnel.computers.parts.index')
		->with('parts', $partsArr)
		->with('rooms', $rooms)
		->with('buildings', $buildings)
		->with('computers', $computers);

		/*$buildings = Building::find(Auth::user()->building_id)->get();
		$computers = Computer::orderBy('updated_at', 'desc')->get();
		$components = Component::orderBy('updated_at', 'desc')->get();
		$rooms = Room::where('building_id', Auth::user()->building_id)->get();

		
		$partsArr = [];
		$x = 0;

		foreach($rooms as $room){
			foreach($computers as $pc){
				if($room->id == $pc->room_id){
					foreach($components as $row) {

						$pc_num = Computer::find($row->pc_id);
						if($row->pc_id == '' || !isset($pc_num)){

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
				}
			}
		}   

		$partsArr = json_decode(json_encode($partsArr));

		

		return view('personnel.computers.parts.index')
		->with('parts', $partsArr)
		->with('rooms', $rooms)
		->with('computers', $computers)
		->with('buildings', $buildings);*/

	}

	public function create($id) {

		$computer = Computer::find($id);

		return view('personnel.computers.parts.create')
		->with('computer', $computer);
	}

	public function store(Request $request, $id) {
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

		return redirect()->route('personnel.computer.index');

	}

	public function storenew(Request $request, $id) {
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

		return redirect()->route('personnel.component.create', $computer->id);

	}

	public function edit($id) {
        $component = Component::find($id);
        $rooms = Room::where('building_id', Auth::user()->building_id)->get();
        $computers = Computer::all();

        return view('personnel.computers.parts.edit')
            ->with('component', $component)
            ->with('rooms', $rooms)
            ->with('computers', $computers);
    }

    public function update(Request $request, $id) {

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

        return redirect()->route('personnel.component.index');
    }

    public function destroy($id) {

        $component = Component::find($id);
        $component->delete();

        // show a success message
        \Alert::success('Component has been deleted.')->flash();

        return redirect()->route('personnel.component.index');
    }



	public function excesscreate() {

        $buildings = Building::find(Auth::user()->building_id);
        $rooms = Room::where('building_id', Auth::user()->building_id)->get();
        $computers = Computer::all();
        return view('personnel.computers.parts.excesscreate')
        ->with('buildings', $buildings)
        ->with('rooms', $rooms)
        ->with('computers', $computers);
    }

    public function excessstore(Request $request) {
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

        return redirect()->route('personnel.component.index');

    }

    public function excessstorenew(Request $request) {

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

        return redirect()->route('excess.personnel.component.create');
    }

     public function add(Request $request, $id) {
        $this->validate($request, [
        	'room' => 'required',
            'computer' => 'required'
        ]);

        $component = Component::find($id);
        $component->room_id = $request->room;
        $component->pc_id = $request->computer;
        $component->save();

        // show a success message
        \Alert::success('The component has been modified successfully.!')->flash();

        return redirect()->route('personnel.component.index');
    }
}
