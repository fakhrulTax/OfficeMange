@extends('app')

@section('title', 'Daily Report')

@section('content')

<div class="content-header">

    <div class="container-fluid">
        <div class="row mb-2">

            <div class="col-sm-6">
                <h1 class="m-0">Add Daily Report</h1>
            </div>



            <div class="col-md-6">

            </div>



        </div>

    </div>



</div>



<div class="card">

    <div class="card-body">



        <form action="{{ route('circle.daily.store') }}" method="POST">

            @csrf     

            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="issue_date">Report Date</label>
                        <input type="text" class="form-control" id="issue_date" placeholder="dd-mm-yyyy" name="issue_date" value="{{ old('issue_date') }}" autocomplete="off" required>
                        @error('issue_date')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                    </div>
                </div> 

                @foreach ($types as $index => $type)

                <div class="col-md-4">
                    <div class="form-group">
                        <h6 class="text-default">{{ $type }}</h6>
                    </div>
                </div>     

                <!-- Number Field -->
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="number" oninput="sum('{{ $type }}', this, 'total_number')" id="number_{{ $index }}" name="types[{{ $index }}][number]" placeholder="Number" class="form-control" value="{{ old('types.' . $index . '.number') }}" required>
                        @error("types.$index.number")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>  

                <!-- Total Number Field -->
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="number" id="total_number_{{ $index }}" name="types[{{ $index }}][total_number]" placeholder="Total Number" class="form-control" value="{{ old('types.' . $index . '.total_number') ?? ($lastReports[$type]->total_number ?? 0) }}" required>
                        @error("types.$index.total_number")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                 <!-- Collection Field -->
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="number" oninput="sum('{{ $type }}', this, 'total_collection')" id="collection_{{ $index }}" name="types[{{ $index }}][collection]" placeholder="Collection" class="form-control" value="{{ old('types.' . $index . '.collection') }}" required>
                        @error("types.$index.collection")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Total Collection Field -->
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="number" id="total_collection_{{ $index }}" name="types[{{ $index }}][total_collection]" placeholder="Total Collection" class="form-control" value="{{ old('types.' . $index . '.total_collection') ?? ($lastReports[$type]->total_collection ?? 0) }}" required>
                        @error("types.$index.total_collection")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @endforeach



                <div class="col-md-12 mt-4">

                    <input type="submit" value="Submit Report" class="btn btn-primary mt-2">

                </div>



            </div>



        </form>

 

    </div>

</div>







@endsection





@push('js')



<script>
 function sum(type, inputField, fieldType) {
    const lastReports = @json($lastReports);
    const inputValue = parseInt(inputField.value, 10) || 0;

    // Default to 0 if the report does not exist
    const lastFieldValue = lastReports[type] ? lastReports[type][fieldType] : 0;

    // Calculate the new total
    const newTotal = lastFieldValue + inputValue;

    // Determine the correct total field based on fieldType
    const totalFieldId = fieldType === 'total_number' ? 'total_number_' : 'total_collection_';
    const totalField = document.querySelector(`#${totalFieldId}${inputField.id.split('_')[1]}`);
    
    // Update the total field with the new value
    if (totalField) {
        totalField.value = newTotal;
    }
}


</script>





    

@endpush