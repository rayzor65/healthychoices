<?php

namespace App\Models;

use Jenssegers\Mongodb\Model as Moloquent;

class Store extends Moloquent
{
    protected $collection = 'store_collection';
    public $incrementing = false;
}
