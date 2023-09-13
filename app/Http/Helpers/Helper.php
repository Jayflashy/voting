<?php

use App\Models\Contestant;
use App\Models\Setting;
use App\Models\SystemSetting;

if (!function_exists('get_setting')) {
    function get_setting($key)
    {
        $settings = Setting::first();
        $setting = $settings->$key;
        return $setting;
    }
}
if (!function_exists('sys_setting')) {
    function sys_setting($key, $default = null)
    {
        $settings = SystemSetting::all();
        $setting = $settings->where('name', $key)->first();

        return $setting == null ? $default : $setting->value;
    }
}

if (!function_exists('static_asset')) {
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/assets/' . $path, $secure);
    }
}

//return file uploaded via uploader
if (!function_exists('my_asset')) {
    function my_asset($path, $secure = null)
    {
        return app('url')->asset('public/uploads/' . $path, $secure);
    }
}

function text_trim($string, $length = null)
{
    if (empty($length)) $length = 100;
    return Str::limit($string, $length, "...");
}

// Create slug
function uniqueSlug($name ,$model)
{
    $slug = Str::slug($name);
    $allSlugs = checkRelatedSlugs($slug , $model);
    if (! $allSlugs->contains('slug', $slug)){
        return $slug;
    }

    $i = 1;
    $is_contain = true;
    do {
        $newSlug = $slug . '-' . $i;
        if (!$allSlugs->contains('slug', $newSlug)) {
            $is_contain = false;
            return $newSlug;
        }
        $i++;
    } while ($is_contain);
}
function checkRelatedSlugs($slug , $model)
{
    return DB::table($model)->where('slug', 'LIKE', $slug . '%')->get();
}

function get_status($status){;
    switch ($status) {
        case 1:
            return '<span class="badge bg-success">Enabled</span>';
            break;
        case 2:
            return '<span class="badge bg-danger">Disabled</span>';
            break;
        default:
            return '<span class="badge bg-secondary">unknown</span>';
    }

}
function get_trx_status($status){;
    switch ($status) {
        case 1:
            return '<span class="badge bg-success">successful</span>';
            break;
        case 2:
            return '<span class="badge bg-warning">pending</span>';
            break;
        case 3:
            return '<span class="badge bg-danger">cancelled</span>';
            break;
        case 4:
            return '<span class="badge bg-info">refunded</span>';
            break;
        default:
            return '<span class="badge bg-secondary">unknown</span>';
    }

}

function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getAmount($amount, $length = 2)
{
    $amount = round($amount, $length);
    return $amount + 0;
}

function show_datetime($date, $format = 'd M, Y h:i:s a')
{
    return \Carbon\Carbon::parse($date)->format($format);
}
function show_datetime1($date, $format = 'd M, Y h:ia')
{
    return \Carbon\Carbon::parse($date)->format($format);
}
function show_date($date, $format = 'd M, Y')
{
    return \Carbon\Carbon::parse($date)->format($format);
}

function show_time($date, $format = 'h:ia')
{
    return \Carbon\Carbon::parse($date)->format($format);
}

//formats currency
if (!function_exists('format_price')) {
    function format_price($price)
    {
        $fomated_price = number_format($price, 2);
        $currency = get_setting('currency');
        return $currency .$fomated_price;
    }
}
function sym_price($price)
{
    $fomated_price = number_format($price, 2);
    $currency = get_setting('currency_code');
    return $currency . $fomated_price;
}
function format_number($price)
{
    $fomated_price = number_format($price, 2);
    return $fomated_price;
}

function result_percentage($id){
    $contestant = Contestant::find($id);
    $category = $contestant->category;
    $total = $category->contestants->sum('votes');
    $val = number_format(($contestant->votes / $total) * 100, 2);
    return $val. "%";
}
