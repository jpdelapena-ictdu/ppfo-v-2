<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Building;
use App\Room;
use App\User;
use Auth;

class BuildingPersonnelController extends Controller
{
    public function __construct() {
    	$this->middleware('admin');
    }

    public function index() {
    	abort_if(Auth::user()->user_type == 1, 404);

    	$rooms = Room::where('building_id', Auth::user()->building_id)->get();
    	print_r($rooms);
    }
}
