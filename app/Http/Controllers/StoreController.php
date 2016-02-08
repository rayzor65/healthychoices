<?php

namespace App\Http\Controllers;

use App\Models\FoodCard;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Request;

class StoreController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get()
    {
        // Returns the original Mongo Result
        $result = DB::collection('food_cards_collection')->raw(function($collection)
        {
            return $collection->aggregate(array(
                array(
                    '$group' => array(
                        '_id' => '$store.name',
                        'cards' => array(
                            '$push' => '$name'
                        )
                    )
                )
            ));
        });
//        $results = FoodCard::groupBy('store')->get();
//        dd($result);

        // Some manipulation to make it easier to deal with on mobile app side
        $stores = [];
        foreach ($result['result'] as $k => $v) {
            $stores[$v['_id']] = $v['cards'];
        }

        return response()->json($stores);
    }

    public function getStore($search)
    {
        // May want to clean up search string first
        $searchStr = $search;

        // Returns the original Mongo Result
        $result = DB::collection('food_cards_collection')
            ->where('store.name', 'like', '%' . $searchStr . '%')
            ->get()
//            ->raw(function($collection)
//        {
//            return $collection->aggregate(array(
//                array(
//                    '$group' => array(
//                        '_id' => '$store.name',
//                        'cards' => array(
//                            '$push' => '$name'
//                        )
//                    )
//                )
//            ));
//        });
;
        return response()->json($result);
    }
}
