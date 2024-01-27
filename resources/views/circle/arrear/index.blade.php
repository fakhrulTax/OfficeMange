@extends('app')
@section('title',$title)
@push('css')
<style>

</style>
@endpush
@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
                @if(isset($type)  && $type == 'edit' )
                  @include('pages.Arrear.edit')
                @else
                  @include('pages.Arrear.create')
                @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if (session('success'))
                    <div class="alert text-success">
                        {{ session('success') }}
                    </div>
                  @endif    
                @if (session('danger'))
                    <div class="alert text-danger">
                        {{ session('danger') }}
                    </div>
                  @endif
                <!--SEARCH FORM  ----> 
                <form action="{{ route('arrear.search') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <input type="number" name="searchTin" placeholder="TIN" class="form-control" value="{{ (isset($search->searchTin))?$search->searchTin:'' }}">
                      </div>
                    </div>
                    <div class="col-md-2">
                     <button type="submit" class="btn btn-primary">Search</button>                    
                    </div>
                  </div>                                    
                </form> 
                <!--END SEARCH FORM  ---->  

                <div>
                  <a href="{{ route('arrear.register') }}" target="_blank" class="btn btn-primary">Register</a>
                </div>
                <!--End Register Button--->

                <table class="table table-bordered table-striped">
                    <tr>
                      <td class="col-md-0.5">ক্রমিক</td>                      
                      <td class="col-md-3">করদাতার নাম, ঠিকানা ও টিআইএন</td>                      
                      <td class="col-md-3">বকেয়া দাবি</td>                      
                      <td class="col-md-3">বকেয়া দাবি হতে আদায়</td>                      
                      <td class="col-md-2">গৃহীত কার্যক্রম/মন্তব্য</td>                   
                      <td class="col-md-0.5">নোটিশ</td>                   
                    </tr>
                    <?php $i = 1; ?>
                    @foreach( $arrears as $arrear )
                    <!-- <tr>
                         <td class="col-md-0.5">{{ $i }}</td>                      
                          <td class="col-md-3">
                            <p>{{ $arrear->stock->bangla_name }}</p>
                                {!! $arrear->stock->address !!}
                            <p>{{ $arrear->tin }}</p>   
                          </td>                      
                          <td class="col-md-3">
                                @foreach( $arrearClass->getArrear($arrear->tin) as $a )
                                    <p>
                                        <form action="{{ route('arrear.destroy', $a->id) }}" method="POST">
                                        {{ en2bn(yearSlice($a->assessment_year)) }} : {{ en2bn(moneyFormatBD($a->arrear + $a->fine))  }}
                                        <a href="{{ route('arrear.edit', $a->id) }}" class="btn btn-sm btn-primary">Edit</a> 
                                          @csrf
                                          @method('delete')
                                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure? Do You want to Delete this Item')">Del</button>
                                          </form>
                                    </p>
                                @endforeach 
                                <p style="border-top: 1px solid #010101">
                                    সর্ব মোট  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : 
                                    {{  en2bn(moneyFormatBD($arrearClass->sumArrearByTIN($arrear->tin))) }}
                                </p>                                
                          </td>        
                                        
                          <td class="col-md-3">
                          	@foreach($collection->getArrearCollectionYear($arrear->tin) as $c)
                          		<p>
                          			{{ en2bn(yearSlice($c->assessment_year)) }} : 
                          			{{ en2bn(moneyFormatBD($collection->getArrearCollectionSumByYear($arrear->tin, $c->assessment_year))) }}
                          		</p>
                          	@endforeach
                          	@if($collection->sumArrearCollectionByTIN($arrear->tin))
                          	<p style="border-top: 1px solid #010101">
                                    সর্ব মোট  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : 
                                    {{  en2bn(moneyFormatBD($collection->sumArrearCollectionByTIN($arrear->tin))) }}
                                </p>
                                @endif 
                          </td>          
                                      
                          <td class="col-md-2">
                          	 @foreach( $arrear->stock->arrears as $a  )
                            		<p> {{ $a->comments }}</p>
                          	@endforeach
                          </td>                   
                          <td class="col-md-0.5">
                          	 <button class="btn btn-sm btn-primary" onclick="arrearModal({{ $arrear->tin }})">Noice</button>
                          </td> 
                    </tr> -->
                    <?php $i++; ?>
                    @endforeach;               
                    
                    
                    
                   
                    
                    
                </table>          
                    
              </div>
              <!-- /.card-body -->  
              <div class="card-footer">
                <ul class="pagination pagination-sm m-0 float-right">
                  <!-- {{ $arrears->links("pagination::bootstrap-4") }} -->
                </ul>
              </div>

            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  @if( count($arrears) )
        @include('pages.Arrear.arrearModal')
  @endif
  @endsection

  @push('js')
<script>
  function arrearModal(tin)
  {
      document.getElementById('atin').value = tin;
      $('#arrearModal').modal('toggle');
  }
</script>
  @endpush