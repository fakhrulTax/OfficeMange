<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style media="print">
		@page { 
				sheet-size: A4-L;
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
		table, td, th{
			border:  1px solid #000;
		}
		
	</style>
</head>
<body>
	<div>
		<table>
			<thead>
		        <tr>
		          <th>ক্রমিক</th>                      
		          <th>করদাতার নাম, ঠিকানা ও টিআইএন</th>       
		          <th>করবর্ষ</th>       
		          <th>বকেয়া দাবি</th>                      
		          <th>বকেয়া দাবি হতে আদায়</th>                      
		          <th>গৃহীত কার্যক্রম/মন্তব্য</th> 
		        </tr>
	        </thead>
            
            <tbody>
                
                   @php 
                        $i = 0; 
                        $arrearPageTotal = 0;
                        $collectionPageTotal = 0;
                    @endphp

                
                @foreach( $arrears as $tin => $arrearGroup )
                
                @php 
                    $i += 1;                           
                    $countArrear = count($arrearGroup);
                    $printedTIN = false;
                    $arrearSubTotal = 0;
                    $collectionSubTotal = 0;
                @endphp
                     @foreach( $arrearGroup as $arrear)
                    
                        <tr>
                            
                            @if(!$printedTIN)
                                <td rowspan="{{ $countArrear }}">{{ $Helper::en2bn($i) }}</td>
                                <td rowspan="{{ $countArrear }}">
                                    {{ $arrear->stock->bangla_name ? $arrear->stock->bangla_name : $arrear->stock->name }}                                    
                                    <div class="address">
                                        {!! $arrear->stock->address !!}
                                    </div>    
                                    {{ $Helper::en2bn($arrear->tin) }}                                
                                </td>

                                @php 
                                    $printedTIN = true; 
                                    
                                @endphp

                            @endif
                            
                            @php                                
                                $aCollecntion = App\Models\Collection::getArrearByTINAssessmentYear($arrear->tin, $arrear->assessment_year);
                            @endphp
                            
                            <td>{{ $Helper::en2bn($Helper::assessment_year_format($arrear->assessment_year)) }}</td>
                            <td class="text-right">{{ $Helper::en2bn($Helper::moneyFormatBD($arrear->arrear + $arrear->fine)) }}</td>
                            <td class="text-right">{{ $Helper::en2bn($Helper::moneyFormatBD($aCollecntion)) }}</td>
                            <td></td>
                            
                        </tr>
                        
                        @php
                            $arrearSubTotal += ($arrear->arrear + $arrear->fine);
                            $collectionSubTotal += $aCollecntion;
                            $arrearPageTotal += ($arrear->arrear + $arrear->fine);
                             $collectionPageTotal += $aCollecntion;
                        @endphp
                        
                    
                    @endforeach
                    
                    <tr class="bg-secondary">
                    	<td></td>
                    	<td></td>
	                    <td>মোট</td>
	                    <td>{{ $Helper::moneyFormatBD($Helper::en2bn($arrearSubTotal)) }}</td>
	                    <td class="text-right">{{ $Helper::en2bn($Helper::moneyFormatBD($collectionSubTotal)) }}</td>
	                </tr>
                
                @endforeach
                
            </tbody>
	        
	    </table>    		
	</div>	
</body>
</html>