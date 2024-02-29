<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style media="print">
		@page { 
				sheet-size: A4-L;
				margin:2.5in 0.2in 0.5in 3in;
			 }
		body {
				font-family: nikosh;
   				color: transparent;
   				white-space: pre;
   				cursor: text;
   				transform-origin: 0% 0%;
			}
		p{

   				 font-size: 20px;
   				 line-height: 28px;
   				 margin:0;
   				 padding: 0;
		}
		
	</style>
</head>
<body>
	<div>
		<p style="text-align: center;">“বাংলাদেশ রাষ্ট্রীয় সেবায়”</p>
		<p style="margin-bottom: 0.3in">“সবাই মিলে দিব কর-দেশ হবে স্বনির্ভর”</p>
		<p></p>
		<div style="width:60%; float: left;">
			<p style="text-decoration: underline;">প্রেরক</p>
			{!! $officeAddress !!}
		</div>
		<div style="width:40%; float: right;">
			<p style="text-decoration: underline;">প্রাপক</p>
			@if( $stock->type == 'company' )
				<p>ব্যবস্থাপনা পরিচালক</p>
			@endif
			<p>{{ $stock->bangla_name }}</p>

				{!! $stock->address !!}

				@if($stock->mobile)
					<p>মোবাইল নং: {{ App\Helpers\MyHelper::en2bn($stock->mobile) }}</p>
				@endif
		</div>
	</div>	
</body>
</html>