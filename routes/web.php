<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthenticateAdmin;
use App\Http\Middleware\AuthenticateUser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Admin Route
Route::get('/admin/login', 'App\Http\Controllers\AdminController@show_admin_login');
Route::post('/admin/login', 'App\Http\Controllers\AdminController@login_admin');

Route::prefix('/admin')->middleware([AuthenticateAdmin::class])->group(function () {
    //Authenticate
    Route::post('/change-password', 'App\Http\Controllers\AdminController@change_password');
    Route::get('/logout', 'App\Http\Controllers\AdminController@logout_admin');

    //Statistical
    Route::get('/', 'App\Http\Controllers\StatisticalController@show_page_statistical');
    Route::post('/filter-by-date', 'App\Http\Controllers\StatisticalController@filter_by_date');
    Route::post('/filter-by-option', 'App\Http\Controllers\StatisticalController@filter_by_option');

    //Brand
    Route::get('/brand', 'App\Http\Controllers\BrandController@show_page_brand');
    Route::get('/get-all-brand', 'App\Http\Controllers\BrandController@get_all_brand');
    Route::get('/get-all-brand-by-status/{status}', 'App\Http\Controllers\BrandController@get_all_brand_by_status');
    Route::get('/search-brand/{keyword}', 'App\Http\Controllers\BrandController@search_brand');
    Route::get('/get-brand-by-id/{id}', 'App\Http\Controllers\BrandController@get_brand_by_id');
    Route::get('/active-brand/{id}', 'App\Http\Controllers\BrandController@active_brand');
    Route::get('/unactive-brand/{id}', 'App\Http\Controllers\BrandController@unactive_brand');
    Route::post('/add-brand', 'App\Http\Controllers\BrandController@add_brand');
    Route::post('/edit-brand', 'App\Http\Controllers\BrandController@edit_brand');
    Route::post('/delete-brand', 'App\Http\Controllers\BrandController@delete_brand');

    //Category product
    Route::get('/category-product', 'App\Http\Controllers\CategoryProductController@show_page_category_product');
    Route::get('/get-all-category-product', 'App\Http\Controllers\CategoryProductController@get_all_category_product');
    Route::get('/get-all-category-product-by-status/{status}', 'App\Http\Controllers\CategoryProductController@get_all_category_product_by_status');
    Route::get('/search-category-product/{keyword}', 'App\Http\Controllers\CategoryProductController@search_category_product');
    Route::get('/get-category-product-by-id/{id}', 'App\Http\Controllers\CategoryProductController@get_category_product_by_id');
    Route::get('/active-category-product/{id}', 'App\Http\Controllers\CategoryProductController@active_category_product');
    Route::get('/unactive-category-product/{id}', 'App\Http\Controllers\CategoryProductController@unactive_category_product');
    Route::post('/add-category-product', 'App\Http\Controllers\CategoryProductController@add_category_product');
    Route::post('/edit-category-product', 'App\Http\Controllers\CategoryProductController@edit_category_product');
    Route::post('/delete-category-product', 'App\Http\Controllers\CategoryProductController@delete_category_product');

    //Product
    Route::get('/product', 'App\Http\Controllers\ProductController@show_page_product');
    Route::get('/get-all-product', 'App\Http\Controllers\ProductController@get_all_product');
    Route::get('/get-all-product-by-status/{status}', 'App\Http\Controllers\ProductController@get_all_product_by_status');
    Route::get('/search-product/{keyword}', 'App\Http\Controllers\ProductController@search_product');
    Route::get('/get-product-by-id/{id}', 'App\Http\Controllers\ProductController@get_product_by_id');
    Route::get('/active-product/{id}', 'App\Http\Controllers\ProductController@active_product');
    Route::get('/unactive-product/{id}', 'App\Http\Controllers\ProductController@unactive_product');
    Route::post('/add-product', 'App\Http\Controllers\ProductController@add_product');
    Route::post('/edit-product', 'App\Http\Controllers\ProductController@edit_product');
    Route::post('/delete-product', 'App\Http\Controllers\ProductController@delete_product');

    //Gallery
    Route::get('/gallery-product/{product_slug}', 'App\Http\Controllers\GalleryController@show_gallery');
    Route::get('/get-all-gallery/{product_slug}', 'App\Http\Controllers\GalleryController@get_all_gallery');
    Route::post('/add-gallery', 'App\Http\Controllers\GalleryController@add_gallery');
    Route::post('/edit-gallery', 'App\Http\Controllers\GalleryController@edit_gallery');
    Route::post('/delete-gallery', 'App\Http\Controllers\GalleryController@delete_gallery');

    //Banner
    Route::get('/banner', 'App\Http\Controllers\BannerController@show_page_banner');
    Route::get('/get-all-banner', 'App\Http\Controllers\BannerController@get_all_banner');
    Route::get('/get-all-banner-by-status/{status}', 'App\Http\Controllers\BannerController@get_all_banner_by_status');
    Route::get('/search-banner/{keyword}', 'App\Http\Controllers\BannerController@search_banner');
    Route::get('/get-banner-by-id/{id}', 'App\Http\Controllers\BannerController@get_banner_by_id');
    Route::get('/active-banner/{id}', 'App\Http\Controllers\BannerController@active_banner');
    Route::get('/unactive-banner/{id}', 'App\Http\Controllers\BannerController@unactive_banner');
    Route::post('/add-banner', 'App\Http\Controllers\BannerController@add_banner');
    Route::post('/edit-banner', 'App\Http\Controllers\BannerController@edit_banner');
    Route::post('/delete-banner', 'App\Http\Controllers\BannerController@delete_banner');

    //Voucher
    Route::get('/voucher', 'App\Http\Controllers\VoucherController@show_page_voucher');
    Route::get('/get-all-voucher', 'App\Http\Controllers\VoucherController@get_all_voucher');
    Route::get('/get-all-voucher-by-status/{status}', 'App\Http\Controllers\VoucherController@get_all_voucher_by_status');
    Route::get('/search-voucher/{keyword}', 'App\Http\Controllers\VoucherController@search_voucher');
    Route::get('/get-voucher-by-id/{id}', 'App\Http\Controllers\VoucherController@get_voucher_by_id');
    Route::get('/active-voucher/{id}', 'App\Http\Controllers\VoucherController@active_voucher');
    Route::get('/unactive-voucher/{id}', 'App\Http\Controllers\VoucherController@unactive_voucher');
    Route::post('/add-voucher', 'App\Http\Controllers\VoucherController@add_voucher');
    Route::post('/edit-voucher', 'App\Http\Controllers\VoucherController@edit_voucher');
    Route::post('/delete-voucher', 'App\Http\Controllers\VoucherController@delete_voucher');

    //Category post
    Route::get('/category-post', 'App\Http\Controllers\CategoryPostController@show_page_category_post');
    Route::get('/get-all-category-post', 'App\Http\Controllers\CategoryPostController@get_all_category_post');
    Route::get('/get-all-category-post-by-status/{status}', 'App\Http\Controllers\CategoryPostController@get_all_category_post_by_status');
    Route::get('/search-category-post/{keyword}', 'App\Http\Controllers\CategoryPostController@search_category_post');
    Route::get('/get-category-post-by-id/{id}', 'App\Http\Controllers\CategoryPostController@get_category_post_by_id');
    Route::get('/active-category-post/{id}', 'App\Http\Controllers\CategoryPostController@active_category_post');
    Route::get('/unactive-category-post/{id}', 'App\Http\Controllers\CategoryPostController@unactive_category_post');
    Route::post('/add-category-post', 'App\Http\Controllers\CategoryPostController@add_category_post');
    Route::post('/edit-category-post', 'App\Http\Controllers\CategoryPostController@edit_category_post');
    Route::post('/delete-category-post', 'App\Http\Controllers\CategoryPostController@delete_category_post');

    //Post
    Route::get('/post', 'App\Http\Controllers\PostController@show_page_post');
    Route::get('/get-all-post', 'App\Http\Controllers\PostController@get_all_post');
    Route::get('/get-all-post-by-status/{status}', 'App\Http\Controllers\PostController@get_all_post_by_status');
    Route::get('/search-post/{keyword}', 'App\Http\Controllers\PostController@search_post');
    Route::get('/active-post/{id}', 'App\Http\Controllers\PostController@active_post');
    Route::get('/unactive-post/{id}', 'App\Http\Controllers\PostController@unactive_post');
    Route::get('/add-post', 'App\Http\Controllers\PostController@show_page_add_post');
    Route::get('/edit-post/{post_id}', 'App\Http\Controllers\PostController@show_page_edit_post');
    Route::get('/view-post/{post_id}', 'App\Http\Controllers\PostController@show_page_detail_post');
    Route::post('/add-post', 'App\Http\Controllers\PostController@add_post');
    Route::post('/edit-post', 'App\Http\Controllers\PostController@edit_post');
    Route::post('/delete-post', 'App\Http\Controllers\PostController@delete_post');

    //Comment
    Route::get('/comment', 'App\Http\Controllers\CommentController@show_page_comment');
    Route::get('/get-all-comment', 'App\Http\Controllers\CommentController@get_all_comment');
    Route::get('/get-all-comment-by-status/{status}', 'App\Http\Controllers\CommentController@get_all_comment_by_status');
    Route::get('/search-comment/{keyword}', 'App\Http\Controllers\CommentController@search_comment');
    Route::get('/get-comment-by-id/{id}', 'App\Http\Controllers\CommentController@get_comment_by_id');
    Route::post('/add-comment', 'App\Http\Controllers\CommentController@add_comment');
    Route::post('/edit-comment', 'App\Http\Controllers\CommentController@edit_comment');
    Route::post('/delete-comment', 'App\Http\Controllers\CommentController@delete_comment');
    Route::post('/reply-comment', 'App\Http\Controllers\CommentController@reply_comment');

    //Order
    Route::get('/order', 'App\Http\Controllers\OrderController@show_page_order');
    Route::get('/order-detail/{order_id}', 'App\Http\Controllers\OrderController@show_page_order_detail');
    Route::get('/get-all-order', 'App\Http\Controllers\OrderController@get_all_order');
    Route::get('/get-all-order-by-status/{status}', 'App\Http\Controllers\OrderController@get_all_order_by_status');
    Route::get('/search-order/{keyword}', 'App\Http\Controllers\OrderController@search_order');
    Route::post('/change-status-order', 'App\Http\Controllers\OrderController@change_status_order');
});


