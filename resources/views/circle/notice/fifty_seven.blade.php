<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style media="print">
		@page {
				size: 8.5in 11.5in;
				margin: 1in;
		}
		body {
				font-family: nikosh;
   				color: transparent;
   				white-space: pre;
   				cursor: text;
   				transform-origin: 0% 0%;
   				margin-bottom: 6cm;
			}
		p{
			font-size:18px;
			line-height: 26px;
			margin: 0;
		}

		
	</style>
</head>
<body>
    <div>
        <div style="width: 50%; float: left">
            <p style="margin-left: 5px">জাতীয় রাজস্ব বোর্ড</p>
            <p style="font-size:14px">www.nbr.gov.bd</p>
        </div>
        
        <div style="width: 50%; text-align: right">
            <p style="font-weight: bold;">আই.টি-৫৭ (২০২৩)</p>
        </div>
    </div>
    
    <br>

        <div style="text-align: center">
    	<p style="font-size: 25px; font-weight: bold;">প্রাপ্তি স্বীকারপত্র<p>
    </div>
    
     <br>
    
    
    <div>
    	<p style="width: 15%; float:left">করদাতার নাম</p>
    	<p style="width: 83%; text-align: left">........................................................................</p>
    </div>
    
    <div>
    	<p  style="width: 15%; float:left">ঠিকানা</p>
    	<div  style="width: 83%; text-align: left">
	    	<p>........................................................................</p>
	    	<p>........................................................................</p>
	    	<p>........................................................................</p>
    	</div>
    </div>

	<p>
		(১) ....................................................................... করবর্ষ সংক্রান্ত  ...................................... ...............তারিখে আয়কর নোটিশ ফরম নং .......................................
	</p>

	<br>

	<p>
		(২) ......................................................... কার্যালয়ের  ........................................... তারিখের ...................... নং পত্র ........................................... তারিখে পাইলাম।
	</p>
	
	<br>

	<div style="margin-left: 4in">
		<p>স্বাক্ষর.........................................</p>
		<p>নাম...........................................</p>
		<p>সীলমোহর (প্রযোজ্য ক্ষেত্রে)</p>
	</div>

	<div style="width: 1.5in;">
		<p style="text-align:center;">..........................</p>
		<p style="text-align:center;">যথাযথ পদ্ধতিতে জারিকৃত</p>
		<p style="text-align:center;">জারিকারকের স্বাক্ষর</p>
	</div>

	<br><br>
	
	<p style="margin-left: 3.2in">কার্যালয়ের সীলমোহর</p>
	

    
   	<p style="position: absolute; top:3.45in; right:1.3in">{{ $Helper::en2bn($data->issue_date) }} খ্রি.</p>

	<div style="position: absolute; top:2.35in; left: 2in ">
		<p>{{ $stock->bangla_name }}</p>
		{!! htmlspecialchars_decode( $stock->address ) !!}		
	</div>
	     	
	<p style="position: absolute; top: 3.45in; left: 1.3in">{{ $Helper::en2bn($data->assessment_year) }}</p>	
	<p style="position: absolute; top: 3.75in; left: 3.7in">{{ $Helper::en2bn($data->notice_section) }}</p>	

	<p style="position: absolute; top: 4.2in; left: 1.5in">{{ config('settings.circle_name_'. $circle) }}</p>
	<p style="position: absolute; top:4.2in; right:2.3in">{{ $Helper::en2bn($data->issue_date) }} খ্রি.</p>
	
</body>
</html>