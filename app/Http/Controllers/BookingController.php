<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingEvent;
use App\Models\OpeningHour;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking.index');
    }

    public function getEvents()
    {
        $start_timestamp = $_REQUEST['start'];
        $end_timestamp = $_REQUEST['end'];
        $bookedEvents = BookingEvent::addSelect("name AS title", 'start_time AS start', 'end_time AS end')
                                            ->whereBetween('start_time', [$start_timestamp, $end_timestamp])
                                            ->whereBetween('end_time', [$start_timestamp, $end_timestamp])
                                            ->get();
        return response()->json($bookedEvents);
        
    }

    public function createEvent()
    {
        $name = $_REQUEST['title'];
        if(trim($name) == ''){
            return response()->json(['success' => false, 'msg' => 'Egy ügyfélnevet adj meg kérlek.' ]);
        }
        
        $start_timestamp = Carbon::parse($_REQUEST['start']);
        
        $end_timestamp = Carbon::parse($_REQUEST['end']);
        $dayofweek= strtolower($start_timestamp->isoFormat('dddd'));

        //todo even/odd/re
        $freeopeningHours = OpeningHour::addSelect('id')
                                            ->where('start_time', '<=',  $start_timestamp)
                                            ->where('day_of_week', $dayofweek)
                                            ->where('start_time_within_day', '<=', $start_timestamp->format('H:i:s'))
                                            ->where('end_time_within_day', '>=', $start_timestamp->format('H:i:s'))
                                            ->where('start_time_within_day', '<=', $end_timestamp->format('H:i:s'))
                                            ->where('end_time_within_day', '>=', $end_timestamp->format('H:i:s'))
                                            ->get();
        if($freeopeningHours->isEmpty()){
            return response()->json(['success' => false, 'msg' => 'Ez az időszak nem tartozik a foglaható idősávok közé.' ]);
        }
        $bookedEvent = BookingEvent::addSelect('id')
                                            ->whereIn('oh_id', $freeopeningHours)
                                            ->where('start_time', '<=', $start_timestamp)
                                            ->where('end_time', '>=', $start_timestamp)
                                            ->where('start_time', '<=', $end_timestamp)
                                            ->where('end_time', '>=', $end_timestamp)
                                            ->get();
        
        if($bookedEvent->isNotEmpty()){
            return response()->json(['success' => false, 'msg' => 'Ez időszak már foglalt.' ]);
        }
        if($freeopeningHours->isNotEmpty() && $bookedEvent->isEmpty()){
            $event = new BookingEvent([
                'oh_id' => $freeopeningHours->first()->id,
                'start_time' => Carbon::create($_REQUEST['start']),
                'end_time' => Carbon::create($_REQUEST['end']),
                'name' => $name
            ]);
            $event->save();
            return response()->json(['success' => true, 'msg' => 'Sikeres mentés.']);
        }else{
            return response()->json(['success' => false, 'msg' => 'Ez időszak már foglalt.' ]);
        }

        
        
    }
}