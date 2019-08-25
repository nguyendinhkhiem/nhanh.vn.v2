<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pick_name',
        'pick_address',
        'pick_province',
        'pick_district',
        'pick_ward',
        'pick_street',
        'pick_email',
        'pick_tel',
    ];
}