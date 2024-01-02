<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;

    protected $table = 'popups';

    protected $guarded = [];



    public function pages()
    {
        return $this->belongsToMany(Page::class,'page_popups');
    }
}
