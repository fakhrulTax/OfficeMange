<?php
// app/Helpers/MyHelper.php

namespace App\Helpers;
use App\Models\Stock;
use App\Models\Arrear;
use App\Models\User;
use App\Models\SMSModel;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;




class MyHelper
{

    //Get Current Assessment Year
    public static function currentAssessmentYear($date = null)
    {
        // If no date is provided, use the current date
        $date = $date ? Carbon::parse($date) : Carbon::now();

        // Get the year of the given date
        $currentYear = $date->year;

        // Fiscal year starts on July 1st and ends on June 30th
        // Check if the current date is before July 1st of the current year
        if ($date->lt(Carbon::create($currentYear, 7, 1))) {
            // If before July, it's part of the previous fiscal year
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        } else {
            // Otherwise, it's part of the current fiscal year
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        }

        // Return the fiscal year in the format YYYYYYYY (e.g., 20232024)
        return $startYear . $endYear;
    }
    
    public static function ranges($range)
    {
        $ranges = [
            'range-1' => [1,2,3,4,5,6],
            'range-2' => [7,8,9,10,11,12],
            'range-3' => [13,14,15,16,17],
            'range-4' => [18,19,20,21,22],
        ];
        
        return $ranges[$range];
    }

    //Address decode without p tag
    public static function address_decode($htmlString) {
        preg_match_all('/<p>(.*?)<\/p>/', $htmlString, $matches);
        return $matches[1];
    }

    //Address Encode with p tag
    public static function address_encode($line1, $line2, $line3)
    {
        $address = '<p>'. $line1 .'</p><p>'. $line2 .'</p><p>'. $line3 .'</p>';
        return $address;
    }


    //Assessment Year Format
    public static function assessment_year_format( $number )
    {
         return substr($number,0,4).'-'.substr($number,4,8);
         
    }

     //Number Convert English To Bangla
     public static function en2bn($number) {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
       return str_replace($en, $bn, $number);
    }

    //Total in bangla
    public static function  num2bangla($number)
    {
        if (($number < 0) || ($number > 999999999))
        {
            return "নাম্বারটি অতিরিক্ত বড়";
        } elseif (!is_numeric($number))
        {
            return "বৈধ নাম্বার নয়";
        }

        $Kt = floor($number / 10000000); /* Koti */
        $number -= $Kt * 10000000;
        $Gn = floor($number / 100000);  /* lakh  */
        $number -= $Gn * 100000;
        $kn = floor($number / 1000);     /* Thousands (kilo) */
        $number -= $kn * 1000;
         $Hn = floor($number / 100);      /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);       /* Tens (deca) */
        $n = $number % 10;               /* Ones */
        $res = "";
        $hund = ["", "এক", "দুই", "তিন", "চার", "পাঁচ", "ছয়", "সাত", "আট", "নয়", "দশ", "এগার", "বার", "তের", "চৌদ্দ", "পনের", "ষোল", "সতের", "আঠার", "ঊনিশ", "বিশ", "একুশ", "বাইশ", "তেইশ", "চব্বিশ", "পঁচিশ", "ছাব্বিশ", "সাতাশ", "আঠাশ", "ঊনত্রিশ", "ত্রিশ", "একত্রিশ", "বত্রিশ", "তেত্রিশ", "চৌত্রিশ", "পয়ত্রিশ", "ছত্রিশ", "সতত্রিশ", "আটত্রিশ", "ঊনচল্লিশ", "চল্লিশ", "একচল্লিশ", "বেয়াল্লিশ", "তেতাল্লিশ", "চোয়াল্লিশ", "পঁয়তাল্লিশ", "ছেচল্লিশ", "সতচল্লিশ", "আটচল্লিশ", "ঊনপঞ্চাশ", "পঞ্চাশ", "একান্ন", "বাহান্ন", "তেপান্ন", "চোয়ান্ন", "পঁঞ্চান্ন", "ছাপ্পান্ন", "সাতান্ন", "আটান্ন", "ঊনষাট", "ষাট", "একষট্টি", "বাষট্টি", "তেষট্টি", "চৌষট্টি", "পঁয়ষট্টি", "ছেষট্টি", "সতাষট্টি", "আটষট্টি", "ঊনসত্তর", "সত্তর", "একাত্তর", "বাহাত্তর", "তেহাত্তর", "চোয়াত্তর", "পঁচাত্তর", "ছিয়াত্তর", "সাতাত্তর", "আটাত্তর", "ঊনআশি", "আশি", "একাশি", "বিরাশি", "তিরাশি", "চোরাশি", "পঁচাশি", "ছিয়াশি", "সাতাশি", "অটাশি", "ঊননব্বই", "নব্বই", "একানব্বই", "বিরানব্বই", "তিরানব্বই", "চুরানব্বই", "পঁচানব্বই", "ছিয়ানব্বই", "সাতানব্বই", "আটানব্বই", "নিরানব্বই", "একশ"];
        if ($Kt)
        {
            $res .= $hund[$Kt] . " কোটি ";
        }
        if ($Gn)
        {
            $res .= $hund[$Gn] . " লক্ষ";
        }
        if ($kn)
        {
            $res .= (empty($res) ? "" : " ") .
                $hund[$kn] . " হাজার";
        }
        if ($Hn)
        {
            $res .= (empty($res) ? "" : " ") .
                $hund[$Hn] . " শত";
        }
        if ($Dn || $n)
        {
            if (!empty($res))
            {
                $res .= " ";
            }
                $res .= $hund[$Dn * 10 + $n];
        }
        if (empty($res))
        {
            $res = "শূন্য";
        }
        return $res;

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


  
    public static function dateRangeAssessmentYear($assessmentYear = 20232024)
    {
        $months = [];
    
        $startYear = substr($assessmentYear, 0, 4);
        $endYear = substr($assessmentYear, 4, 4);

        $currentYear = $startYear;
        $currentMonth = 7; // Start from July

        while ($currentYear < $endYear || ($currentYear == $endYear && $currentMonth <= 6)) {
            // Format the month and year
            $formattedMonth = date('F Y', strtotime("$currentMonth/01/$currentYear"));
            $months[] = $formattedMonth;

            // Move to the next month
            $currentMonth++;
            if ($currentMonth > 12) {
                $currentMonth = 1;
                $currentYear++;
            }
        }

        return $months;
    }
    //Format Two Lines
    public static function formatToTwoLines($string, $maxLength = 30)
    {
        // Split the string into words
        $words = explode(' ', $string);
        $formattedString = '';
        $currentLine = '';

        foreach ($words as $word) {
            // Check if adding the next word exceeds the max length
            if (strlen($currentLine) + strlen($word) + 1 <= $maxLength) {
                // Append the word to the current line
                $currentLine .= ($currentLine ? ' ' : '') . $word;
            } else {
                // Add the current line to the formatted string and start a new line
                $formattedString .= $currentLine . "<br>";
                $currentLine = $word; // Start new line with the current word
            }
        }

        // Add the last line if there's remaining text
        if ($currentLine) {
            $formattedString .= $currentLine;
        }

        return $formattedString;
    }
    
    
    
}
