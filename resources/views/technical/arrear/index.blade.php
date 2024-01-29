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
                        <option value="1">Circle 1</option>
                        <option value="2">Circle 2</option>
                        <option value="3">Circle 3</option>
                        <option value="4">Circle 4</option>
                        <option value="5">Circle 5</option>
                        <option value="6">Circle 6</option>
                        <option value="7">Circle 7</option>
                        <option value="8">Circle 8</option>
                        <option value="9">Circle 9</option>
                        <option value="10">Circle 10</option>
                        <option value="11">Circle 11</option>
                        <option value="12">Circle 12</option>
                        <option value="13">Circle 13</option>
                        <option value="14">Circle 14</option>
                        <option value="15">Circle 15</option>
                        <option value="16">Circle 16</option>
                        <option value="17">Circle 17</option>
                        <option value="18">Circle 18</option>
                        <option value="19">Circle 19</option>
                        <option value="20">Circle 20</option>
                        <option value="21">Circle 21</option>
                        <option value="22">Circle 22</option>
                  
                        

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
                    url: "{{ url('technical/arrears/sort') }}"+'/' + circle,
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
