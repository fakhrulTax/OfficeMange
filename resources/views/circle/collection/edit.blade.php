@extends('app')

@section('title','Update Collection')
@push('css')
@endpush



@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update Collection</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        
                    </ol>
                </div>
            </div>
        </div>

    </div>

    <section class="content">


        <div class="card">

            <!-- /.card-header -->
            <div class="card-body">


            <form action="{{ route('circle.collection.update', $collection->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="tin">Type</label>
                                @error('type')
                                    <div class="text text-danger">{{ $message }}</div>
                                @enderror
                                <select class="form-control" name="type" id="type" required>
                                    <option value="">Select Type</option>
                                    <option value="advance" <?php if($collection->type=='advance'){echo'selected';} ?> >Advance</option>
                                    <option value="arrear"  <?php if($collection->type=='arrear'){echo'selected';} ?> >Arrear</option>
                                    <option value="return_process"  <?php if($collection->type=='return_process'){echo'selected';} ?> >Return Process</option>
                                </select>
                            </div>
                        </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="pay_date">Payment Date</label>
                          @error('pay_date')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                          <input type="text" class="form-control" id="pay_date" placeholder="dd-mm-yyyy" name="pay_date" value="{{ date('d-m-Y', strtotime($collection->pay_date)) }}" required>
                       </div>
                      </div> 

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="tin">TIN</label>
                          @error('tin')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                          <input type="nubmer" class="form-control" id="tin" placeholder="TIN" name="tin" value="{{ $collection->tin }}" required>
                       </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="assessment_year">Assessment Year</label>
                          @error('assessment_year')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                          <input type="nubmer" class="form-control" id="assessment_year" placeholder="Assessment Year" name="assessment_year" value="{{ $collection->assessment_year }}" required>
                       </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="amount">Amount</label>
                          @error('po_challan_no')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                          <input type="number" class="form-control" id="amount" placeholder="Amount" name="amount" value="{{ $collection->amount }}" required>
                       </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="challan_no">Challan No</label>
                          @error('challan_no')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                          <input type="text" class="form-control" id="challan_no" placeholder="Challan No" name="challan_no" value="{{ $collection->challan_no }}" required>
                       </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="challan_date">Challan Date</label>
                          @error('challan_date')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                          <input type="text" class="form-control" id="challan_date" placeholder="dd-mm-yyyy" name="challan_date" value="{{ date('d-m-Y', strtotime($collection->challan_date)) }}" required>
                       </div>
                      </div> 

                <!-- /.card-body -->
                <div class="col-sm-12">
                  <button type="submit" class="btn btn-primary">Submit</button>
                <div class="col-sm-12">
              </form>
                


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>


    
@endsection



@push('js')
   
    <script>     



    </script>
@endpush