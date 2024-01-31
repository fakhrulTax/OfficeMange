<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Name, Address and TIN</th>
            <th>Assessment Year</th>
            <th>Arrear</th>
            <th>Fine</th>
            <th>Circle</th>

            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @php
            $i = 0
        @endphp

        @foreach ($arrears as $key => $arrear )

            <tr>
                <td>{{  $i+1 }}</td>
                <td>
                    {{ $arrear[0]->stock->name }} <br>
                    {{  str_replace('</p><p>', ', ', strip_tags($arrear[0]->stock->address)) }} <br>
                    {{ $arrear[0]->tin }}
                    </td>

                <td>

                    <table class="table table-bordered table-striped">
                        @foreach ($arrear as $key => $ar)
                        <tr>

                           
                            
                                <td>{{ App\Helpers\MyHelper::assessment_year_format($ar->assessment_year) }}</td>

                                <td>{{ $ar->arrear_type }}</td>
                                
                                <td class="text-right">{{App\Helpers\MyHelper::moneyFormatBD($ar->arrear)}}</td>

                                <td> 

                                    <button class="btn btn-danger btn-sm"
                        onclick="ArreardEdit({{ $ar->id }})" data-toggle="modal" data-target="#editModal">Edit</button>
                                </td>

                        </tr>
                        @endforeach
                        <tr> <td colspan="2" class="text-bold text-center">Total</td>

                            
                            <td class="text-bold text-right" >{{ App\Helpers\MyHelper::moneyFormatBD( $arrear->sum('arrear')) }}</td>
                            <td></td>
                        </tr>
                       

                    </table>
                    
                </td>

                <td class="text-right">
                    {{ App\Helpers\MyHelper::moneyFormatBD( $arrear->sum('arrear')) }}
                </td>

                <td class="text-right">{{ App\Helpers\MyHelper::moneyFormatBD($arrear->sum('fine')) }}</td>

                <td>Circle-{{ $arrear[0]->circle }}</td>
                <td>Notice</td>

                
            </tr>
            @php
                $i++
            @endphp
        @endforeach



        

    </tbody>
    <tfoot>
        <th colspan="3" class="text-center">Total</th>


        <th></th>
        <th class="text-right"> </th>
        <th colspan="2" class="text-right"></th>

    </tfoot>
</table>