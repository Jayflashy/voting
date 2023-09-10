<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'email',
        'name',
        'description',
        'address',
        'phone',
        'logo',
        'favicon', 'referral',
        'touch_icon',
        'facebook', 'agreement_form',
        'twitter','doc_link',
        'whatsapp', 'ios_link','android_link',
        'instagram', 'telegram',
        'primary_color',
        'sec_color', 'currency',
        'currency_code',
        'custom_js',
        'custom_css',
        'is_adsense',
        'meta_keywords','is_announcement','announcement','sponsor','price'
    ];
}
