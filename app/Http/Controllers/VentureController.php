<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Response;

class VentureController extends Controller
{
    // Retrive events
    public function display(Request $request, $type=null){
        $pageSize = $request->page_size??5;
        $event = Event::paginate($pageSize);
        $response = $type?Event::where('type', $type)->get():$event; 
        return response()->json($response, 200);
    }

    //Create the event
    public function create(Request $request){
        // Validation 
        if($request->type =='warning' ||$request->type =='info'|| $request->type =='error' ){
            $type = $request->type;
        } else{
            $errorMessage = array(
                'status' => 'error',
                'message' => 'The type is not supported'
            );
            return Response::json($errorMessage, 400);
        }

        $event = new Event();
        $event->type = $request->type;
        $event->details = $request->details;
        $event->save();
        return Response::json('Successfull', 201);
    }
}
