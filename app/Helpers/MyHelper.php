<?php
// app/Helpers/MyHelper.php

namespace App\Helpers;
use App\Models\Stock;
use App\Models\Arrear;
use App\Models\User;
use App\Models\SMSModel;
use Illuminate\Support\Facades\Auth;




class MyHelper
{
    //Assessment Year Format
    public static function assessment_year_format( $number )
    {
         return substr($number,0,4).'-'.substr($number,4,8);

    }

    //Short Name
    public static function sortName($name){
        $sort_name = strtolower($name);
        $sort_name = explode(' ', $sort_name);
        if( $sort_name[0] == 'md' || $sort_name[0] == 'md.' || $sort_name[0] == 'm/s'|| $sort_name[0] == 'm/s-' || $sort_name[0] == 'm/s.' || $sort_name[0] == 'm/s:' || $sort_name[0] == 'ms' || $sort_name[0] == 'mrs,' || $sort_name[0] == 'mst' || $sort_name[0] == 'mst.'|| $sort_name[0] == 'mrs' || $sort_name[0] == 'mosammat' || $sort_name[0] == "messer's"  )
          {
            array_shift( $sort_name);
          }
          $sort_name = implode(' ', $sort_name);
          return $sort_name;
    }
    // Add more helper methods as needed

    public static function tinCheck($tin){

        $existTin = Stock::where('tin', $tin)->first();

        if($existTin){
            return true;
        }else{
            return false;
        }
    }

    public static function moneyFormatBD($num) {
        
        if( $num < 1 )
        {
            return 0;
        }

        $explrestunits = "" ;

        if(strlen($num)>3) {
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
            $expunit = str_split($restunits, 2);
           
            for($i=0; $i<sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if($i==0) {
                    $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                } else {
                    $explrestunits .= $expunit[$i].",";
                }
            }

            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; // writes the final format where $currency is the currency symbol.
    }



    public static function calculateArrearSum($circle = null) {

        $user = Auth::user();
    
        if($user->user_role == 'range' && $circle == 'all') {
            $circles = self::rangWiseCircle($user->range); 
    
            $totals = Arrear::whereIn('circle', $circles)
                ->selectRaw('SUM(arrear) as total_arrear, SUM(fine) as total_fine')
                ->first();
    
            $disputed = Arrear::whereIn('circle', $circles)
                ->where('arrear_type', 'disputed')
                ->selectRaw('SUM(arrear) as disputed_arrear, SUM(fine) as disputed_fine')
                ->first();
    
            $undisputed_arrear = $totals->total_arrear - ($disputed->disputed_arrear ?? 0);
            $undisputed_fine = $totals->total_fine - ($disputed->disputed_fine ?? 0);
    
            return $result = [
                'GrandArrear' => number_format(($totals->total_arrear ?? 0) + ($totals->total_fine ?? 0)),
                'TotalDisputedArrear' => number_format(($disputed->disputed_arrear ?? 0) + ($disputed->disputed_fine ?? 0)),
                'TotalUndisputedArrear' => number_format(($undisputed_arrear ?? 0) + ($undisputed_fine ?? 0)),
            ];
    
        }
    
        $query = Arrear::query();
    
        if ($circle !== 'all') {
            $query->where('circle', $circle);
        }
    
        $totals = $query->selectRaw('SUM(arrear) as total_arrear, SUM(fine) as total_fine')
                       ->first();
    
        $disputed = $query->where('arrear_type', 'disputed')
                          ->selectRaw('SUM(arrear) as disputed_arrear, SUM(fine) as disputed_fine')
                          ->first();
    
        $undisputed_arrear = $totals->total_arrear - ($disputed->disputed_arrear ?? 0);
        $undisputed_fine = $totals->total_fine - ($disputed->disputed_fine ?? 0);
    
        return $result = [
            'GrandArrear' => number_format(($totals->total_arrear ?? 0) + ($totals->total_fine ?? 0)),
            'TotalDisputedArrear' => number_format(($disputed->disputed_arrear ?? 0) + ($disputed->disputed_fine ?? 0)),
            'TotalUndisputedArrear' => number_format(($undisputed_arrear ?? 0) + ($undisputed_fine ?? 0)),
        ];
    }

    


    public static function rangWiseCircle($range):array
    {
        $ranges = [
            '1' => [1, 2, 3, 4, 5, 6],
            '2' => [7, 8, 9, 10, 11, 12],
            '3' => [13, 14, 15, 16, 17],
            '4' => [18, 19, 20, 21, 22],
        ];
    
        return $ranges[$range];
      
    }


    public static function sendOtp($user){
          // Generate OTP
          $otp = rand(100000, 999999);

          // Store OTP in database
  
          User::where('id', $user->id)->update(['user_otp' => $otp, 'otp_expired_at' => now()->addMinutes(5)]);

          $reciver = $user->mobile_number;
          $text = 'Your OTP is: ' . $otp;
          $type = 'otp';

          $response = MyHelper::sendMessage($reciver, $text, $type);

          $data = json_decode($response, true);

          

          if ($data['response_code'] == 202 ) {
              return true;
          }else{
              return false;
          }

        
    }


    public static function sendMessage($reciver, $text, $type) {
        $apiKey = 'igrlK8G7BaluoUkj9Egh';
        $senderId = '8809617615162';

        $url = 'http://bulksmsbd.net/api/smsapi';

        $number =$reciver;
        $message = $text;

        $queryParams = http_build_query([
            'api_key' => $apiKey,
            'type' => 'text',
            'number' => $number,
            'senderid' => $senderId,
            'message' => $message,
        ]);

        $url .= '?' . $queryParams;

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Only for testing, remove in production

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            return response()->json(['error' => $error], 500);
        }

        // Close cURL session
        curl_close($ch);

        SMSModel::create([
            'sms_body' => $text,
            'receiver_number' => $reciver,
            'response'=>  json_encode(json_decode($response)),
            'sms_type' => $type
        ]);

        return $response;
    }


  



   
   
    
    
    
}
