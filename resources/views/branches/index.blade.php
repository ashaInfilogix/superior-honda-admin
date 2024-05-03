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
                                    <h5>Branches</h5>
                                    <div class="float-right">
                                        <a href="{{ route('branches.create') }}" class="btn btn-primary btn-md">Add Branch</a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="dt-responsive table-responsive">
                                        <table id="vehicle-types-list" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Unique Code</th>
                                                    <th>Name</th>
                                                    <th>Address</th>
                                                    <th>Pincode</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($branches as $key => $branch)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $branch->unique_code }}</td>
                                                        <td>{{ $branch->name }}</td>
                                                        <td>{{ $branch->address }}</td>
                                                        <td>{{ $branch->pincode }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('branches.edit', $branch->id) }}"
                                                                    class="btn btn-primary waves-effect waves-light mr-2">
                                                                    <i class="feather icon-edit m-0"></i>
                                                                </a>
                                                                <button data-source="Branch" data-endpoint="{{ route('branches.destroy', $branch->id) }}"
                                                                    class="delete-btn btn btn-danger waves-effect waves-light">
                                                                    <i class="feather icon-trash m-0"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('head')
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.bootstrap4.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery.datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.responsive.min.js') }}"></script>

    <script>
        $(function() {
            $('#vehicle-types-list').DataTable();
        })
    </script>
@endsection
