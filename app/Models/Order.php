<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = ['client_id','freelance_id','service_id','amount','payment_status','payment_method','payment_id'];

    public function client()
    {
        return $this->belongsTo(User::class,'client_id');
    }
    public function freelancer()
    {
        return $this->belongsTo(User::class,'freelance_id');
    }
    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function chat()
    {
        return $this->hasOne(Chat::class);
    }
}
