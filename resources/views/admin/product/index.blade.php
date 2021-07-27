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
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <div class="mb-3 d-flex justify-content-end">
                    <a class="btn btn-info" href="#" id="createProduct" role="button" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-fluid"><i class="fas fa-plus-circle"></i> Create New</a>
                </div>
                <div class="table-responsive">
                    <table id="product-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã Sản phẩm</th>
                                <th>Tên</th>
                                <th>Mô tả</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Hình ảnh</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>STT</th>
                                <th>Mã Sản phẩm</th>
                                <th>Tên</th>
                                <th>Mô tả</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Hình ảnh</th>
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
                                <div class="form-group">
                                    <label>Hình ảnh<span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control" id="product_image" name="image">
                                      </div>               
                                      <div class="col-sm-6 mt-2 d-flex justify-content-center">
                                        <img id="preview-image" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                              alt="preview image" style="max-height: 250px;">
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

    $('#product_image').change(function(){   
        let reader = new FileReader();
        reader.onload = (e) => { 
            $('#preview-image').attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
    
    });
    var table = $('#product-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('products.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'code_product', name: 'code_product'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'price', name: 'price'},
            {data: 'quantity', name: 'quantity'},
            {data: 'image', name: 'image'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
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
</script>
@endpush