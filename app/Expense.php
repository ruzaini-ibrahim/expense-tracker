<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'subject','comment','amount','spent_at','created_by','updated_by'
    ];
}
