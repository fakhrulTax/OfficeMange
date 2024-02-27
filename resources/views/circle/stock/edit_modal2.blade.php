<div class="col-12">
    <p class="text-danger error">

    </p>
</div>

<form action="" method="POST" id="edit-tax-form">
    @csrf
    <div class="row">

        <input type="text" name="id" value="{{ $StockInfo->id }}" hidden="hidden">

        <div class="col-md-6">
            <div class="form-group">
                <label for="tin">TIN Number</label>
                <input type="number" class="form-control"
                    value="{{ $StockInfo->tin }}" readonly >
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" readonly
                    value="{{ $StockInfo->name }}">
            </div>
        </div>
       

        <div class="col-md-6">
            <div class="form-group">
                <label for="bangla_name">Bangla Name</label>
                <input type="text" class="form-control" id="bangla_name" name="bangla_name"
                    value="{{ $StockInfo->bangla_name }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="tel" class="form-control" id="mobile" name="mobile"
                    value="{{ $StockInfo->mobile }}">
            </div>
        </div>  




        <div class="col-md-6">
            <div class="form-group">
                <label for="address_line_one">Address</label>

                <input type="text" class="form-control" id="address_line_one"
                    name="address_line_one" value="{{ $StockInfo->address_line_one }}" id="address1" placeholder="Address line one">

                <input type="text" class="form-control mt-1" id="address_line_two"
                    name="address_line_two" value="{{ $StockInfo->address_line_two }}" id="address2" placeholder="Address line two">


                <input type="text" class="form-control mt-1" id="address_line_three"
                    name="address_line_three"  value="{{ $StockInfo->address_line_three }}"id="address3" placeholder="Address line three">

            </div>
        </div>



    </div>
</form>
