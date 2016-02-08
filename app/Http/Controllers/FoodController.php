<?php

namespace App\Http\Controllers;

use App\Models\FoodCard;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Request;
use Illuminate\Support\Facades\DB;

class FoodController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get()
    {
        $foodCards = FoodCard::all();
        return response()->json($foodCards);
    }

    public function getByValue($field, $value)
    {
        // Returns the original Mongo Result
        // ->where('store.name', 'like', '%' . $field . '%')
        $result = DB::collection('food_cards_collection')
            ->where($field, 'like', '%' . $value . '%')
            ->get();

        return response()->json($result);
    }

    public function getFoodCard()
    {
//        $foodCard->photo = base64_decode($input['photo']);

//        $im = imagecreatefromstring($foodCard->photo);
//        if ($im !== false) {
//            header('Content-Type: image/png');
//            imagepng($im);
//            imagedestroy($im);
//        }
//        else {
//            echo 'An error occurred.';
//        }
    }

    public function post()
    {
        $input = Request::all();

        $foodCard = new FoodCard();
        $foodCard->name = $input['name'];
        $foodCard->energy = $input['energy'];
        $foodCard->notes = $input['notes'];
        $foodCard->store = ['name' => $input['store']];
        $foodCard->photo = $input['photo'];
        $foodCard->save();

        // Retrieve to return what was created
        $saved = FoodCard::find($foodCard->id);

        return response()->json($saved->attributesToArray(), 201);
    }
}
