<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dice1',
        'dice2',
        'win',
    ];

    public function user(){
      return  $this->belongsTo(User::class);
    }

    
}
