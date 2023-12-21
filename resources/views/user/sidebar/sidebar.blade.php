<div>
    <div>
        <h2 class="text-title">Danh mục sản phẩm</h2>
        <div class="accordion" id="sidebar-category-accordion">
        </div>
    </div>

    <div class="mt-5">
        <h2 class="text-title">Thương hiệu sản phẩm</h2>
        <div class="accordion" id="sidebar-brand-accordion">
        </div>
    </div>
</div>

@section('script-sidebar')
<script type="text/javascript">
    $(document).ready(function() {
        load_category_product();
        load_brand();

        function load_category_product() {
            $.ajax({
                type: "GET",
                url: "{{URL::to('/load-category-product-user')}}",
                success: function(data) {
                    if (data.status == 200) {
                        $('#sidebar-category-accordion').empty();
                        let list_category_has_sub = [];
                        $.each(data.data, function(key, value) {
                            if (value.category_product_parent == 0) {
                                $.each(data.data, function(index, item) {
                                    if (item.category_product_parent == value
                                        .category_product_id) {
                                        list_category_has_sub.push(value
                                            .category_product_id);
                                    }
                                });
                            }
                        });

                        $.each(data.data, function(key, value) {
                            if (value.category_product_parent == 0 && !list_category_has_sub
                                .includes(value.category_product_id)) {
                                $('#sidebar-category-accordion').append(`
                                    <div class="accordion-item no-child">
                                        <h2 class="accordion-header">
                                            <a href="{{URL::to('/danh-muc-san-pham/${value.category_product_slug}')}}"
                                            class="accordion-button" type="button" >
                                            ${value.category_product_name}</a>
                                        </h2>
                                    </div>
                                `);
                            } else if (value.category_product_parent == 0 &&
                                list_category_has_sub
                                .includes(value.category_product_id)) {
                                $('#sidebar-category-accordion').append(`
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#sidebar-category-product-${value.category_product_id}" aria-expanded="true" aria-controls="sidebar-category-product-${value.category_product_id}">
                                            ${value.category_product_name}
                                        </button>
                                    </h2>
                                    <div id="sidebar-category-product-${value.category_product_id}" class="accordion-collapse collapse" data-bs-parent="#sidebar-category-accordion">
                                        <div class="accordion-body p-0 px-4 py-2" id="accordion-body-category-product-${value.category_product_id}">
                                        </div>
                                    </div>
                                `);

                                $.each(data.data, function(index, item) {
                                    if (item.category_product_parent == value
                                        .category_product_id) {
                                        $(`#accordion-body-category-product-${value.category_product_id}`)
                                            .append(`
                                            <div class="accordion-item no-child">
                                                <h2 class="accordion-header">
                                                    <a href="{{URL::to('/danh-muc-san-pham/${item.category_product_slug}')}}"
                                                    class="accordion-button" type="button" >
                                                    ${item.category_product_name}</a>
                                                </h2>
                                            </div>
                                        `);
                                    }
                                })
                            }
                        })
                    }
                }
            })
        }

        function load_brand() {
            $.ajax({
                type: "GET",
                url: "{{URL::to('/load-brand-user')}}",
                success: function(data) {
                    if (data.status == 200) {
                        $('#sidebar-brand-accordion').empty();
                        $.each(data.data, function(key, value) {
                            $('#sidebar-brand-accordion').append(`
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <a href="{{URL::to('/thuong-hieu-san-pham/${value.brand_slug}')}}" class="accordion-button" type="button">
                                            ${value.brand_name}
                                        </a>
                                    </h2>
                                </div>
                            `);
                        })
                    }
                }
            })
        }
    })
</script>
@endsection