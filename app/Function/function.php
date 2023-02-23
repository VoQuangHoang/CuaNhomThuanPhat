<?php

/*use function foo\func;*/

define("__IMAGE_DEFAULT__", asset('backend/images/default.png'));
define("__NO_IMAGE_DEFAULT__", asset('backend/images/placeholder.png'));
define("__BASE_URL__", url('frontend'));

use Carbon\Carbon;
use App\Models\Coupons;
use App\Models\Settings;
use App\Models\Categories;
use App\Models\ProductBonus;
use App\Models\CustomerDiscount;
use App\Services\ViettelPostService;
use Gloudemans\Shoppingcart\Facades\Cart;

function renderImage($link)
{
    if (!empty($link)) {
        return $link;
    }
    return asset('backend/img/no-image.png');
}

function text_limit($str, $limit = 10)
{
    if (stripos($str, " ")) {
        $ex_str = explode(" ", $str);
        if (count($ex_str) > $limit) {
            $str_s = null;
            for ($i = 0; $i < $limit; $i++) {
                $str_s .= $ex_str[$i] .
                    " ";
            }
            return $str_s;
        } else {
            return $str;
        }
    } else {
        return $str;
    }
}

function format_datetime($date,$setting)

{   

    $date_format = Carbon::parse($date);

    return $date_format->format($setting);

}

function menuChildren($data, $id, $item)
{
    if (count($item->get_child_cate()) > 0) {
        echo '<ol class="dd-list">';
        foreach ($item->get_child_cate() as $item) {
            if ($item->parent_id == $id) {
                echo '<li class="dd-item" data-id="' . $item->id . '">';
                echo '  <div class="dd-handle">' . $item->title . '(<i>' . $item->url . '</i>)</div>
                                    <div class="button-group">
                                        <a href="javascript:;" class="modalEditMenu" data-id="' . $item->id . '"> 
                                        <i class="fa fa-edit"></i>
                                        </a> &nbsp; &nbsp; &nbsp;
                                        <a class="text-danger" href="' . route('setting.menu.delete', $item['id']) . '" onclick="return confirm(\'Bạn có chắc chắn xóa không ?\')" title="Xóa"> <i class="fa fa-times"></i></a>
                                    </div>';
                menuChildren($data, $item->id, $item);
                echo '</li>';
            }
        }
        echo '</ol>';
    }
}

function renderLinkAddPostType()
{
    $type = request()->get('type');
    if ($type == 'blog') {
        return [
            'title'    => 'Bài Viết',
            'linkAdd'  => route('posts.create', ['type' => 'blog']),
            'linkList' => route('posts.index', ['type' => 'blog']),
        ];
    }
}

function checkBoxCategory($data, $id, $item, $list_id = null)
{
    if (count($item->get_child_cate()) > 0) {
        echo '<div style="padding-left:15px;">';
        foreach ($item->get_child_cate() as $value) {
            $checked = null;
            if (!empty($list_id)) {
                if (in_array($value->id, $list_id)) {
                    $checked = 'checked';
                }
            }
            if ($value->parent_id == $id) {
                echo '<label class="custom-checkbox">
                            <input type="checkbox" class="category" name="category[]" value="' . $value->id . '" ' . $checked . ' > ' . $value->name . '
                        </label>';
                checkBoxCategory($data, $value->id, $item);
            }
        }
        echo '</div>';
    }
}

function checkBoxCategoryName($data, $id, $item, $list_id = null, $name = null)
{
    if (count($item->get_child_cate()) > 0) {
        echo '<div style="padding-left:15px;">';
        foreach ($item->get_child_cate() as $value) {
            $checked = null;
            if (!empty($list_id)) {
                if (in_array($value->id, $list_id)) {
                    $checked = 'checked';
                }
            }
            if ($value->parent_id == $id) {
                echo '<label class="custom-checkbox">
                            <input type="checkbox" class="category" name="'.$name.'" value="' . $value->id . '" ' . $checked . ' > ' . $value->name . '
                        </label>';
                checkBoxCategory($data, $value->id, $item);
            }
        }
        echo '</div>';
    }
}

function menuMulti($data, $parent_id = 0, $str = '---| ', $select = 0)
{
    foreach ($data as $value) {
        $id   = $value->id;
        $name = $value->name;
        if ($value->parent_id == $parent_id) {
            if ($select != 0 && $id == $select) {
                echo '<option value=' . $id . ' selected> ' . $str . $name . ' </option>';
            } else {
                echo '<option value=' . $id . '> ' . $str . $name . ' </option>';
            }
            menuMulti($data, $id, $str . '---|  ', $select);
        }
    }
}
function getSettings($key = null, $field = null)
{
    if(!empty($key)){
        $data = Settings::where('type', $key)->first();
        if(!empty($data)){
            $data = json_decode($data->content);
            if(!empty($field)){
                return !empty($data->{ $field }) ? $data->{ $field } : $data;
            }
            return $data;
        }
        return 'Key does not exist';
    }
    return 'Error';
}


