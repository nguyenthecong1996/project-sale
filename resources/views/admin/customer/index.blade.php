@extends('layouts.layout_admin')
@section('breadcrumb')
<div class="row">
    <div class="col-5 align-self-center">
        <div class="d-flex align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Customer</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="mb-3 d-flex justify-content-end">
                    <a class="btn btn-info" href="#" id="createCustomer" role="button" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-fluid"><i class="fas fa-plus-circle"></i> Create New</a>
                </div>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã khách hàng</th>
                                <th>Họ tên</th>
                                <th>Địa chỉ</th>
                                <th>Số điện thoại</th>
                                <th>Kích hoạt</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>STT</th>
                                <th>Mã khách hàng</th>
                                <th>Họ tên</th>
                                <th>Địa chỉ</th>
                                <th>Số điện thoại</th>
                                <th>Kích hoạt</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" id="customer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Tạo khách hàng</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        <div class="card card-body">
                            <form class="form-horizontal" id="customerForm">
                                <input type="hidden" name="customer_id" id="customer_id">
                                <div class="form-group">
                                    <label>Mã khách hàng <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Mã nhân viên" id="example-code" name="customer_code">
                                </div>
                                <div class="form-group">
                                    <label for="example-name">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" id="example-name" class="form-control" placeholder="Name" name ="name">
                                </div>
                                <div class="form-group">
                                    <label>Số  điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Số điện thọai" id="example-phone" name = "phone">
                                </div>
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text" class="form-control" placeholder="Địa chỉ" id="example-address" name = "adrress">
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" value="1" name = "status" checked>
                                    <label class="custom-control-label" for="customSwitch1">Active</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="saveBtn" class="btn btn-success waves-effect text-left">Save</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection
@push('scripts')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    var table = $('#zero_config').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('customers.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'customer_code', name: 'customer_code'},
            {data: 'name', name: 'name'},
            {data: 'address', name: 'address'},
            {data: 'phone', name: 'phone'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
    $('body').on('click', '.editProduct', function () {
        $('#saveBtn').html("Update");
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','none');
        var customer_id = $(this).data('id');
        $.ajax({
            url: "customers/"+customer_id+"/edit",
            method: 'GET',
            success: function(result) {
                $('.bs-example-modal-lg').modal('show');
                $('#customer_id').val(result.id);
                $('#example-code').val(result.customer_code);
                $('#example-name').val(result.name);
                $('#example-phone').val(result.phone);
                $('#example-address').val(result.address);

                result.status == 1 ? $('#customSwitch1').prop('checked', true) : $('#customSwitch1').prop('checked', false);
            }
        });
    });

    $('#createCustomer').click(function () {
        $('#saveBtn').html("Save");
        $('#customer_id').val('');
        $('#customerForm').trigger("reset");
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','none');
    });

    $('#saveBtn').click(function () {
        $.ajax({
            data: $('#customerForm').serialize(),
            url: "{{ route('customers.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#customer').modal('hide');
                $('#customerForm').trigger("reset");
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);

                printErrorMsg(data.responseJSON.errors)
                $('#customer').modal('show');
            }
        });
    });

    $('body').on('click', '.deleteProduct', function (){
        var customer_id = $(this).data("id");
        var result = confirm("Are You sure want to delete !");
        if(result){
            $.ajax({
                type: "DELETE",
                url: "customers/"+customer_id+"/delete",
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }else{
            return false;
        }
    });
</script>
@endpush