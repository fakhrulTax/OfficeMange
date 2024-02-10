<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style media="print">
		@page {
				size: 8.5in 11.69in;
				margin-top: 0.50in; 
				margin-left: 0.75in; 
				margin-right: 0.75in; 
				margin-bottom: 0.2in; 
		}
		body {
				font-family: nikosh;
   				color: transparent;
   				white-space: pre;
   				cursor: text;
   				transform-origin: 0% 0%;
   				 margin-bottom: 6cm;
			}
		p, table td{
			font-size:16px;
			line-height: 20px;
			margin: 0;
		}
		table{
			border-collapse: collapse;
		}
		table td{
			border: 1px solid #000000;
			padding: 4px;
		}

		
	</style>
</head>
<body>
    
	@php
		$assessment_year = config('settings.assessment_year_'.Auth::user()->circle);
		$advance_year = $advance->advance_assessment_year;
		$rTax = $advance->tax;
		$first = '১৫ সেপ্টেম্বর’'.' '.App\Helpers\MyHelper::en2bn(substr($assessment_year,0,4));
		$second = '১৫ ডিসেম্বর’'.' '.App\Helpers\MyHelper::en2bn(substr($assessment_year,0,4));
		$third = '১৫ মার্চ’'.' '.App\Helpers\MyHelper::en2bn(substr($assessment_year,4,4));
		$fourth = '১৫ জুন’'.' '.App\Helpers\MyHelper::en2bn(substr($assessment_year,4,4));
		$singlePremimum = App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::moneyFormatBD(round($rTax/4)));
		switch($noticePremimum)
			 	{
			 		case 1: 
			 			$premimum = '১ম';
			 			break;
			 		case 2: 
			 			$premimum ='২য়';
			 			break;
			 		case 3: 
			 			$premimum ='৩য়';
			 			break;
			 		case 4: 
			 			$premimum = '৪র্থ';
			 			break;
			 		default:
			 			$premimum ='৪র্থ';
			 	}
		switch($noticePremimum)
		{
		 		case 1: 
		 			$premimumDt =  $first;
		 			break;
		 		case 2: 
		 			$premimumDt =  $second;
		 			break;
		 		case 3: 
		 			$premimumDt = $third;
		 			break;
		 		case 4: 
		 			$premimumDt =  $fourth;
		 			break;
		 		default:
		 			$premimumDt =  $fourth;
		}
	@endphp
	
	<!--- Head ---->
	<div style="text-align: center">
		{!! config('settings.notice_address_'.Auth::user()->circle) !!}
	</div>

	<!--- Nothi No and Date ---->
	<div>
		<p style="float: left; width: 65%;">নথি নং: অগ্রিম আয়কর/{{ config('settings.circle_name_'.Auth::user()->circle) }}/{{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::assessment_year_format($assessment_year)) }}/</p>
		<p style="float: right; width: 25%; text-align: right;">তারিখ: {{ App\Helpers\MyHelper::en2bn(date('d-m-Y', strtotime($issue_date))) }} খ্রি.</p>
	</div>

	<!--- Assessee ---->
	<div style="margin-top: 0.2in">
		<p>প্রাপক:</p>
		@if( $advance->stock->type == 'company' )
			<p>ব্যবস্থাপনা পরিচালক</p>
		@endif
		<p>{{ $advance->stock->bangla_name }}</p>
			{!! $advance->stock->address !!}
		@if($advance->stock->mobile)
			মোবাইল নং: {{ App\Helpers\MyHelper::en2bn($advance->stock->mobile) }}
		@endif
		<p>টিআইএন: {{ App\Helpers\MyHelper::en2bn($advance->tin) }} </p>
	</div>

	<!--- Subject ---->	
	<p style="text-indent: 0.5in; margin-top:0.2in; margin-bottom: 0.2in;">বিষয়: আয়কর আইন, ২০২৩ এর ১৫৪ ও ১৫৫ ধারা অনুযায়ী অগ্রিম আয়কর পরিশোধ প্রসঙ্গে । </p>

	<div>
		<p>সম্মানিত করদাতা,</p>
		<p style="text-indent: 0.5in; margin-bottom: 0.2in; text-align: justify;">
			উপর্যুক্ত বিষয়ের প্রতি আপনার দৃষ্টি আকর্ষণ পূর্বক জানানো যাচ্ছে যে, আপনি {{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::assessment_year_format(($advance->return_submitted_assessment_year))) }} কর বৎসরে মোট আয় ৳ {{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::moneyFormatBD($advance->income)) }} প্রদর্শন ও মোট ৳ {{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::moneyFormatBD($rTax)) }} কর পরিশোধ করে আয়কর রিটার্ন দাখিল করেন । তদানুসারে আয়কর আইন, ২০২৩ এর ১৫৪ ধারা অনুসারে আপনার জন্য অগ্রিম কর প্রদান প্রযোজ্য ।
		</p>
		
		<p style="text-indent: 0.5in; margin-bottom: 0.2in; text-align: justify;">
			আয়কর আইন, ২০২৩ এর ১৫৪, ১৫৫ ধারা অনুযায়ী পরবর্তী {{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::assessment_year_format($advance_year)) }} করবর্ষের জন্য চলতি {{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::assessment_year_format($advance->return_submitted_assessment_year)) }} করবর্ষে সর্বশেষ নিরুপিত আয়ের বিপরীতে প্রদত্ত করের সমপরিমাণ অংশ অগ্রিম কর চলতি করবর্ষে মোট চারটি সমান কিস্তিতে যেমন: {{ $first }}, {{ $second }}, {{ $third }} ও {{ $fourth }} খ্রি. তারিখের মধ্যে পরিশোধের বিধান রয়েছে । সেই মোতাবেক অগ্রিম করের {{ $premimum  }} কিস্তি পরিশোধের সর্বশেষ তারিখ আগামী {{ $premimumDt }} খ্রি. । এমতাবস্থায় নথির রেকর্ড মোতাবেক আপনার অগ্রিম করের পরিমাণ হবে নিম্নরূপ:-
		</p>

		<div style="margin-left: 0.5in">
			<table>
				<tr>
					<td style="width: 4.5in">{{ $first }} খ্রি. তারিখের মধ্যে প্রথম কিস্তিতে করের পরিমাণ </td>
					<td style="width: 1.3in; text-align: right;"> ৳ {{ $singlePremimum  }}</td>
				</tr>
				<tr>
					<td style="width: 4.5in">{{ $second }} খ্রি. তারিখের মধ্যে দ্বিতীয় কিস্তিতে করের পরিমাণ </td>
					<td style="width: 1.3in; text-align: right;"> ৳ {{ $singlePremimum }}</td>
				</tr>
				<tr>
					<td style="width: 4.5in">{{ $third }} খ্রি. তারিখের মধ্যে তৃতীয় কিস্তিতে করের পরিমাণ </td>
					<td style="width: 1.3in; text-align: right;"> ৳ {{ $singlePremimum }}</td>
				</tr>
				<tr>
					<td style="width: 4.5in">{{ $fourth }} খ্রি. তারিখের মধ্যে চতুর্থ কিস্তিতে করের পরিমাণ </td>
					<td style="width: 1.3in; text-align: right;"> ৳ {{ $singlePremimum }}</td>
				</tr>
			</table>			
		</div>

		<p style="text-indent: 0.5in; margin-top:0.2in;">
			{{ $premimum }} কিস্তি আগামী {{ $premimumDt }} খ্রি. তারিখের মধ্যে পরিশোধতব্য অগ্রিম করের পরিমাণ টা: {{ $singlePremimum }}
		</p>

		<p style="text-indent: 0.5in; margin-top:0.2in; text-align: justify;">
			অবগতির জন্য আরো জানাচ্ছি যে, নির্ধারিত সময়ের মধ্যে অগ্রিম কর পরিশোধের ব্যর্থতায় আয়কর আইন, ২০২৩ এর ১৬২ ধারানুসারে সরল সুদ ও ২৬৯ ধারানুসারে জরিমানা আরোপ করার বিধান রয়েছে। এমতাবস্থায়, জাতীয় রাজস্ব আহরণের স্বার্থে উল্লিখিত হিসাব অনুযায়ী আগামী {{ $premimumDt }} খ্রি. তারিখের মধ্যে {{ $premimum }} কিস্তির পরিশোধতব্য সমুদয় অগ্রিম কর 
			@if($noticePremimum > 1) 
				এবং ইতোমধ্যে কোন কর পরিশোধ করা হলে তা বাদ দিয়ে অবশিষ্ট বিগত @if($noticePremimum == 2) ১ম @elseif($noticePremimum == 3) ১ম ও ২য় @elseif($noticePremimum== 4) ১ম, ২য় ও ৩য় @endif কিস্তির অগ্রিম কর
			@endif
			পরিশোধের জন্য আপনাকে বিশেষভাবে অনুরোধ জানাচ্ছি।
		</p>
		<p style="text-indent: 0.5in; margin-top:0.2in;">
			জাতীয় রাজস্ব আহরণের স্বার্থে আপনার সহযোগিতা একান্ত কাম্য।
		</p>

	</div>

	<div style="margin-left: 4in; margin-top: 0.75in;text-align: center">
		{!! config('settings.officer_name_'.Auth::user()->circle) !!}
	</div>	
</body>
</html>