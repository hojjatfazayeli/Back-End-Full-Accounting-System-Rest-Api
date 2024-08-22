<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable =
        [
            'uuid',
            'message',
            'sender_role',
            'sender_id',
            'receiver_role',
            'receiver_id',
            'file'
        ];

    protected $hidden =
        [
            'deleted_at',
            'message_box_id'
        ];
    public function message_box()
    {
        return $this->belongsTo(MessageBox::class);
    }
}

