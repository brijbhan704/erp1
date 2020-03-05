<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardGallery extends Model
{
    protected $table = 'card_galleries';
    protected $fillable = ['card_sender', 'card_receiver', 'sender_id', 'receiver_id'];
    protected $hidden = ['_token'];
    
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
