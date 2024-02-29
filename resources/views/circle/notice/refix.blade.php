<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style media="print">
		@page {
				size: 8.5in 11.69in;
				margin-top: 0.75in; 
				margin-left: 1in; 
				margin-right: 1in; 
				margin-bottom: 0.75in; 
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
			line-height: 22px;
			margin: 0;
		}

		
	</style>
</head>
<body>
	<div style="text-align: center">
		{!! config('settings.notice_address_'.$circle) !!}
	</div>
	<div>
		<p style="float: left; width: 60%;">নথি নং: {{ $Helper::en2bn($stock->tin) }}</p>
		<p style="float: right; width: 30%; text-align: right;">তারিখ: {{ $Helper::en2bn($data->issue_date) }} খ্রি.</p>
	</div>

	<div>
		<p style="margin-top: 0.1in;font-style: bold;">{{ $stock->bangla_name }}</p>
		<div>
            {!! htmlspecialchars_decode( $stock->address ) !!}
            @if( $stock->mobile )
                <p>মোবাইল নং: {{ $Helper::en2bn($stock->mobile) }}</p>
            @endif
        </div>	
		<p>টিআইএন: {{$Helper::en2bn($stock->tin) }}</p>
	</div>
	<p style="text-indent: 0.5in; margin-top:0.2in; margin-bottom: 0.2in; font-style: bold; line-height: 30px;">বিষয়: আয়কর মামলা নিষ্পত্তির লক্ষ্যে পুনরায় ১৮৩(৫) ধারায় শুনানীর নোটিশ প্রেরণ প্রসঙ্গে । </p>
	<p style="text-indent: 0.5in; margin-bottom: 0.2in; font-style: bold; line-height: 30px">কর বৎসর: {{ $Helper::en2bn($data->assessment_year) }} </p>
	
	<p style="text-indent: 0.5in; margin-bottom: 0.2in; text-align: justify;">
		আপনাকে এই মর্মে অবহিত করা যাইতেছে যে, আপনি/আপনার করদাতা কোম্পানি/করদাতা ফার্মের উপর বর্ণিত কর বৎসর/কর বৎসর সমূহের কর মামলা নিষ্পত্তির জন্য ইতোমধ্যে আয়কর আইন, ২০২৩ এর ১৮৩(৩) ও ১৭৯ ধারায় শুনানীর দিন ধার্য করিয়া বিধিবদ্ধ নোটিশ জারি করা হইয়াছে।
	</p>
	<p style="text-indent: 0.5in; margin-bottom: 0.2in; text-align: justify;">
		উপরোক্ত কর মামলা/কর মামলা সমূহ দ্রুত নিষ্পত্তিকল্পে পুনরায় আগামী {{  $Helper::en2bn($data->hearing_date)  }} খ্রি. তারিখ, বেলা ১১.০০ ঘটিকার সময় শুনানীর দিন ধার্য করা হইল।
	</p>
	<p style="text-indent: 0.5in; margin-bottom: 0.2in; text-align: justify;">
		আপনার বরাবরে ইতোপূর্বে জারিকৃত বিধিবদ্ধ নোটিশ সমূহের শর্তাবলী অনুযায়ী সকল ব্যাংক হিসাব বিবরণী, প্রয়োজনীয় কাগজ-পত্রাদি, দলিলাদি, ক্রয়-বিক্রয়-ক্যাশ মেমো-রেজিস্টার-চালান পত্র, খরচ দাবীর বিল-ভাউচার, বাড়ি ভাড়া প্রাপ্তির ক্ষেতে ভাড়ার চুক্তিপত্র সহ হিসাবের সকল প্রকারের প্রমাণাদি সহ নির্ধারিত তারিখে আপনি নিজে অথবা আপনার কর্তৃক ক্ষমতা প্রাপ্ত আইনানুগ প্রতিনিধিকে নিম্নস্বক্ষরকারীর অফিসে উপস্থিত হইতে অনুরোধ করা যাইতেছে।
	</p>
	<p style="text-indent: 0.5in; margin-bottom: 0.2in; text-align: justify;">
		নির্ধারিত তারিখে আপনি অথবা আপনার ক্ষমতা প্রাপ্ত আইনানুগ প্রতিনিধি শুনানীতে হাজির হইতে ব্যর্থ হইলে বর্ণিত কর বৎসর/কর বৎসর সমূহের আয়কর মামলা আয়কর আইন, ২০২৩ এর ১৮৪ ধারা মোতাবেক সর্বোত্তম বিচার বিবেচনায় একতরফা ভাবে নিষ্পত্তি করা হইবে।
	</p>
	<p style="text-indent: 0.5in; margin-bottom: 0.8in;">
		জাতীয় রাজস্ব আহরণে আপনার সহযোগিতা একান্তভাবে কাম্য।
	</p>

	<div style="margin-left: 4in">
		<div style="text-align: center">
			{!! config('settings.officer_name_'. $circle) !!}
		</div>		
	</div>
</body>
</html>