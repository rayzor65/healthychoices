<?php

namespace App\Models;

use Jenssegers\Mongodb\Model as Moloquent;

class FoodCard extends Moloquent
{
    protected $collection = 'food_cards_collection';
    public $incrementing = false;

    public function store()
    {
        return $this->embedsOne('Store');
    }
}
