<?php

namespace Lehungdev\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Lehungdev\Cms\Helpers\LAHelper;

class Menu extends Model
{
    protected $table = 'la_menus';
    
    protected $guarded = [
        
    ];
}
