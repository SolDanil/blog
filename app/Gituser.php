<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gituser extends Model
{
    //
    protected $fillable=['name','followers_url','repos_url','count_rep'];
}
