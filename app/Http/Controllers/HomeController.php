<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form to calculate the quotation.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
        $displayData= null;
        return view('home',compact('displayData'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
        
        $user = Auth::user();
        
        try {
            if (!$token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'No se pudo generar el token'], 401);
            }
            $valideToken = JWTAuth::setToken($token);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Exist an error when the token was created'], 500);
        }
        
        // Create post data will be sent to the API method
        $data=[
            'ages' =>$request->input('ages'),
            'currency' =>$request->input('currency'),
            'start_date' =>$request->input('start_date'),
            'end_date' =>$request->input('end_date'),
        ];
        
        // Configuring the request parameters and headers
        $requestNew = Request::create('/api/calculate', 'POST');  
        $requestNew->headers->set('Content-Type', 'application/json');
        $requestNew->headers->set('Authorization', 'Beaber '.$valideToken->getToken());
        $requestNew->body = json_encode($data);

        // Getting data from the API in JSON format 
        $responseData = Route::dispatch($requestNew);
        $displayData = json_decode($responseData->getContent());

        // Return the quotation calculation as array
        return view('home', compact('displayData'));
    }
}
