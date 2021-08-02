@extends('layouts.layout_admin')
@section('breadcrumb')
<div class="row">
    <div class="col-5 align-self-center">
        <div class="d-flex align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product</li>
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
                <div class="mb-3 d-flex justify-content-end">
                    <a class="btn btn-info" href="#" id="createProduct" role="button" data-toggle="modal" data-target="#product" class="model_img img-fluid"><i class="fas fa-plus-circle"></i> Create New</a>
                </div>
                <div class="table-responsive">
                    <table class="table product-overview" id="product-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>STT</th>
                                <th>Mã</th>
                                <th>Tên</th>
                                <th>Mô tả</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Hình ảnh</th>
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

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="product" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
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
                            <form class="form-horizontal" id="productForm">
                                <input type="hidden" name="product_id" id="product_id">
                                <div class="form-group">
                                    <label for="product_code">Mã sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Mã sản phẩm" id="code_product" name="code_product">
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" id="product_name" class="form-control" placeholder="Name" name ="name">
                                </div>
                                <div class="form-group">
                                    <label>Giá bán<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Giá bán" id="product_price" name = "price">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Số lượng</label>
                                            <input type="text" class="form-control" placeholder="Số lượng" id="product_quantity" name = "quantity">
                                        </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Đơn vị</label>
                                            <select class="form-control custom-select" name= "unit" id="product_unit">
                                                <option value="">--Select your Unit--</option>
                                                <option value="1">Chiếc </option>
                                                <option value="2">Bộ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--/span-->
                                </div>
                                <div class="col-md-3" id="product_image_gr">
                                    <h5 class="card-title m-t-20">Upload Image</h5>
                                    <div class="el-element-overlay">
                                        <div class="el-card-item" style="padding-bottom: 0">
                                            <div class="el-card-avatar el-overlay-1" id="show_image"> <img src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" alt="user" id="preview-image"/>
                                                <div class="el-overlay">
                                                    <ul class="list-style-none el-info">
                                                        <li id= "detele_image"><i class="fas fa-times"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn btn-info waves-effect waves-light" id="choose_image"><span>Upload Anonther Image</span>
                                        <input type="file" class="upload" id="product_image" name="image"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea class="form-control" rows="5" name="description" id="product_description"></textarea>
                                </div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" value="1" name = "status" checked>
                                    <label class="custom-control-label" for="customSwitch1">Active</label>
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

    $(document).on('change','#product_image',function(){	
        let reader = new FileReader();
        reader.onload = (e) => { 
            $('#preview-image').attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
    
    });

    $(document).on('click','#detele_image',function(){	
        $(this).parents('#product_image_gr').find('#choose_image').html('<span>Upload Anonther Image</span> <input type="file" class="upload" id="product_image" name="image">');
        $(this).parents('#product_image_gr').find('#show_image').html('<img src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" alt="user" id="preview-image"/><div class="el-overlay"><ul class="list-style-none el-info"><li id= "detele_image"><i class="fas fa-times"></i></li></ul></div>');
    });
    var table = $('#product-table').DataTable({
        processing: true,
        serverSide: true,
        scrollY: false,
        ajax: "{{ route('products.index') }}",
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": '<i class="fas fa-angle-right"></i>'
            },
            {data: 'DT_RowIndex', name: 'DT_RowIndex', width:'5%'},
            {data: 'code_product', name: 'code_product', width:'10%'},
            {data: 'name', name: 'name', width:'15%'},
            {data: 'description', name: 'description', width:'20%'},
            {data: 'price', name: 'price', width:'10%'},
            {data: 'quantity', name: 'quantity', width:'10%'},
            {data: 'image', name: 'image', width:'20%', className: 'text-center align-middle',
                render: function (data) {
                    return data ? `<img src="${data}"  width="50"/>` : '<img src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"  width="80"/>';
                }
            },
        ],
        columnDefs : [
            { targets: 0, sortable: false},
        ],
        order: [[ 1, "asc" ]]
    });
    
    $('body').on('click', '.editProduct', function () {
        $('#saveBtn').html("Update");
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','none');
        var product_id = $(this).data('id');
        $.ajax({
            url: "products/"+product_id+"/edit",
            method: 'GET',
            success: function(result) {
                $('.bs-example-modal-lg').modal('show');
                $('#product_id').val(result.id);
                $('#code_product').val(result.code_product);
                $('#product_name').val(result.name);
                $('#product_price').val(result.price);
                $('#product_quantity').val(result.quantity);
                $('#product_unit').val(result.unit);
                $('#product_description').val(result.description);
                $('#preview-image').attr('src', result.image);
                
                // result.status == 1 ? $('#customSwitch1').prop('checked', true) : $('#customSwitch1').prop('checked', false);
            }
        });
    });

    $('#createProduct').click(function () {
        $('#saveBtn').html("Save");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','none');
        $('#preview-image').attr('src', 'https://www.riobeauty.co.uk/images/product_image_not_found.gif');
    });

    $('#productForm').submit(function(e) {
        e.preventDefault();
       let formData = new FormData(this);
        $.ajax({
            data: formData,
            url: "{{ route('products.store') }}",
            type: "POST",
            contentType: false,
            processData: false,
            success: function (data) {
                $('#customer').modal('hide');
                $('#productForm').trigger("reset");
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
        var product_id = $(this).data("id");
        var result = confirm("Are You sure want to delete !");
        if(result){
            $.ajax({
                type: "DELETE",
                url: "products/"+product_id+"/delete",
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

    $('#product-table tbody').on('click', 'tr', function () {
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
                                        <a href="javascript:void(0)" data-id="${d['id']}" class="text-inverse p-r-10 editProduct" data-toggle="tooltip" title="" data-original-title="Edit"><i class="ti-marker-alt"></i> </a>
                                        <a href="javascript:void(0)" data-id="${d['id']}" class="text-inverse deleteProduct" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash"></i></a>
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
                                                        <td width="390">Mã sản phẩm</td>
                                                        <td> ${d['code_product']} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Số lượng</td>
                                                        <td> ${d['quantity']} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Đơn vị</td>
                                                        <td> ${d['unit'] == 1 ? "Chiếc": "Bộ"} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Giá bán</td>
                                                        <td> ${d['price']} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mô tả</td>
                                                        <td> ${d['description']} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ngày tạo</td>
                                                        <td> ${d['updated_at']} </td>
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