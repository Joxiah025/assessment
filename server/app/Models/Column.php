<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;
    protected $table = 'columns';
    protected $guarded = [];

    public function cards() {
        return $this->hasMany('App\Models\Card', 'columns_id', 'id');
    }
}
