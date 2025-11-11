<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $fillable = ['freelance_id','title','description','price','status'];

    public function freelancer()
    {
        return $this->belongsTo(User::class,'freelance_id');
    }
}