//User Route

//Send mail
Route::post('/forgot-password', 'App\Http\Controllers\UserController@forgot_password');
Route::post('/reset-password', 'App\Http\Controllers\UserController@reset_password');

// Home
Route::get('/', 'App\Http\Controllers\UserController@show_page_home');

// Product
Route::get('/chi-tiet-san-pham/{product_slug}', 'App\Http\Controllers\ProductController@show_page_detail_product');
Route::get('/san-pham', 'App\Http\Controllers\UserController@show_page_product_user');
Route::get('/get-product', 'App\Http\Controllers\ProductController@get_product_user');

//Search
Route::get('/tim-kiem', 'App\Http\Controllers\UserController@show_page_search');
Route::get('/search-product-user', 'App\Http\Controllers\ProductController@search_product_user');

//Category product
Route::get('/danh-muc-san-pham/{category_product_slug}', 'App\Http\Controllers\CategoryProductController@show_page_category_product_user');
Route::get('/get-product-by-category-user', 'App\Http\Controllers\CategoryProductController@get_product_by_category_user');
Route::get('/load-category-product-user', 'App\Http\Controllers\CategoryProductController@load_category_product_user');

//Brand
Route::get('/thuong-hieu-san-pham/{brand_slug}', 'App\Http\Controllers\BrandController@show_page_brand_user');
Route::get('/get-product-by-brand-user', 'App\Http\Controllers\BrandController@get_product_by_brand_user');
Route::get('/load-brand-user', 'App\Http\Controllers\BrandController@load_brand_user');

