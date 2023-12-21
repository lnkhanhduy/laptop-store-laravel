@extends('admin_layout')
@section('admin_content')

<div class="card h-100 ">
    <div class="card-header position-relative">
        Thư viện ảnh sản phẩm
        <div class="position-absolute" style="right: 10px">
            <a class="btn btn-primary" href="{{URL::to('/admin/product')}}">Quay lại</a>
        </div>
    </div>
    <div class="card-body h-100 overflow-auto">
        <form class="needs-validation " id="form-gallery" novalidate>
            <input type="hidden" name="product_id" value="">
            <div class="d-flex justify-content-center w-100">
                <div class="w-50 w-md-100 d-flex justify-content-center">
                    <div class="form-group">
                        <input type="file" name="gallery-file" class="form-control" id="gallery-file" placeholder=""
                            accept="image/*" multiple required>
                        <div class="invalid-feedback">
                            Vui lòng chọn hình ảnh!
                        </div>
                    </div>
                    <div class="form-group ms-1">
                        <input type="submit" id="btn-submit-gallery-file" class="btn btn-success" value="Thêm ảnh">
                    </div>
                </div>
            </div>
        </form>
        <div id="notification-no-gallery" class="text-warning p-2 text-center mt-2" style="font-size: 20px"></div>
        <input type="hidden" name="product_slug" value="{{ $product_slug }}" id="gallery_product_slug">
        <div class="table-responsive mt-2 ">
            <table class="table table-bordered table-striped b-t b-light table-hover">
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th></th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody id="tbody-gallery">

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('admin_script')
<script type="text/javascript">
    $(document).ready(function() {
        document.title = "Admin - Thư viện ảnh sản phẩm";
        const gallery_product_slug = $('#gallery_product_slug').val();
        get_all_gallery();

        $('#form-gallery').on('submit', function(e) {
            e.preventDefault();
            let files = $('#gallery-file')[0].files;

            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                add_gallery(files, gallery_product_slug);
            }
        });

        $(document).on('submit', '.form-edit-gallery', function(e) {
            e.preventDefault();
            $(this).addClass('was-validated');
            if (this.checkValidity() === false) {
                e.stopPropagation();
            } else {
                let gallery_id = $(this).closest('tr').data('gallery-id');
                let gallery_image = $('#gallery-file-' + gallery_id)[0].files[0];
                update_gallery(gallery_image, gallery_id);
            }
        })

        $(document).on('click', '.btn-delete-gallery', function() {
            let gallery_id = $(this).closest('tr').data('gallery-id');
            show_modal_confirm_delete('Bạn muốn xóa gallery này', 'data-gallery-id', gallery_id);
        });

        $('#btn-submit-confirm-delete').click(function() {
            let gallery_id = $(this).data('gallery-id');
            delete_gallery(gallery_id);
        })

        $('#gallery-file').change(function() {
            let error = "";
            let files = $(this)[0].files;
            if (files.length > 5) {
                error = "Tối đa 5 hình ảnh";
            } else {
                for (let i = 0; i < files.length; i++) {
                    if (files[i].size > 2000000) {
                        error = "File không được lớn hơn 2MB";
                        break;
                    }
                }
            }

            if (error != "") {
                $('#form-gallery').removeClass('was-validated');
                $('#gallery-file').removeClass('is-valid');
                $('#gallery-file').addClass('is-invalid');
                $('#gallery-file').next().text(error);
                $('#btn-submit-gallery-file').prop('disabled', true);
                error = '';
            } else {
                $('#form-gallery').removeClass('was-validated');
                $('#gallery-file').addClass('is-valid');
                $('#gallery-file').removeClass('is-invalid');
                $('#gallery-file').next().text(error);
                $('#btn-submit-gallery-file').prop('disabled', false);
            }
        });

        function get_all_gallery() {
            $.ajax({
                url: `{{URL::to('/admin/get-all-gallery/${gallery_product_slug}')}}`,
                method: "GET",
                success: function(data) {
                    if (data.status == 200 && data.data.length > 0) {
                        $('#tbody-gallery').empty();
                        $('#notification-no-gallery').text('')

                        $.each(data.data, function(key, value) {
                            $('#tbody-gallery').append(`
                                <tr class="text-center" data-gallery-id="${value.gallery_id}">
                                    <td class="col-sm-1">${key+1}</td>
                                    <td class="row">
                                        <img class="col-md-5" style="width: 200px;height: 150px;object-fit: contain" src="{{URL::to('/public/uploads/gallery/${value.gallery_image}')}}">
                                        <form class="needs-validation col-md-7 d-flex justify-content-center align-items-center form-edit-gallery" novalidate>
                                            <div class="form-group position-relative">
                                                <input class="form-control " type="file" id="gallery-file-${value.gallery_id}" accept="image/*" required>
                                                    <div class="invalid-feedback position-absolute left-0">
                                                        Vui lòng chọn hình ảnh!
                                                    </div>
                                            </div>
                                            <button type="submit" class="btn btn-md btn-success ms-1">Cập nhật</button>
                                        </form>
                                    </td>
                                    <td class="col-sm-1">
                                        <a type="button" class="btn-delete-gallery" >
                                            <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            `);
                        })
                    } else {
                        $('#tbody-gallery').empty();
                        $('#notification-no-gallery').text('Chưa có gallery hình ảnh cho sản phẩm!')
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }


        function add_gallery(gallery_image, product_slug) {
            let formData = new FormData();
            formData.append('product_slug', product_slug);
            for (let i = 0; i < gallery_image.length; i++) {
                formData.append('gallery_image[]', gallery_image[i]);
            }

            $.ajax({
                url: "{{URL::to('/admin/add-gallery')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        $('#gallery-file').val('');
                        $('#form-gallery').removeClass('was-validated');
                        $('#gallery-file').removeClass('is-valid');
                        get_all_gallery();
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                },
                error: function(error) {
                    if (error.status == 422) {
                        if (error.responseJSON.errors.gallery_slug) {
                            show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                                error.responseJSON.errors.gallery_slug[0], 'danger');
                        }
                    } else {
                        console.error(error);
                    }
                }
            })
        }

        function update_gallery(gallery_image, gallery_id) {
            let formData = new FormData();
            formData.append('gallery_id', gallery_id);
            formData.append('gallery_image', gallery_image);

            $.ajax({
                url: "{{URL::to('/admin/edit-gallery')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        get_all_gallery();
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                            data.message, 'danger');
                    }
                },
                error: function(error) {
                    if (error.status == 422) {
                        if (error.responseJSON.errors.gallery_slug) {
                            show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>',
                                error.responseJSON.errors.gallery_slug[0], 'danger');
                        }
                    } else {
                        console.error(error);
                    }
                }
            })
        }

        function delete_gallery(gallery_id) {
            $.ajax({
                url: "{{URL::to('/admin/delete-gallery')}}",
                method: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    gallery_id,
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_alert('<i class="fa-solid fa-circle-check me-2"></i>',
                            data.message, 'success');
                        $('#modal-confirm-delete').modal('hide');
                        get_all_gallery();
                    } else {
                        show_alert('<i class="fa-solid fa-circle-xmark me-2"></i>', data.message,
                            'danger');
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            })
        }
    });
</script>
@endsection