<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComputerController extends Controller
{

    public function create() {

    	$rooms = Room::orderBy('updated_at', 'desc')->get();

    	return view('admin.items.fixture.create')
    		->with('rooms', $rooms);
    }

    public function index() {
    	
    }
 
}
