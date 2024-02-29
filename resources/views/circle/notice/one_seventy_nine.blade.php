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
            <p style="font-weight: bold">আই.টি-১৩ (২০২৩)</p>
        </div>
    </div>
    
    <br>

        <div style="text-align: center">
    	<p style="font-size: 22px; font-weight: bold;">আয়কর আইন, ২০২৩ এর ধারা ১৭৯ অনুযায়ী নোটিশ<p>
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
    	<p style="text-align: justify">যেহেতু উপরিউক্ত করবর্ষের আয়কর ধার্য  প্রসঙ্গে আয়কর আইন, ২০২৩ এর ধারা ১৬৬, ১৭৫ বা ১৭৬ অনুযায়ী আপনি একখানি আয়কর রিটার্ন  দাখিল করিয়াছেন/ধারা ১৭২ বা ২১২ অনুযায়ী........................খ্রি. তারিখ যুক্ত একটি নোটিশ...................... তারিখে আপনার উপর জারী করা হইয়াছে, উক্ত আইনের ধারা ১৭৯ অনুযায়ী আপনাকে অবহিত করা যাইতেছে যে, নিম্নস্বাক্ষরকারীর অফিসে ............................খ্রি. তারিখ পূর্বাহ্ন/অপরাহ্ন.......১১........... ঘটিকায় নিম্নবর্ণিত হিসাব বহি/দলিলাদি দাখিল করিবেন।  </p>  
    	
    	<p style="text-align: justify">এই নোটিশ পরিপালনে ব্যর্থ হইলে আয়কর আইন, ২০২৩ এর  ধারা ২৭০ অনুযায়ী জরিমানা আরোপের বিধান রহিয়াছে।</p>
    	
    	<p style="text-decoration:underline; font-weight: bold">হিসাব বহি/দলিলাদির বিবরণ :</p>
    	
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
        
	<p style="position: absolute; top: 4.85in; left: 2in">{{ $Helper::en2bn($Helper::assessment_year_format($data->assessment_year)) }}</p>

	<p style="position: absolute; top:4.52in; left: 2in">{{ $Helper::en2bn($stock->tin) }}</p>
	<p style="position: absolute; top:2.7in; left: 2in">{{ $Helper::en2bn($stock->tin) }}</p>

	<div style="position: absolute; top:3.15in; left: 2in ">
		<p>{{ $stock->bangla_name }}</p>
		{!! htmlspecialchars_decode( $stock->address ) !!}
        @if( $stock->mobile )
            <p>মোবাইল নং: {{ $Helper::en2bn($stock->mobile) }}</p>
        @endif
	</div>
    

	<p style="position: absolute; top:2.65in; right:1.1in">{{ $Helper::en2bn($data->issue_date) }} খ্রি.</p>
	<p style="position: absolute; top: 6.15in; left: 5.6in">{{ $Helper::en2bn($data->hearing_date) }}</p>	

	<div style="position: absolute; left: 1.2in; top: 7.5in">
		@if($stock->type == 'company' || $stock->type == 'firm')

			<p>ক) প্রদর্শিত সকল খাতের সমর্থনে যাচাইযোগ্য প্রমাণাদি</p>
			<p>খ) নিরীক্ষিত হিসাব বিবরণীর স্থিতিপত্র, লাভ-ক্ষতি হিসাব এবং সম্পদ সংযোজনের স্বপক্ষে প্রমাণাদি</p>
			<p>গ) ব্যাংক হিসাব বিবরণী ও ব্যাংক সমন্বয় বিবরণী</p>
			<p>ঘ) উৎসে কর কর্তনের সমর্থনে প্রমাণাদি</p>

		@else

            <p>ক) প্রদর্শিত সকল খাতের সমর্থনে যাচাইযোগ্য প্রমাণাদি</p>
            <p>খ) আইটি-১০বি- প্রদর্শিত সম্পদ হ্রাস বৃদ্ধির সমর্থনে প্রমাণাদি</p>
            <p>গ) ব্যাংক হিসাব বিবরণী</p>
            <p>ঘ) পারিবারিক খরচের সমর্থনে প্রমাণাদি</p>
            <p>ঙ) অন্যান্য</p>       

            
		@endif
	</div>	
	
</body>
</html>