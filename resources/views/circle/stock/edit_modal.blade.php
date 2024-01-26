


                <div class="col-12">
                    <p class="text-danger error">

                    </p>
                </div>

                <form action="" method="POST" id="edit-tax-payer-form">
                    @csrf
                    <div class="row">

                        <input type="text" name="id" value="{{ $StockInfo->id }}" hidden="hidden">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tin">TIN Number</label>
                                <input type="number" class="form-control" id="tin" name="tin"
                                    value="{{ $StockInfo->tin }}" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
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
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $StockInfo->email }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Tax Payer Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="individual" @if($StockInfo->type == 'individual') selected @endif >Individual</option>
                                    <option value="company" @if($StockInfo->type == 'company') selected @endif>Company</option>
                                </select>
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_in_stock">File In Stock</label>
                                <select name="file_in_stock" id="file_in_stock" class="form-control">
                                    <option value="1" @if($StockInfo->file_in_stock == 1) selected @endif >Yes</option>
                                    <option value="0" @if($StockInfo->file_in_stock == 0) selected @endif>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_return">Last Return Submission Year</label>
                                <input type="number" class="form-control" id="last_return" name="last_return"
                                    value="{{ $StockInfo->last_return }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_rack">File Rack</label>
                                <select name="file_rack" id="file_rack" class="form-control">
                                    <option value="1" @if($StockInfo->file_rack == 1) selected @endif>1</option>
                                    <option value="2" @if($StockInfo->file_rack == 2) selected @endif>2</option>
                                    <option value="3" @if($StockInfo->file_rack == 3) selected @endif>3</option>
                                    <option value="4" @if($StockInfo->file_rack == 4) selected @endif>4</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address_line_one">Address</label>
                                @php
                                    if($StockInfo->address){

                                    $add = explode(' | ', $StockInfo->address);

                                
                                    }
                                    
                                    

                                @endphp

                                <input type="text" class="form-control" id="address_line_one"
                                    name="address_line_one" value="{{ $add[0]??'' }}">


                                <input type="text" class="form-control mt-1" id="address_line_two"
                                    name="address_line_two" value="{{ $add[1] ??'' }}">


                                <input type="text" class="form-control mt-1" id="address_line_three"
                                    name="address_line_three"  value="{{ $add[2] ??'' }}">





                            </div>
                        </div>



                    </div>
                </form>


