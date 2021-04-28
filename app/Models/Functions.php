<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mailgun\Mailgun;

class Functions extends Model
{
    use HasFactory;

    public static function sendMaisl($emails){
        try{

            $return = [];
          
            $mailgum = Mailgun::create(env('APITOKEN'));

            $domain = env('DOMAIN');

            foreach($emails as $index => $email){
                
                    
                $result = $mailgum->messages()->send($domain, array(
                    'from'	=> 'LiveOn <mailgun@'.$domain.'>',
                    'to'	=> $email['to'],
                    'subject' => isset($email['subject'])?$email['subject']:"without subject",
                    'html'	=> isset($email['content'])?$email['content']:"without content"
                ));
                    
                $return[][$email['to']]["message"] = $result->getMessage();
               
            }

            return $return;
           
        }catch(Exception $e){

            abort(500, $e->getMessage());

        }

    }

    public static function validade($request){
        try{

            $return = [];
            $return['error'] = false;
            $return['message'] = [];

            if(!isset($request->mails)){
                $return['error'] = true;
                $return['message'] = "Mail(s) not found";
                return $return;
            }

            if(!is_array($request->mails)){

                $return['error'] = true;
                $return['message'] = "Mail not is a array";
                return $return;

            }

            foreach ($request->mails as $value) {
                
                if(!isset($value['to'])){
                    $return['error'] = true;
                    $return['message'][] = '"To" mail not informed';
                }

            } 

            return $return;

        }catch(\Exception $e){

            LogError::saveLog($e->getMessage(),__CLASS__,__FUNCTION__);
           
            return response()->json(["error" => true, "message" => "Error on send mail"],500);

        }
    }
}
