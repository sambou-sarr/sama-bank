<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarteBancaire extends Model
{
    
    public function compte()
    {
        return $this->belongsTo(CompteBancaire::class, 'compte_id');
    }
}
