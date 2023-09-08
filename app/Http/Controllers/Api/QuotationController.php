<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{
    public function calculateTotal(Request $request)
    {   
        $validator = Validator::make($request->all(),[
            'ages' => 'required',
            'currency' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()->first()
            ], 422);
        }
        else
        {
            // Parse ages and calculate age load
            $total = 0;
            $agesArray = explode(',', $request->ages);
            foreach ($agesArray as $age) {
                $ageLoad = 0;
                if ($age >= 18 && $age <= 30) {
                    $ageLoad += 0.6;
                } elseif ($age >= 31 && $age <= 40) {
                    $ageLoad += 0.7;
                } elseif ($age >= 41 && $age <= 50) {
                    $ageLoad += 0.8;
                } elseif ($age >= 51 && $age <= 60) {
                    $ageLoad += 0.9;
                } else {
                    $ageLoad += 1;
                }
                // Calculate trip length
                $start = new \DateTime($request->start_date);
                $end = new \DateTime($request->end_date);
                $tripLength = $start->diff($end)->days + 1;
        
                // Calculate total price
                $fixedRate = 3;
                $total += $fixedRate * $ageLoad * $tripLength;
            }
            
            return response()->json(['total' => $total, 'currency_id' => $request->currency, 'quotation_id' => 1], 200);
        }
    }
}
