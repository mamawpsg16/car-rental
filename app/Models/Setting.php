<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'gender',
        'contact_number',
        'date_of_birth',
        'address',
        'email',
    ];
}
