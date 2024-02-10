<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style media="print">
		@page { 
				sheet-size: A4;
				margin:0.5in 1in 0.5in 1in;
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
		
		table{
			border-collapse: collapse;
			border-style: solid;
		}
		table, th, td{
			border: 1px solid #000;
			text-align: center;
		}
		
	</style>
</head>
<body>
	<div>
        <div>
            <h4 style="text-align: center;">অগ্রিম আয়কর রেজিস্টর</h4>
            <h4 style="text-align: center">{{ config('settings.circle_name_'.Auth::user()->circle) }}</h4>
        </div>
        
		<table>
          <thead>
            <tr>
              <th style="width: 0.5in">ক্রমিক</th>    
              <th style="width: 2.5in">করদাতার নাম, ঠিকানা এবং টিআইএন</th>    
              <th  style="width: 1in">করবর্ষ</th>    
              <th  style="width: 1.5in">সর্বশেষ দাখিলকৃত রিটার্নের তথ্য</th>           
              <th style="width: 2in">অগিম কর আদায়</th>               
            </tr>
          </thead>
          <tbody>
            @php $i =1 @endphp
            @foreach( $advances as $advance )
            <tr>
              <td>{{ App\Helpers\MyHelper::en2bn($i) }}</td>
              <td style="text-align: left;">
                {{ App\Helpers\MyHelper::en2bn($advance->tin) }} <br>
                {{ ($advance->stock->bangla_name)?$advance->stock->bangla_name:$advance->stock->name }}<br>
                {!! $advance->stock->address !!}
              </td>
              <td>{{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::assessment_year_format($advance->advance_assessment_year)) }}</td>
                <td style="text-align: left">
                    রিটার্ন: {{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::assessment_year_format($advance->return_submitted_assessment_year)) }} <br>
                     আয়: {{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::moneyFormatBD( $advance->income)) }} <br>
                    কর: {{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::moneyFormatBD( $advance->tax)) }}
                </td>
              <td style="text-align: left">
                <?php $collections = App\Models\Collection::getAdvanceByAssessmentYear($advance->tin, $advance->advance_assessment_year); ?>
                @foreach($collections as $c)
                  <p>
                      টাকা: {{ App\Helpers\MyHelper::en2bn(App\Helpers\MyHelper::moneyFormatBD($c->amount)) }} <br>
                      চালান নং: {{ App\Helpers\MyHelper::en2bn($c->challan_no) }} <br>
                      তারিখ: {{ App\Helpers\MyHelper::en2bn(date('d-m-Y', strtotime($c->challan_date))) }} <br>
                  </p>
                @endforeach
              </td>
            </tr>
            @php $i++ @endphp
            @endforeach
          </tbody>
        </table>          		
	</div>	
</body>
</html>