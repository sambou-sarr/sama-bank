<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
   public function compteSource()
    {
        return $this->belongsTo(CompteBancaire::class, 'compte_source_id');
    }

    public function compteDest()
    {
        return $this->belongsTo(CompteBancaire::class, 'compte_dest_id');
    }
    
}
