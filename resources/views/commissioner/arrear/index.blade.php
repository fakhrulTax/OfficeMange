@extends('app')

@push('css')
@endpush


@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-2">
                <h1 class="m-0">Select Circle</h1>
            </div>


            <div class="col-sm-4">
                <form action="" method="POST">
                    @csrf
                    <select name="circle" id="circle" class="form-control" >
                        <option value="all">All </option>
                       
                        @for ($i = 1; $i <= 21; $i++)

                        <option value="{{$i}}">Circle {{$i}}</option>
                            
                        @endfor
                  
                        





                    </select>
                </form>
            </div>
        </div>
    </div>

</div>



    <section class="content">

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 >Arrear: <span class="arrear">{{ $GrandArrear }}</span> Tk</h4>
                        <h4 >Disputed : <span  class="disputed">{{ $TotalDisputedArrear }}</span> Tk</h4>
                        <h4 >UnDisputed: <span class="undisputed">{{  $TotalUndisputedArrear }}</span> Tk</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="disCollection">Disputed Collection:   </h4>
                        <h4 class="undisCollection">UnDisputed Collection: </h4>
                     
                    </div>
                </div>
            </div>
        </div>


        <section class="content">


            <div class="card">
    
                <!-- /.card-header -->
                <div class="card-body">
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
    
                                                @php
                                                    $year1 = substr($ar->assessment_year, 0, 4);
                                                    $year2 = substr($ar->assessment_year, 4, 4);
                                                @endphp  
                                                
                                                    <td>{{ $year1 }} - {{ $year1 }}</td>
    
                                                    <td>{{$ar->arrear}}</td>
    
                                                    <td> 
    
                                                        <button class="btn btn-danger btn-sm"
                                            onclick="ArreardEdit({{ $ar->id }})" data-toggle="modal" data-target="#editModal">Edit</button>
                                                    </td>
    
                                                   
                                                    
                                               
                                                
                                            </tr>
                                            @endforeach
                                            <tr> <td class="text-bold">Total</td>
                                                <td class="text-bold" >{{ $arrear->sum('arrear') }}</td>
                                                <td></td>
                                            </tr>
                                           
    
                                        </table>
                                        
                                    </td>
    
                                    <td>
                                        {{ $arrear->sum('arrear') }}
                                    </td>
    
                                    <td>{{ $arrear->sum('fine') }}</td>
    
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
                            <th></th>
                            <th colspan="2"></th>
    
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        


       

    </section>
@endsection


@push('js')
<script>
    $(document).ready(function() {

        // change function for circle
            $('#circle').change(function() {
                let circle = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('commissioner/arrears/sort') }}"+'/' + circle,
                    success: function(data) {
                       
                        $('.arrear').html(data.GrandArrear);
                        $('.disputed').html(data.TotalDisputedArrear);
                        $('.undisputed').html(data.TotalUndisputedArrear);
                      

                    }


                });
                

            });

        // $('.arrear').hide();
        // $('.disputed').hide();
        // $('.undisputed').hide();
      
    });

</script>
@endpush
