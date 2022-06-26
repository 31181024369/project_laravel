<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
 
    protected $fillable = ['name', 'desc', 'content', 'price', 'thumbnail', 'qty','status', 'cat_id'];
    function orders(){
        return $this->belongsToMany('App\Models\Order');
    }
}
