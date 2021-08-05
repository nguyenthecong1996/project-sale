@extends('layouts.layout_admin')
@section('breadcrumb')
<div class="row">
    <div class="col-5 align-self-center">
        <div class="d-flex align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <!-- Column -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if(Auth::user()->role_status == 9)
                    <div class="mb-3 d-flex justify-content-end">
                        <a class="btn btn-info" href="#" id="createProduct" role="button" data-toggle="modal" data-target="#staff" class="model_img img-fluid"><i class="fas fa-plus-circle"></i> Create New</a>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table user-overview" id="users-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>SĐT</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="staff" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
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
                            <form class="form-horizontal" id="staffForm">
                                <input type="hidden" name="staff_id" id="staff_id">
                                <input type="hidden" name=" is_store" id="is_store">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staff_code">Mã nhân viên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Mã nhân viên" id="staff_code" name="user_code">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staff_name">Họ và tên <span class="text-danger">*</span></label>
                                            <input type="text" id="staff_name" class="form-control" placeholder="Name" name ="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="staff_account">Tài khoản <span class="text-danger">*</span></label>
                                            <input type="text" id="staff_account" class="form-control" placeholder="Account" name ="account">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email<span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" placeholder="Email" id="staff_email" name = "email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input type="text" class="form-control" placeholder="Phone" id="staff_phone" name = "phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Vai trò</label>
                                            <input type="text" class="form-control" placeholder="Phone" value="STAFF" id="roles" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3" id="staff_image_gr">
                                    <h5 class="card-title m-t-20">Upload Image</h5>
                                    <div class="el-element-overlay">
                                        <div class="el-card-item" style="padding-bottom: 0">
                                            <div class="el-card-avatar el-overlay-1" id="show_image"> <img src="https://www.riobeauty.co.uk/images/product_image_not_found" alt="staff" id="preview-image"/>
                                                <div class="el-overlay">
                                                    <ul class="list-style-none el-info">
                                                        <li id= "detele_image"><i class="fas fa-times"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn btn-info waves-effect waves-light" id="choose_image"><span>Upload Anonther Image</span>
                                        <input type="file" class="upload" id="staff_image" name="image"> 
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" id="saveBtn" class="btn btn-success waves-effect text-left">Save</button>
                                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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

    $(document).on('change','#staff_image',function(){	
        let reader = new FileReader();
        reader.onload = (e) => { 
            $('#preview-image').attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
    
    });

    $(document).on('click','#detele_image',function(){	
        $(this).parents('#staff_image_gr').find('#choose_image').html('<span>Upload Anonther Image</span> <input type="file" class="upload" id="staff_image" name="image">');
        $(this).parents('#staff_image_gr').find('#show_image').html('<img src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" alt="user" id="preview-image"/><div class="el-overlay"><ul class="list-style-none el-info"><li id= "detele_image"><i class="fas fa-times"></i></li></ul></div>');
    });
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        scrollY: false,
        ajax: "{{ route('users.index') }}",
        columns: [
            {
                "width":'5%',
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": '<i class="fas fa-angle-right"></i>'
            },
            {data: 'DT_RowIndex', name: 'DT_RowIndex', width:'5%'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
        ],
        columnDefs : [
            { targets: 0, sortable: false},
        ],
        order: [[ 1, "asc" ]]
    });
    
    $('body').on('click', '.editStaff', function () {
        $('#saveBtn').html("Update");
        $(".print-error-msg").find("ul").html('');
        $("#staff_code").prop('disabled', true);
        $(".print-error-msg").css('display','none');
        $("#is_store").val('edit')
        var staff_id = $(this).data('id');
        $.ajax({
            url: "users/"+staff_id+"/edit",
            method: 'GET',
            success: function(result) {
                $('#staff').modal('show');
                $('#staff_id').val(result.id);
                $('#staff_code').val(result.code_user);
                $('#staff_name').val(result.name);
                $('#staff_account').val(result.account);
                $('#staff_email').val(result.email);
                $('#staff_phone').val(result.phone);
                $('#preview-image').attr('src',result.image);
                $('#roles').val('STAFF')
                if(result.role_status == 9) {
                    $('#roles').val('ADMIN')
                }
            }
        });
    });

    $('#createProduct').click(function () {
        $('#saveBtn').html("Save");
        $("#is_store").val('create')
        $('#staff_id').val('');
        $("#staff_code").prop('disabled', false);
        $('#staffForm').trigger("reset");
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','none');
        $('#preview-image').attr('src', 'https://www.riobeauty.co.uk/images/product_image_not_found.gif');
    });

    $('#staffForm').submit(function(e) {
        e.preventDefault();
       let formData = new FormData(this);
        $.ajax({
            data: formData,
            url: "{{ route('users.store') }}",
            type: "POST",
            contentType: false,
            processData: false,
            success: function (data) {
                $('#staff').modal('hide');
                $('#staffForm').trigger("reset");
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);

                printErrorMsg(data.responseJSON.errors)
                $('#staff').modal('show');
            }
        });
    });

    $('body').on('click', '.deleteStaff', function (){
        var staff_id = $(this).data("id");
        var result = confirm("Are You sure want to delete !");
        if(result){
            $.ajax({
                type: "DELETE",
                url: "users/"+staff_id+"/delete",
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

    $('#users-table tbody').on('click', 'tr', function () {
        var myself = $(this);
        openDetail(myself);
    });

    function format ( d ) {
            return `<div class="row">
                    <!-- Column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body blackground-detail">
                                <h3 class="card-title row">
                                    <div class="col-lg-6">${d['name']}</div>
                                        <div class="col-lg-6 d-flex justify-content-end">
                                            ${d['auth_role'] == 9 || d['id'] ==  d['auth_id']? 
                                                `<a href="javascript:void(0)" data-id="${d['id']}" class="text-inverse p-r-10 editStaff" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-marker-alt"></i> </a>`
                                            : ''}
                                            ${d['auth_role'] == 9 &&  d['id'] != d['auth_id']? 
                                                `<a href="javascript:void(0)" data-id="${d['id']}" class="text-inverse deleteStaff" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash"></i></a>`
                                            : ''}
                                        </div>
                                </h3>
                                <h6 class="card-subtitle">globe type chair for rest</h6>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6">
                                        <div class="white-box text-center"> <img src="${d['image']}" width = "100%" class="img-responsive"> </div>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-6">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h3 class="box-title m-t-40">General Info</h3>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td width="390">Mã nhân viên</td>
                                                        <td> ${d['code_user']} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td> ${d['email']} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Số điện thoại</td>
                                                        <td> ${d['phone'] ? d['phone'] : ''} </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- Column -->
            </div>`
        }
</script>
@endpush