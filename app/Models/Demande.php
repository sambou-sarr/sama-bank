<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    public function compte()
{
    return $this->belongsTo(CompteBancaire::class);
}
public function getStatusBadgeColor()
{
    return match ($this->statut) {
        'En Attente' => 'warning',
        'Acceptée'   => 'success',
        'Rejetée'    => 'danger',
        default      => 'secondary',
    };
}

}
