<?php

namespace FHusquinet\ModelOptions\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use FHusquinet\ModelOptions\Traits\HasOptions;

class User extends Model
{
    use HasOptions;
    
    protected $guarded = [];
}