//Post
Route::get('/tin-tuc', 'App\Http\Controllers\PostController@show_page_all_post_user');
Route::get('/get-all-post-user', 'App\Http\Controllers\PostController@get_all_post_user');
Route::get('/bai-viet/{post_slug}', 'App\Http\Controllers\PostController@get_detail_post_user');

//Comment
Route::get('/load-comment-user', 'App\Http\Controllers\CommentController@load_comment_user');
Route::post('/add-comment-user', 'App\Http\Controllers\CommentController@add_comment_user')->middleware(AuthenticateUser::class);

// Cart
Route::get('/gio-hang', 'App\Http\Controllers\CartController@show_page_cart_user')->middleware(AuthenticateUser::class);
Route::get('/get-cart-user', 'App\Http\Controllers\CartController@get_cart_user')->middleware(AuthenticateUser::class);
Route::post('/add-cart-user', 'App\Http\Controllers\CartController@add_cart_user')->middleware(AuthenticateUser::class);
Route::post('/update-cart-user', 'App\Http\Controllers\CartController@update_cart_user')->middleware(AuthenticateUser::class);
Route::post('/delete-cart-user', 'App\Http\Controllers\CartController@delete_cart_user')->middleware(AuthenticateUser::class);

// Checkout
Route::post('/thanh-toan', 'App\Http\Controllers\CheckoutController@show_page_checkout')->middleware(AuthenticateUser::class);

//Voucher
Route::get('/check-discount-code-user', 'App\Http\Controllers\VoucherController@check_discount_code_user')->middleware(AuthenticateUser::class);

//Order
Route::get('/lich-su-dat-hang', 'App\Http\Controllers\OrderController@show_page_history_order')->middleware(AuthenticateUser::class);
Route::post('/add-order-user', 'App\Http\Controllers\OrderController@add_order_user')->middleware(AuthenticateUser::class);

//Contact
Route::get('/lien-he', 'App\Http\Controllers\UserController@show_page_contact');

// Login
Route::get('/dang-nhap', 'App\Http\Controllers\UserController@show_page_login');
Route::get('/dang-ky', 'App\Http\Controllers\UserController@show_page_login');
Route::post('/login', 'App\Http\Controllers\UserController@login_account_user');
Route::post('/register', 'App\Http\Controllers\UserController@register_account_user');
Route::post('/change-password-user', 'App\Http\Controllers\UserController@change_password_user')->middleware(AuthenticateUser::class);

//Forgot password
Route::get('/quen-mat-khau', 'App\Http\Controllers\UserController@show_page_forgot_password');
Route::post('/forgot-password-user', 'App\Http\Controllers\UserController@forgot_password_user');
Route::post('/reset-password-user', 'App\Http\Controllers\UserController@reset_password_user');

//Login Facebook
Route::get('/login-facebook', 'App\Http\Controllers\UserController@login_facebook');
Route::get('/facebook/callback', 'App\Http\Controllers\UserController@callback_facebook');

//Login Google
Route::get('/login-google', 'App\Http\Controllers\UserController@login_google');
Route::get('/google/callback', 'App\Http\Controllers\UserController@callback_google');

//Logout
Route::get('/logout', 'App\Http\Controllers\UserController@logout_account_user');
