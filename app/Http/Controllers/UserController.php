<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {   
        $displayData= null;
        return view('home',compact('displayData'));
    }

    public function quotation(Request $request)
    {   
        // Validate request parameters
        $validator = Validator::make($request->all(),[
            'ages' => 'required|string',
            'currency' => 'required|string|min:3',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create post data will be sent to the API method
        $body=[
            'ages' =>$request->input('ages'),
            'currency' =>$request->input('currency'),
            'start_date' =>$request->input('start_date'),
            'end_date' =>$request->input('end_date'),
        ];
        
        // Configuring the request parameters and headers
        $requestNew = Request::create('/api/calculate', 'POST');  
        $requestNew->headers->set('Content-Type', 'application/json');
        $requestNew->headers->set('Authorization', 'Beaber '.$request->input('_token'));
        $requestNew->body = json_encode($body);

        // Getting data from the API in JSON format 
        $responseData = Route::dispatch($requestNew);
        $displayData = json_decode($responseData->getContent());

        // Return the quotation calculation as array
        return view('home', compact('displayData'));
    }

    
}
