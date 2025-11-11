<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //
    protected $fillable=['order_id'];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class,'chat_id');
    }

}
