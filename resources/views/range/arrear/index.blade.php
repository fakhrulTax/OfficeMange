@extends('app')

@section('title', 'Arrear')
@push('css')
@endpush


@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-2">
                <h1 class="m-0">Select Circle</h1>
            </div>

         @php
            $range  = Auth::user()->range;
            $ranges =  \App\Helpers\MyHelper::rangWiseCircle($range);

         @endphp



            <div class="col-sm-4">
                <form action="" method="POST">
                    @csrf
                    <select name="circle" id="circle" class="form-control" >
                        <option value="all">All </option>


                        @foreach ($ranges as $key => $range)
                            <option value="{{$range}}">Circle {{$range}}</option>
                        @endforeach
                        

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
                    url: "{{ url('range/arrears/sort') }}"+'/' + circle,
                    success: function(data) {
                       
                        $('.arrear').html(data.GrandArrear);
                        $('.disputed').html(data.TotalDisputedArrear);
                        $('.undisputed').html(data.TotalUndisputedArrear);
                      

                    }


                });
                

            });


      
    });

</script>
@endpush
