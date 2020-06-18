<?php
/**
 * Model generated using Cms
 * Help: http://Cms.com
 */

namespace App;

use Trebol\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends EntrustPermission
{
    use SoftDeletes;

	protected $table = 'permissions';

	protected $hidden = [

    ];

	protected $guarded = [];

	protected $dates = ['deleted_at'];
}
