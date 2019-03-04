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
		$rooms = Room::where('building_id', $buildings->id)->get();
		$partsArr = [];
		$x = 0;

		foreach($rooms as $room) {
			$computers = COmputer::where('room_id', $room->id)->get();
			foreach ($computers as $computer) {
				$components = Component::where('pc_id', $computer->id)->get();
				foreach ($components as $component) {
					$partsArr[$x++] = [
						'id' => $component->id,
						'room' => $room->name,
						'pc_number' => $computer->pc_number,
						'category' => $component->category,
						'type' => $component->type,
						'description' => $component->description,
						'brand' => $component->brand,
						'serial' => $component->serial,
						'date_purchased' => $component->date_purchased,
						'amount' => $component->amount,
						'date_issued' => $component->date_issued,
						'remarks' => $component->remarks
					];
				}
			}
		}

		$partsArr = json_decode(json_encode($partsArr));

		

		return view('personnel.computers.parts.index')
		->with('parts', $partsArr)
		->with('rooms', $rooms)
		->with('computers', $computers)
		->with('buildings', $buildings);

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

		return redirect()->route('personnel.component.create', $computer->id);

	}
}
