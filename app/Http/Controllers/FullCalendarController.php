<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Redirect,Response;

class FullCalendarController extends Controller
{
    public function index()
	{
		if(request()->ajax())
		{
			$start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
			$end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
			$data = Booking::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
			return Response::json($data);
		}
		return view('fullcalendar');
	}
	public function create(Request $request)
	{
		$insertArr = [ 'title' => $request->title,
		'start' => $request->start,
		'end' => $request->end
		];
		$booking = Booking::insert($insertArr);
		return Response::json($booking);
	}
	public function update(Request $request)
	{
		$where = array('id' => $request->id);
		$updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
		$booking  = Booking::where($where)->update($updateArr);
		return Response::json($booking);
	}
	public function destroy(Request $request)
	{
		$booking = Booking::where('id',$request->id)->delete();
		return Response::json($booking);
	}
}

?>