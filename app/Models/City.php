<?php

namespace App\Models;

use App\Models\Traits\HasUniqueIdentifier;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasUniqueIdentifier;

    protected $table = 'cities';
    public $timestamps = true;

    protected $fillable = ['postcode', 'name'];
}
