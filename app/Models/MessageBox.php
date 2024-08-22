<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageBox extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable =
        [
            'uuid',
            'sender_role',
            'sender_id',
            'receiver_role',
            'receiver_id',
        ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
