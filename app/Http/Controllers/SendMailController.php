<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogError;
use App\Models\Functions;

class SendMailController extends Controller
{
    public function send(Request $request){

        try{

            if( empty( env('APITOKEN',"") ) || empty( env('DOMAIN',"") ) ){

                return response()->json(["error" => true, "message" => "Error in the application parameters"],500);

            }

            $res_validade = Functions::validade($request);

            if($res_validade['error']){

                return response()->json(["error" => true, "message" => $res_validade['message'] ],500);

            }

            return Functions::sendMaisl($request->mails);          

        }catch(\Exception $e){

            LogError::saveLog($e->getMessage(),__CLASS__,__FUNCTION__);
           
            return response()->json(["error" => true, "message" => "Error on send mail"],500);

        }

    }

    
}
