<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style media="print">
		@page {
				size: 8.5in 11.69in;
				margin: 0.5in 0.50in 0.1in 0.50in; 
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
			font-size:13pt;
			line-height: 16pt;
			margin: 0;
		}	
		table{
			border-collapse: collapse;
		}	
		td{
			margin: 0;
			border: 1px solid #000000;
			padding: 5px;
		}
	</style>
</head>
<body>
	<div style="text-align: center; font-size: 13pt;">
		{!! config('settings.notice_address') !!}
	</div>	
	<div>
		<p style="float: left; width: 70%">টিআইএন: {{ en2bn($stock->tin) }}</p>
		<p style="float: right; width: 30%; text-align: right;">তারিখ: {{ en2bn(date('d-m-Y', strtotime($data->issue_date))) }} খ্রিঃ</p>
	</div>
	<div style="margin-top: 0.2in">
		<p>{{ $stock->bangla_name }}</p>
		{!! $stock->address !!}		
	</div>
	<p style="text-indent: 0.5in; margin-top: 0.2in">বিষয়: বকেয়া আয়কর পরিশোধ প্রসঙ্গে ।</p>	
	<p style="text-indent: 0.5in;margin-top: 0.2in">উপর্যুক্ত বিষয়ের প্রতি আপনার দৃষ্টি আকর্ষণ করছি ।</p>	
	<p style="text-indent: 0.5in;margin-top: 0.2in; text-align: justify;">নিম্নে বর্ণিত ছক মোতাবেক আপনার নিকট হতে আয়কর দাবি অদ্যাবদি পরিশোধ করা হয়নি মর্মে নথি দৃষ্টে প্রতীয়মান হয়:-</p>
	<div style="margin-top: 0.2in">
		<table style="margin: 0 auto">
			<tr>
				<td style="width: 1in; text-align: center;">করবর্ষ</td>
				<td style="width: 1.5in; text-align: center;">বকেয়া আয়কর</td>
				<td style="width: 1.5in; text-align: center;">জরিমানা</td>
				<td style="width: 1.8in; text-align: center;">মোট বকেয়া দাবি</td>
			</tr>
			
			@foreach( $arrears as $arrear )
			@if( ( $arrear->arrear + $arrear->fine ) <= $collection->getArrearCollectionSumByYear($stock->tin, $arrear->assessment_year) )
			    <?php continue; ?>
			@endif
			
			<tr>				
				<td>
				    {{ en2bn(yearSlice($arrear->assessment_year)) }}
				</td>
				<td>{{ en2bn(moneyFormatBD($arrear->arrear - $collection->getArrearCollectionSumByYear($stock->tin, $arrear->assessment_year))) }}</td>
				<td>{{ en2bn(moneyFormatBD($arrear->fine)) }}</td>
				<td>
				    {{ en2bn(moneyFormatBD(($arrear->arrear + $arrear->fine) - $collection->getArrearCollectionSumByYear($stock->tin, $arrear->assessment_year) )) }}
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	<p style="text-indent: 0.5in; margin-top: 0.2in; text-align: justify;">
		উপর্যুক্ত বকেয়া আয়কর ও জরিমানা আগামী {{ en2bn(date('d-m-Y', strtotime($data->hearing_date))) }} খ্রিঃ এর পূর্বে পরিশোধের অনুরোধ জানাচ্ছি । যদি ইতোমধ্যে বকেয়া কর পরিশোধ করা হয়ে থাকে তাহলে ট্রেজারী চালানের অথবা পে-অর্ডারের অনুলিপি নিম্নস্বাক্ষরকারীরর কার্যালয়ে দাখিল করার জন্য আপনাকে অনুরোধ করা হলো ।
	</p>	
	<p style="text-indent: 0.5in;margin-top: 0.2in; text-align: justify;">
		নির্ধারিত সময়ের মধ্যে বকেয়া আয়কর পরিশোধ করা না হলে বকেয়া কর দাবি আদায়ের লক্ষ্যে আয়কর আইন, ২০২৩ এর ২৭৫ ধারা অনুযায়ী সমপরিমাণ জরিমানা আরোপ, ২১৫(১) ধারায় ব্যাংক হিসাব জব্দকরণ, ২২১(৭) ধারা অনুযায়ী গ্যাস, বিদ্যুৎ, পানি বা অন্যান্য সেবার সংযোগ বিচ্ছিন্নকরণ এবং ২২০(১) ধারায় সার্টিফিকেট মামলা দায়েরসহ অন্যান্য আইনানুগ ব্যবস্থা গ্রহণ করা হবে।
	</p>	
	<p style="text-indent: 0.5in; margin-top: 0.2in;">
		জাতীয় রাজস্ব আহরণে আপনার সহযোগিতা একান্তভাবে কাম্য।
	</p>
	<div style="margin-left: 4in; margin-top: 0.5in">
		<div style="text-align: center">
				{!! config('settings.officer_name') !!}
		</div>		
	</div>
</body>
</html>