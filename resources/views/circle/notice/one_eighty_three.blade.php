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
            <p style="font-weight: bold">আই.টি-৮৬ (২০২৩)</p>
        </div>
    </div>
    
    <br>

        <div style="text-align: center">
    	<p style="font-size: 22px; font-weight: bold;">আয়কর আইন, ২০২৩ এর ধারা ১৮৩(৩) অনুযায়ী নোটিশ<p>
    	<p style="font-size: 22px; font-weight: bold;">(আয়কর অফিস)</p>
    </div>
    
     <br>
    
    <div>
    	<p style="width: 50%; float: left">নং :</p>
    	<p style="width: 50%; text-align: right">তারিখ:..........................</p>
    </div>
    
    <div>
    	<p>প্রতি</p>
    </div>
    
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
    
    <div>
    	<p  style="width: 15%; float:left">টিআইএন</p>
    	<p  style="width: 83%; text-align: left">........................................................................</p>
    </div>
    
    <div>
    	<p>করবর্ষ : </p>
    </div>
    
    <br>
    
    <div>
    	<p style="text-align: justify">আপনি আয়কর আইন, ২০২৩ এর অধীনে রিটার্ন দাখিল করিয়াছেন, সেই প্রসঙ্গে আরও কিছু তথ্য প্রয়োজন।</p>
    	<br>
    	<p style="text-align: justify">অতএব........................তারিখ বেলা........১১.......ঘটিকায় আপনি স্বয়ং অথবা আয়কর আইন, ২০২৩ এর ৩২৭ ধারা অনুযায়ী লিখিতভাবে ক্ষমতাপ্রাপ্ত কোন অনুমোদিত প্রতিনিধি উপস্থিত হইয়া নিম্ন স্বাক্ষরকারীর নিকট আয়কর রিটার্ন সংশ্লিষ্ট দলিলপত্র, হিসাবের খাতা ও অন্যান্য প্রমাণাদি পেশ করার জন্য অনুরোধ জানানো হইল।</p>  
    	<br>
    	<p style="text-align: justify">এই নোটিশ পরিপালনে ব্যর্থ হইলে আয়কর আইন, ২০২৩ এর ১৮৪ ধারা অনুযায়ী একতরফাভাবে কর নির্ধারণ করা যাইতে পারে এবং উক্ত আইনের ২৭০ ধারা অনুযায়ী জরিমানা আরোপের বিধান রহিয়াছে।</p>
    	
    </div>
    
    <div style="text-align: right; margin-top: 0.5in">
        <p style="margin-right: 10px">উপ কর কমিশনার</p>
        <p>(নাম, স্বাক্ষর ও সীল)</p>
    </div>
    
    <br>
    <br>
    
    <div>
    	<div style="width: 55%; float: left">
    		<p style="margin-top: 0.3in">(অফিসের সীল মোহর)</p>
    	</div>
    	<div style="width: 40%">
    		<div>
    			<p>ফোন...............................</p>
    			<p>ই-মেইল...........................</p>
    			<p>ঠিকানা............................</p>
    		</div>
    	</div>
    </div>
        
	<p style="position: absolute; top: 4.55in; left: 2in">{{ $data->assessment_year }}</p>
	<p style="position: absolute; top:4.22in; left: 2in">{{ $stock->tin }}</p>
	<p style="position: absolute; top:2.7in; left: 2in">{{ $stock->tin }}</p>
	<div style="position: absolute; top:3.15in; left: 2in ">
		<p>{{ $stock->bangla_name }}</p>
		{!! htmlspecialchars_decode( $stock->address ) !!}
	</div>
	<p style="position: absolute; top:2.65in; right:1.3in">{{ $data->issue_date }}</p>
	<p style="position: absolute; top: 5.55in; left: 1.55in">{{ $data->hearing_date }}</p>			
	
</body>
</html>