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
        abort_if(Auth::user()->user_type == 1, 404);

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
                'remarks' => $row->remarks,
                'status' => $row->status
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
                        'remarks' => $row->remarks,
                        'status' => $row->status
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
        abort_if(Auth::user()->user_type == 1, 404);

		$computer = Computer::find($id);

		return view('personnel.computers.parts.create')
		->with('computer', $computer);
	}

	public function store(Request $request, $id) {
        abort_if(Auth::user()->user_type == 1, 404);

		$computer = Computer::find($id);
		$room = Room::find($computer->room_id);

		if($request->monitoramount != ''){
        //Monitor
        $parts = New Component;
        $parts->room_id = $room->id;
        $parts->pc_id = $computer->id;
        $parts->category = $request->monitorcategory;
        $parts->type = $request->monitortype;
        $parts->brand = $request->monitorbrand;
        $parts->description = $request->monitordescription;
        $parts->amount = $request->monitoramount;
        $parts->date_purchased = $request->monitordate_purchased;
        $parts->serial = $request->monitorserial;
        $parts->date_issued = $request->monitordate_issued;
        $parts->remarks = $request->monitorremarks;
        $parts->status = 1;
        $parts->save();
        }

        if($request->keyboardamount != ''){
        //Keyboard
        $parts = New Component;
        $parts->room_id = $room->id;
        $parts->pc_id = $computer->id;
        $parts->category = $request->keyboardcategory;
        $parts->type = $request->keyboardtype;
        $parts->brand = $request->keyboardbrand;
        $parts->description = $request->keyboarddescription;
        $parts->amount = $request->keyboardamount;
        $parts->date_purchased = $request->keyboarddate_purchased;
        $parts->serial = $request->keyboardserial;
        $parts->date_issued = $request->keyboarddate_issued;
        $parts->remarks = $request->keyboardremarks;
        $parts->status = 1;
        $parts->save();
        }

        if($request->mouseamount != ''){
        //Mouse
        $parts = New Component;
        $parts->room_id = $room->id;
        $parts->pc_id = $computer->id;
        $parts->category = $request->mousecategory;
        $parts->type = $request->mousetype;
        $parts->brand = $request->mousebrand;
        $parts->description = $request->mousedescription;
        $parts->amount = $request->mouseamount;
        $parts->date_purchased = $request->mousedate_purchased;
        $parts->serial = $request->mouseserial;
        $parts->date_issued = $request->mousedate_issued;
        $parts->remarks = $request->mouseremarks;
        $parts->status = 1;
        $parts->save();
        }

        if($request->avramount != ''){
        //AVR
        $parts = New Component;
        $parts->room_id = $room->id;
        $parts->pc_id = $computer->id;
        $parts->category = $request->avrcategory;
        $parts->type = $request->avrtype;
        $parts->brand = $request->avrbrand;
        $parts->description = $request->avrdescription;
        $parts->amount = $request->avramount;
        $parts->date_purchased = $request->avrdate_purchased;
        $parts->serial = $request->avrserial;
        $parts->date_issued = $request->avrdate_issued;
        $parts->remarks = $request->avrremarks;
        $parts->status = 1;
        $parts->save();
        }

        if($request->headsetamount != ''){
        //Headset
        $parts = New Component;
        $parts->room_id = $room->id;
        $parts->pc_id = $computer->id;
        $parts->category = $request->headsetcategory;
        $parts->type = $request->headsettype;
        $parts->brand = $request->headsetbrand;
        $parts->description = $request->headsetdescription;
        $parts->amount = $request->headsetamount;
        $parts->date_purchased = $request->headsetdate_purchased;
        $parts->serial = $request->headsetserial;
        $parts->date_issued = $request->headsetdate_issued;
        $parts->remarks = $request->headsetremarks;
        $parts->status = 1;
        $parts->save();
        }

        if($request->cpuamount != ''){
        //Processor
        $parts = New Component;
        $parts->room_id = $room->id;
        $parts->pc_id = $computer->id;
        $parts->category = $request->cpucategory;
        $parts->type = $request->cputype;
        $parts->brand = $request->cpubrand;
        $parts->description = $request->cpudescription;
        $parts->amount = $request->cpuamount;
        $parts->date_purchased = $request->cpudate_purchased;
        $parts->serial = $request->cpuserial;
        $parts->date_issued = $request->cpudate_issued;
        $parts->remarks = $request->cpuremarks;
        $parts->status = 1;
        $parts->save();
        }

        if($request->moboamount != ''){
        //Motherboard
        $parts = New Component;
        $parts->room_id = $room->id;
        $parts->pc_id = $computer->id;
        $parts->category = $request->mobocategory;
        $parts->type = $request->mobotype;
        $parts->brand = $request->mobobrand;
        $parts->description = $request->mobodescription;
        $parts->amount = $request->moboamount;
        $parts->date_purchased = $request->mobodate_purchased;
        $parts->serial = $request->moboserial;
        $parts->date_issued = $request->mobodate_issued;
        $parts->remarks = $request->moboremarks;
        $parts->status = 1;
        $parts->save();
        }

        if($request->gpuamount != ''){
        //GPU
        $parts = New Component;
        $parts->room_id = $room->id;
        $parts->pc_id = $computer->id;
        $parts->category = $request->gpucategory;
        $parts->type = $request->gputype;
        $parts->brand = $request->gpubrand;
        $parts->description = $request->gpudescription;
        $parts->amount = $request->gpuamount;
        $parts->date_purchased = $request->gpudate_purchased;
        $parts->serial = $request->gpuserial;
        $parts->date_issued = $request->gpudate_issued;
        $parts->remarks = $request->gpuremarks;
        $parts->status = 1;
        $parts->save();
        }

        if($request->ramamount != ''){
        //RAM
        $parts = New Component;
        $parts->room_id = $room->id;
        $parts->pc_id = $computer->id;
        $parts->category = $request->ramcategory;
        $parts->type = $request->ramtype;
        $parts->brand = $request->rambrand;
        $parts->description = $request->ramdescription;
        $parts->amount = $request->ramamount;
        $parts->date_purchased = $request->ramdate_purchased;
        $parts->serial = $request->ramserial;
        $parts->date_issued = $request->ramdate_issued;
        $parts->remarks = $request->ramremarks;
        $parts->status = 1;
        $parts->save();
        }

        if($request->hddamount != ''){
        //HDD
        $parts = New Component;
        $parts->room_id = $room->id;
        $parts->pc_id = $computer->id;
        $parts->category = $request->hddcategory;
        $parts->type = $request->hddtype;
        $parts->brand = $request->hddbrand;
        $parts->description = $request->hdddescription;
        $parts->amount = $request->hddamount;
        $parts->date_purchased = $request->hdddate_purchased;
        $parts->serial = $request->hddserial;
        $parts->date_issued = $request->hdddate_issued;
        $parts->remarks = $request->hddremarks;
        $parts->status = 1;
        $parts->save();
        }


    	// show a success message
		Alert::success('The Component has been added successfully.')->flash();

		return redirect()->route('personnel.computer.index');

	}

	public function storenew(Request $request, $id) {
        abort_if(Auth::user()->user_type == 1, 404);
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
        abort_if(Auth::user()->user_type == 1, 404);

        $component = Component::find($id);
        $rooms = Room::where('building_id', Auth::user()->building_id)->get();
        $computers = Computer::all();

        return view('personnel.computers.parts.edit')
            ->with('component', $component)
            ->with('rooms', $rooms)
            ->with('computers', $computers);
    }

    public function update(Request $request, $id) {
        abort_if(Auth::user()->user_type == 1, 404);

        $this->validate($request, [
    		'brand' => 'required',
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
        abort_if(Auth::user()->user_type == 1, 404);

        $component = Component::find($id);
        $component->delete();

        // show a success message
        \Alert::success('Component has been deleted.')->flash();

        return redirect()->route('personnel.component.index');
    }



	public function excesscreate() {
        abort_if(Auth::user()->user_type == 1, 404);

        $buildings = Building::find(Auth::user()->building_id);
        $rooms = Room::where('building_id', Auth::user()->building_id)->get();
        $computers = Computer::all();
        return view('personnel.computers.parts.excesscreate')
        ->with('buildings', $buildings)
        ->with('rooms', $rooms)
        ->with('computers', $computers);
    }

    public function excessstore(Request $request) {
        abort_if(Auth::user()->user_type == 1, 404);

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
        abort_if(Auth::user()->user_type == 1, 404);

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
        abort_if(Auth::user()->user_type == 1, 404);
        
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

    public function changestatus($id){
        $component = Component::find($id);

        if($component->status == 1){
            $component->status = 0;
            $component->save();

            return redirect()->back();
        }else{
            $component->status = 1;
            $component->save();

            return redirect()->back();
        }
    }

//    public function status(){
//        $parts = Component::all();
//        foreach($parts as $row){
//            $component = Component::find($row->id);
//            $component->status = 1;
//            $component->save();
//        }
//    }
}
