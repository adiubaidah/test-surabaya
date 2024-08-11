<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Employee extends Model
{
    use HasUuids,HasFactory;
    public $incrementing = false;

    // Set the key type to string
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
