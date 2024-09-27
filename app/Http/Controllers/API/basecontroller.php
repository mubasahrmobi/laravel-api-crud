<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class basecontroller extends Controller
{
   public function sendresponse($result , $message){
    $response = [
        'success' => true,
        'data' => $result,
        'message' => $message,
    ];
    return response()->json($response,200);
   }

   public function senderror($error , $emessage=[], $code = 404 ){
    $response = [
        'success' => false,
        'message' =>$error,
    ];
    if(!empty($emessage)){
        $response['data'] = $emessage;
    }
    return response()->json($response,$code);
   }
}
