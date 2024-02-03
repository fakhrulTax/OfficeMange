@extends('app')

@section('title', 'Stock View')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">View Stock</h1>
            </div>
           
        </div>
    </div>

</div>

<section class="content">

    <div class="row">
        <div class="col-md-6">

    

            <div class="card bg-success">
                <div class="card-header">
                
                  <h3>  TIN: {{$stock->tin}}</h3>
                
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <h5 class=" ">Name: {{$stock->name}}</h5>
                    @if($stock->bangla_name)
                    <h5>Name: {{$stock->bangla_name}}</h5>
                    @endif
                  
                  <h5>  Mobile Number: {{$stock->mobile}}</h5>
                  <h5>  Address:   {{ str_replace('</p><p>', ', ', strip_tags($stock->address)) }}</h5>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button  type="button" onclick="edit({{ $stock->id }})" class="btn bg-light">Edit Infomation</button>
                </div>
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->

        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 >Notice</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-success" data-toggle="modal" data-target="#oneEightyThree">183(3)</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>





<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit A Tax Payer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">



                

                {{-- Edit Form load here from ajax --}}

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateBtn">Update changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@include('circle.stock.modal.one_eighty_three');


@endsection




@push('js')
<script>

function edit(id) {
            $.ajax({
                url: "{{ route('circle.stockEditByid') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(data) {


                    $('#editModal').modal('show');
                    $('#editModal').find('.modal-body').html(data);
                }


            })
        }



        $(document).ready(function() {
            $('#updateBtn').on('click', function() {
                $data = $('#edit-tax-form').serialize();
                $.ajax({
                    url: "{{ route('circle.stockUpdateByid') }}",
                    type: "POST",
                    data: $data,
                    success: function(data) {
                        if (data.status != 200) {


                            $('.error').text(data.message);

                        } else {
                            
                            $.toast({
                                heading: "Success",
                                text: "Tax Payer Updated successfully",
                                position: "top-right",
                                loaderBg: "#5ba035",
                                icon: "success",
                                hideAfter: 3e3,
                                stack: 1,

                            }) ;

                            $('#editModal').modal('hide');
                            $('#edit-tax-form')[0].reset();
                            $('.error').text('');
                            location.reload();

                        }
                    }
                })
            })
        })


    
</script>
    
@endpush