function renderAction($method)
{
    return isUpdate($method) ? 'Cập nhật' : 'Thêm mới' ;
}


function isUpdate($method)
{
    return (bool)$method == 'update';
}

function updateOrStoreRouteRender($method, $model, $data)
{
    return isUpdate($method) ? route($model . '.update', $data) : route($model . '.store');
}


function generateRandomCode($num) 
{
    return 'DTV'.substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1,$num);
}

function generateRandomCodeGt($num) 
{
    return 'DTVGT'.substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1,$num);
}


function getConsts() {
    return [
        'sort-trans' => [
            'cu-nhat' => 'Cũ nhất',
            'gia-tu-cao-den-thap' => 'Giá từ cao đến thấp',
            'gia-tu-thap-den-cao' => 'Giá từ thấp đến cao',
        ],
        'sort-attrs' => [
            'cu-nhat' => 'created_at',
            'gia-tu-cao-den-thap' => 'price',
            'gia-tu-thap-den-cao' => 'price',
        ]
    ];
}

function getYoutubeEmbedUrl($url)
{
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';
        
    if (preg_match($longUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }

    if (preg_match($shortUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }
    return $youtube_id ;
}

function listCate($data, $parent_id = 0, $str = '')
{
    foreach ($data as $value) {

        $id   = $value->id;
        $name = $value->name;
        $popular='';
        if($value->active == 1){
            $active = '<span class="badge badge-success">Hiển thị</span>';
        }else{
            $active = '<span class="badge badge-danger">Không hiển thị</span>';
        }
        if($value->popular == 1){
            $popular = '<br><span class="badge badge-info">Nổi bật</span>';
        }
        if ($value->parent_id == $parent_id) {

            if ($str == '') {
                $strName = '<b>' . $str . $name . '</b>';
            } else {
                $strName = $str . $name;
            }
            

            echo    '<tr class="odd">';

            echo    '<td><input type="checkbox" name="chkItem[]" value="' . $id . '"></td>';

            echo    '<td>

                        <a class="text-default">' . $strName . '</a></br>

                        <a href="' . route('home.product_cate_single', $value->slug) . '" target="_blank"> <i class="far fa-hand-point-right"></i> Link: ' . route('home.product_cate_single', $value->slug) . ' </a>

                    </td>';

            echo    '<td><a class="text-default" href="' . route('product-categories.edit', $id) . '" title="Sửa"> ' . count($value->getChildCate()) ?: '_' . ' </a>

                        </td>';
            
            echo    '<td>'.$active.''.$popular.'</td>';

            echo    '<td>
                        <a href="' . route('product-categories.edit', $id) . '" class="btn btn-sm btn-info btn-edit"title="Sửa"> 
                        <i class="fas fa-pencil-alt"></i> Sửa
                        </a>

                    <a href="javascript:void(0);" class="btn btn-sm btn-danger btn-destroy" data-href="' . route('product-categories.destroy', $id) . '" data-toggle="modal" data-target="#confim">

                       <i class="fas fa-trash"></i> Xóa

                    </a>

                    </td>';

            echo    '</tr>';

            listCate($data, $id, $str . '---| ');

        }

    }

}

function listCatePosts($data, $parent_id = 0, $str = '')
{
    foreach ($data as $value) {
        $id   = $value->id;
        $name = $value->name;
        if ($value->parent_id == $parent_id) {
            if ($str == '') {
                $strName = '<b>' . $str . $name . '</b><br>';
            } else {
                $strName = '<p style="margin-bottom:0">' . $str . $name . '</p>';
            }
            echo '<tr class="odd">';
            echo '<td><input type="checkbox" name="chkItem[]" value="' . $id . '"></td>';
            // echo "<td><img src='$value->image' class='img-responsive imglist'></td>";
            echo '<td>
                        <a class="text-default" href="' . route('posts-categories.edit', $id) . '" title="Sửa">' . $strName . '</a>
                        
                    </td>';

            // echo '<td><a>' . count($value->getChildCate()) ?: '_' . ' </a>
            //             </td>';
            
            echo ' <td><a href="' . route('posts-categories.edit', $id) . '" title="Sửa">
                    <span class="edit-action badge badge-primary">Sửa <i class="far fa-edit"></i></span>
                </a> &nbsp;
                        <a href="javascript:;" class="btn-destroy" data-href="' . route('posts-categories.destroy', $id) . '" data-toggle="modal" data-target="#confim">
                            <span class="delete-action badge badge-danger">Xóa <i class="far fa-trash-alt"></i></span>
                        </a>
                    </td>';
            echo '</tr>';

            listCatePosts($data, $id, $str . '---| ');
        }
    }
}


function menuMultiProduct($data, $parent_id = 0, $str = '', $select)
{
    foreach ($data as $value) {

        $id   = $value->id;
        $name = $value->name;
        if($select!='' && in_array($id,$select)){
            $checked = 'checked';
        }else{
            $checked = '';
        }
        if($value->parent_id == 0){
            $disabled = 'disabled';
        }else{
            $disabled = '';
        }
        if ($value->parent_id == $parent_id) {
            echo '<div class="form-group"><div class="custom-control custom-checkbox">';
            echo $str . '<input class="custom-control-input" type="checkbox"' .$checked. ' value=' . $id . ' name="category[]" id="postCheckbox' . $id . '"'.$disabled.'>';
            echo '<label for="postCheckbox' . $id . '" class="custom-control-label d-inline">' .$name.'</label>';
            echo '</div></div>';
            
            menuMultiProduct($data, $id, '&nbsp&nbsp&nbsp&nbsp&nbsp '.$str, $select);
        }
    }
}

function menuMultiPost($data, $parent_id = 0, $str = '', $select)
{
    foreach ($data as $value) {

        $id   = $value->id;
        $name = $value->name;
        if($select!='' && in_array($id,$select)){
            $checked = 'checked';
        }else{
            $checked = '';
        }
        if ($value->parent_id == $parent_id) {
            echo '<div class="form-group"><div class="custom-control custom-checkbox">';
            echo $str . '<input class="custom-control-input" type="checkbox"' .$checked. ' value=' . $id . ' name="category[]" id="postCheckbox' . $id . '">';
            echo '<label for="postCheckbox' . $id . '" class="custom-control-label d-inline">' .$name.'</label>';
            echo '</div></div>';
            
            menuMultiPost($data, $id, '&nbsp&nbsp&nbsp&nbsp&nbsp '.$str, $select);
        }
    }
}

function getStatusOrderVnPay($status)
{
    try {
        $status = \App\Models\StatusOrder::where('ma_loi',$status)->first();

        return $status->desc;

    } catch (\Throwable $th) {
        
        return '';

    }
    
}

function getListParent($data)
{
    $parent = $data;
    if ($data->parent_id > 0) {
        $parent = $data->getParent();
        $parent = getListParent($parent);
    }
    return $parent;
}

function dequy($datas)
{
    $list_ids = [];
    foreach ($datas as $data) {
        $list_ids[] = $data->id;
        if ($data->get_child_cate()->count() > 0) {
            $list_ids = array_merge($list_ids, dequy($data->get_child_cate()));
        }
    }
    return $list_ids;
}

function get_list_ids($datas)
{
    return $datas ? dequy($datas->get_child_cate()) : null;
}

function getAddress($id_city,$id_district,$id_ward){

    $city = \App\Models\City::find($id_city)->city_name;

    $district = \App\Models\District::find($id_district)->district_name;

    $wards ='';

    if($id_ward !=''){

        $wards = \App\Models\Wards::find($id_ward)->ward_name.', ';
    }
    
    return $wards.$district.', '.$city;
}

function is_schedule_flash_sale($product)
{
    $strtotime_date_from = strtotime($product->date_sale_from);
    $strtotime_date_to = strtotime($product->date_sale_to);

    return (!empty($product->date_sale_to) 
            && $strtotime_date_to > $strtotime_date_from 
            && $strtotime_date_to >= strtotime(date("Y/m/d"))
            && $strtotime_date_from <= strtotime(date("Y/m/d")));
}

function check_sale_product($product)
{
    $is_sale = !empty($product->sale_price);
    $is_sale_schedule = false;

    $strtotime_date_from = strtotime($product->date_sale_from);
    $strtotime_date_to = strtotime($product->date_sale_to);

    if (!empty($product->date_sale_to)) {
        if ($strtotime_date_to > $strtotime_date_from 
                && $strtotime_date_to > strtotime(date("Y/m/d"))
                && $strtotime_date_from <= strtotime(date("Y/m/d"))) {
            $is_sale = true;
            $is_sale_schedule = true;
        } else {
            $is_sale = false;
        }
    }

    return compact('is_sale', 'is_sale_schedule');
}

function getDataCart($city_id = null, $district_id = null)
{
    $subtotal = Cart::instance('shopping')->priceTotal(0, 3, false);
    $customer = Auth::guard('customer')->user();

    if (session()->has('coupon')) {
        $code = session()->get('coupon')['code'];
        if($code != ''){
            $data = Coupons::where([
                'code' => $code,
                'status' => 1
            ])->first();

            if ($data) {
                session()->put('coupon', [
                    'code' => $data->code,
                    'discount' => $data->discount($subtotal)
                ]);
                
                // if(($data->close == 1 && !Auth::guard('customer')->check()) || ($data->close==1 && Auth::guard('customer')->user()->close !=1)) {
                //     session()->forget('coupon');
                // }

                if(!empty($data->condition)){
                    if($subtotal < $data->condition){
                        session()->forget('coupon');
                    }
                }
            } else {
                session()->forget('coupon');
            }
        }
    }
    $discount = session()->get('coupon')['discount'] ?? 0;
    $code = session()->get('coupon')['code'] ?? null;

    $check_discount = CustomerDiscount::where('condition_apply','<=',$subtotal)->orderBy('level', 'asc')->first();

    if($customer->customer_role_id){
        $cus_discount =  number_format(round(($customer->CustomerRole->discount / 100) * $subtotal), 0,'','');
    }elseif($check_discount){
        $cus_discount =  number_format(round(($check_discount->discount / 100) * $subtotal), 0, '','');
    }else{
        $cus_discount = 0;
    }

    $total = $subtotal - $discount - $cus_discount;
    
    if ($total < 0) {
        $total = 0;
    }
    $viettel_post = new ViettelPostService();
    $vtpost_price_vcn = $viettel_post->prices($city_id, $district_id);
    $shipping = [];
    if ($vtpost_price_vcn['message'] && $vtpost_price_vcn['message'] == 'OK') {
        $shipping = $vtpost_price_vcn['data']['MONEY_TOTAL'];
        $total += $vtpost_price_vcn['data']['MONEY_TOTAL'];
    }

    return collect([
        'discount' => $discount,
        'code' => $code,
        'subtotal' => $subtotal,
        'shipping' => $shipping,
        'total' => $total,
        'cus_discount' => $cus_discount
    ]);
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'năm',
        'm' => 'tháng',
        'w' => 'tuần',
        'd' => 'ngày',
        'h' => 'giờ',
        'i' => 'phút',
        's' => 'giây',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' trước' : 'vừa xong';
}

function convert_vi_to_en($str) {
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
    $str = preg_replace("/(đ)/", "d", $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
    $str = preg_replace("/(Đ)/", "D", $str);
    //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
    return $str;
}

function getProfilePicture($string)
{
    $string = strtoupper(convert_vi_to_en($string));
    $str_slice = explode(' ',$string);
    $avatar_str = '';
    if (!empty($str_slice)) {
        foreach ($str_slice as $value) {
            $avatar_str .= substr($value, 0, 1);
        }
    }
    return $avatar_str;
}

function getProductBonus($product_id, $quantity)
{
    $rs = ProductBonus::where('product_id', $product_id)->where('min_required', '<=',$quantity)->get();

    return $rs;
}

function getStarProduct($product)
{
    $total_review = $product->reviews()->count();
    $sum_star = $product->reviews->sum('star');
    $star = 5;
    if ($total_review > 0) {
        $star = $sum_star / $total_review;
    }

    return $star;
}

function getAlphabetBrands($brands, $key) {
    foreach ($brands as $brand){
        if(strtolower($brand->name[0]) == strtolower($key)) {
            echo '<li><a href="' . route('home.brand_single', $brand->slug) . '">'.$brand->name.'</a></li>';
        }
    }
}

function getBonusPointTotal($cart){
    $bonusPoint = 0;
    foreach ($cart as $item) {
        if($item->options->combo == 1){
            if($item->qty >= 3 && $item->qty < 6){
                $bonusPoint += $item->options->combo3;
            }
            if($item->qty >= 6 && $item->qty < 9){
                $bonusPoint += $item->options->combo6;
            }
            if($item->qty >= 9){
                $bonusPoint += $item->options->combo9;
            }
        }
    }
    return $bonusPoint;
}

function getProductPointTotal($cart){
    $productPoint = 0;
    foreach ($cart as $item) {
        $productPoint += $item->options->pointIQ*$item->qty;
    }
    return $productPoint;
}

function getFullAddressVTP($data){
    $viettel_post = new ViettelPostService();
    $ward = $data->ward_id ? ucwords(\Str::lower($viettel_post->getWardById($data->district_id, $data->ward_id))) : '';
    $city = $viettel_post->getProvinceById($data->city_id);
    $district = ucwords(\Str::lower($viettel_post->getDistrictById($data->city_id, $data->district_id)));
    if($ward != ''){
        $result = $data->address.', '.$ward.', '.$district.', '.$city;
    }else{
        $result = $data->address.', '.$district.', '.$city;
    }
    return $result;
}

function deleteCateChild($data){
    if(!empty($data->childs)){
        foreach($data->childs as $child){
            deleteCateChild($child);
            Categories::destroy($child->id);
        }
    }
    return true;
}



