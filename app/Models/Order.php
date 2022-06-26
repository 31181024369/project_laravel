<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
       'name', 'email', 'phone_number', 'address', 'qty', 'price', 'pay_method', 'status', 'notice'
   ];
   function products(){
       return $this->belongsToMany('App\Models\Product');
   }
}
