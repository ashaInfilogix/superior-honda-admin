@extends('layouts.app')

@section('content')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Edit User</h5>
                                    <div class="float-right">
                                        <a href="{{ route('customers.index') }}" class="btn btn-primary btn-md primary-btn">
                                            <i class="feather icon-arrow-left"></i>
                                            Go Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-block">
                                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="customer_no" label="Customer Number" value="{{ old('customer_no', $customer->cus_code) }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="first_name" label="First Name" value="{{ old('first_name', $customer->first_name) }}"></x-input-text>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <x-input-text name="last_name" label="Last Name" value="{{ old('last_name', $customer->last_name) }}"></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="address" label="Address" value="{{ old('address', $customer->address) }}" ></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="email" label="Email Address" value="{{ old('email', $customer->email) }}" readonly></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="phone_number" label="Phone Number" value="{{ old('phone_number', $customer->phone_number) }}" ></x-input-text>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <x-input-text name="phone_lime" label="Phone (Lime)" value="{{ old('phone_lime', $customer->phone_lime) }}" ></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="dob">Date of Birth</label>
                                                <input type="text" name="date_of_birth" class="form-control" id="datepicker" value="{{ old('date_of_birth', $customer->date_of_birth) }}" placeholder="YYYY-MM-DD">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <x-input-text name="licence_no" label="Licence Number" value="{{ old('licence_no', $customer->licence_no) }}" ></x-input-text>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="company_info" label="Company Info" value="{{ old('company_info', $customer->company_info) }}" ></x-input-text>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="city" label="City" value="{{ old('city', $customer->city ) }}" ></x-input-text>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <x-input-text name="info" label="Info" value="{{ old('info', $customer->info) }}" ></x-input-text>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary primary-btn">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd' 
            });

            $('form').validate({
                rules: {
                    first_name: "required",
                    phone_number: "required",
                    address: "required",
                    customer_no: "required"
                },
                messages: {
                    first_name: "Please enter first name",
                    phone_number: "Please enter phone number",
                    address: "Please enter address",
                    customer_no: "Please enter customer number"
                },
                errorClass: "text-danger f-12",
                errorElement: "span",
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("form-control-danger");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass("form-control-danger");
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        })
    </script>
@endsection
