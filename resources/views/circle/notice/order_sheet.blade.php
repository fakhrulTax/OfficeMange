<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style media="print">
		@page {
				size: 8.5in 11in;
				margin-top: {{ config('settings.order_sheet_top_margin') }}in; 
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
			<p>{{ config('settings.circle_name') }}</p>
			<p>{{  ($stock->bangla_name) }}</p>
		</div>
		<div style="width:2.5in; float: left;">
			<p>{{ en2bn($data->assessment_year) }}</p>
			<p>{{ en2bn(tinSlice($stock->tin)) }}</p>
		</div>		
	</div>

	<div style="margin-top: {{ config('settings.order_sheet_head_to_body_distance') }}in">
		<!--- Left --->
		<div style="width:{{ config('settings.order_sheet_left_width') }}in; float:left; text-align: center;">			
			<p>{{ en2bn(date('d-m-Y', strtotime($data->issue_date))) }}</p>
		</div>
		<!--- Middle --->
		<div style="width:{{ config('settings.order_sheet_middle_width') }}in; float:left;">
			@if( $data->type == "212" )
				<p style="text-align: justify;">
					করদাতা সময়মত আয়কর রিটার্ন দাখিল করেননি। আয়কর আইন, ২০২৩ এর ২১২ ধারায় নোটিশ জারী করে শুনানি আগামী {{ en2bn(date('d-m-Y', strtotime($data->hearing_date))) }} তরিখে ধার্য করা হোক।		
				</p>
				<p style="margin-top: 0.3in; margin-left: 3in">{{ config('settings.officer_designation') }}</p>
				
			@elseif( $data->type == "280" )
				<p style="text-align: justify;">
					করদাতা সময়মত রিটার্ন দাখিল না করার কারণে কেন আয়কর আইন, ২০২৩ এর ২৬৬ ধারায় জরিমানা আরোপ করা হবে না, তার ব্যাখ্যা দাখিলের জন্য ২৮০ ধারায় নোটিশ জারী করে শুনানি আগামী {{ en2bn(date('d-m-Y', strtotime($data->hearing_date))) }} খ্রি. তারিখে ধার্য কর হোক।
				</p>
				<p style="margin-top: 0.3in; margin-left: 3in">{{ config('settings.officer_designation') }}</p>
				
			@elseif( $data->type == "212280" )
				<p style="text-align: justify;">
					করদাতা সময়মত রিটার্ন দাখিল না করার কারণে কেন আয়কর আইন, ২০২৩ এর ২৬৬ ধারায় জরিমানা আরোপ করা হবে না, তার ব্যাখ্যা দাখিলের জন্য ২৮০ ধারায় নোটিশ জারী করে শুনানি আগামী {{ en2bn(date('d-m-Y', strtotime($data->hearing_date))) }} খ্রি. তারিখে ধার্য করা হোক এবং একই সাথে আয়কর আইন, ২০২৩ এর ২১২ ধারায় নোটিশ জারী করুন।
				</p>
				<p style="margin-top: 0.3in; margin-left: 3in">{{ config('settings.officer_designation') }}</p>
				
			@elseif( $data->type == "179" )
				<p style="text-align: justify;">
					করদাতা বা তাঁর মনোনীত প্রতিনিধির কোনো সাড়া নাই। আয়কর আইন, ২০২৩ এর ১৭৯ ধারার নোটিশ জারি করে শুনানি আগামী {{ en2bn(date('d-m-Y', strtotime($data->hearing_date))) }} খ্রি. তারিখে ধার্য কর হোক।
				</p>
				<p style="margin-top: 0.3in; margin-left: 3in">{{ config('settings.officer_designation') }}</p>
				
			@elseif( $data->type == "179183" )
				<p style="text-align: justify;">
					করদাতার দাখিলকৃত আয়কর রিটার্নটি সাধারণ পদ্ধতিতে গ্রহণ করা হলো। আয়কর আইন, ২০২৩ এর ১৭৯ ও ১৮৩(৩) ধারার নোটিশ জারি করে শুনানি আগামী {{ en2bn(date('d-m-Y', strtotime($data->hearing_date))) }} খ্রি. তারিখে ধার্য কর হোক।
				</p>		
				<p style="margin-top: 0.3in; margin-left: 3in">{{ config('settings.officer_designation') }}</p>
			@endif			
		</div>
		<!--- Right --->
		<div style="width:{{ config('settings.order_sheet_right_width') }}in; float:left;margin-left: 0.3in;">			
		</div>
	</div>
</body>
</html>