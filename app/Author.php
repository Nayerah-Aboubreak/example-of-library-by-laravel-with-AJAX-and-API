<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable=[
        'name', 'bio' , 'img'
    ];

    //ِauthor has many books
    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
