<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

@if(Auth::user()->user_type == 2)
	<li><a href="{{ route('room.personnel.index') }}"><i class="fa fa-building"></i> <span>Room</span></a></li>
	<li class="treeview">
	    <a href="#"><i class="fa fa-newspaper-o"></i> <span>Items</span> <i class="fa fa-angle-left pull-right"></i></a>
	    <ul class="treeview-menu">
	      <li><a href="{{ route('item.personnel.index') }}"><i class="fa fa-bars"></i> Fixtures, Furnitures and <br/>Equipments</a></li>
	    </ul>
	</li>
@else
	<li><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> <span>Personnel</span></a></li>
	<li><a href="{{ route('building.index') }}"><i class="fa fa-building"></i> <span>Building</span></a></li>
	<li><a href="{{ route('room.index') }}"><i class="fa fa-building"></i> <span>Room</span></a></li>
	<li class="treeview">
	    <a href="#"><i class="fa fa-newspaper-o"></i> <span>Items</span> <i class="fa fa-angle-left pull-right"></i></a>
	    <ul class="treeview-menu">
	      <li><a href="{{ route('item.index') }}"><i class="fa fa-bars"></i> <span>Item</span></a></li>
	      <li><a href="{{ route('fixture.index') }}"><i class="fa fa-bars"></i> <span>Fixtures, Furnitures and <br/>Equipments</span></a></li>
	    </ul>
	</li>
@endif