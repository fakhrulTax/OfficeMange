<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style media="print">
		@page {
				size: 8.5in 14in;
				margin-top: 1.9in; 
				margin-left: 0.25in; 
				margin-right: 0.25in; 
				margin-bottom: 0.5in; 
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
			font-size:20px;
			line-height: 25px;
			margin: 0;
		}

		
	</style>
</head>
<body>
	<div>
		<div style="width:4in; float:left; margin-left: 1.25in">
			<p>{{ config('settings.circle_name_'.Auth::user()->circle) }}</p>
			<p>{{  ($retarn->stock->bangla_name) ? $retarn->stock->bangla_name : $retarn->stock->name	  }}</p>
		</div>
		<div style="width:2.5in; float: left;">
			<p>{{ $Helper::en2bn($Helper::assessment_year_format($retarn->assessment_year)) }}</p>
			<p>{{ $Helper::en2bn($retarn->tin) }}</p>
		</div>		
	</div>

	<div style="margin-top: 1.6in">
		<div style="width:1.9in; float:left; text-align: center;">
			@if( $retarn->register == 'normal' )
				<p>-</p>
			@else
			<p>{{ $Helper::en2bn(date('d-m-Y', strtotime($retarn->return_submission_date))) }}</p>
			@endif	
		</div>
		<div style="width:4in; float:left;">
			@if( $retarn->register == 'normal' )
				<div>
					<p>করদাতা সধারণ পদ্ধতিতে রিটার্ণ দাখিল করেছেন। আয়কর অধ্যাদেশ,  ১৯৮৪ এর ৭৯ এবং ৮৩(১) ধারায় নোটিশ জারী করে শুনানী আগামী .................. তারিখ নির্ধারণ করুন</p>
					<p style="margin-top: 0.25in; margin-left: 2in">{{ config('settings.officer_designation') }}</p>
				</div>
			@else
			<div>
				<p>স্বনির্ধারণী রিটার্ণ দেখিলাম</p>
				<p>করদাতার আয়ের উৎস.....................</p>
				<p>প্রদর্শিত আয় টাকা........: {{ $Helper::en2bn($Helper::moneyFormatBD($retarn->income)) }}</p>
				<p>নীট সম্পদ টাকা...........: {{ $Helper::en2bn($Helper::moneyFormatBD($retarn->net_asset)) }} </p>
				<p>পরিশোধিত আয়কর টাকা: {{ $Helper::en2bn($Helper::moneyFormatBD($retarn->total_tax)) }}</p>
				<p> আয়কর আইন, ২০২৩ এর ১৮০ ধারায় {{ $Helper::en2bn($Helper::assessment_year_format($retarn->assessment_year)) }} কর বৎসরের কর মামলা নিষ্পন্ন করা হলো ।</p>
				<p style="margin-top: 0.25in; margin-left: 2in">{{ config('settings.officer_designation_'. Auth::user()->circle) }}</p>
			</div>
			<div>
				<p>ক্রমিক নং...............পৃষ্ঠা নং.................</p>
				<p>আয়কর... দাবী নাই ...সরল সুদ...............</p>
				<p>জরিমানা................অন্যান্য..................</p>
				<p>মোট.................................................</p>
				<p>পরিশোধের তাং...................................</p>
				<p>নথি উপস্থাপনের তাং.............................</p>
				<p style="margin-top: 0.25in; margin-left: 2in">{{ config('settings.officer_designation_'. Auth::user()->circle) }}</p>
			</div>	
			<div>
				<p>আয়কর আইন, ২০২৩ এর ১৮১ ধারা মোতাবেক রিটার্ণ পরীক্ষণ করা হলো।</p>				
				<p>১. আয়কর পরিগণনা সঠিক।</p>				
				<p style="margin-top: 0.25in; margin-left: 2in">{{ config('settings.officer_designation_'. Auth::user()->circle) }}</p>
			</div>	
			<div>
				<p>পার্শ্ব নোট দেখলাম। আপত্তি না থাকলে প্রার্থীত সনদ/আইটি....... এর কপি সরবরাহ করুন।</p>			
				<p style="margin-top: 0.25in; margin-left: 2in">{{ config('settings.officer_designation_'. Auth::user()->circle) }}</p>
			</div>	
			@endif	
		</div>
		<div style="width:1.4in; float:left;margin-left: 0.3in;">
			@if( $retarn->register == 'normal' )
				<p>করদাতা সাধারণ পদ্ধতিতে রিটার্ণ দাখিল করেছেন। পরবর্তী আদেশের জন্য পেশ করলাম।</p>
			@else
				<p style="margin-top: 4.5in">কর পরিগণনা যথাযথ।</p>
				<p style="margin-top: 1in; font-size: 16px; line-height: 20px;">করদাতা আয়কর প্রত্যয়নপত্র/আইটি........ এর কপির জন্য আবেদন করেছেন। সদয় আদেশের জন্য পেশ করলাম।</p>
			@endif
		</div>
	</div>
</body>
</html>