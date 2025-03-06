<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
 
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function createRestaurant(Request $request){
        $request->validate( [
                'name'=>'required',
                'area_code'=>'location_id',
                'location_id'=> 'required|integer|exists:locations,id'
            ]
        );
        
            $restaurant = new Restaurant();
            $restaurant->name = $request->name;
            $restaurant->description = $request->description;
            $restaurant->location_id = $request->location_id;

            $newrestaurant = $restaurant->save();

            if($restaurant){
                return response()->json($restaurant, 201);
            }
            else{
                return "restaurant Not Saved.";
            }

    }

     public function index(){
        try{
             $restaurant = Restaurant::all();

             if($restaurant){
                return response()->json($restaurant);
             }
             else{
                 return "No restaurant Was found";
             }
         } catch(\Exception $e){
             return response()->json([
                 "Error"=>"No restaurant Was Found!"
             ]);
         }
     }


     public function getRestaurant($id){
         try{
             $restaurant = Restaurant::findOrFail($id);

             if($restaurant){
             return response()->json($restaurant);
            }
             else{
                 return "restaurant With id `$id` Was not found";
             }
         } catch(\Exception $e){
             return response()->json([
                 "Error"=>"restaurant Not Found!"
             ]);
         }
     }


    
     public function updaterestaurant(Request $request, $id){
         $request->validate(
             [
                 'name'=>'required',
                 'area_code'=>'location_id',
                 'location_id'=> 'required/integer/exists:locations,id'
             ]
         );

         try{
             $restaurant = Restaurant::findOrFail($id);
             if($restaurant){
                 $restaurant->name = $request->name;
                 $restaurant->area_code = $request->area_code;

             $newrestaurant = $restaurant->save();

             if($newrestaurant){
                 return response()->json($newrestaurant);
             }
         }
             else{
                 return "restaurant Not Saved.";
             }

         } catch(\Exception $e){
             return response()->json([
                 "Error"=>"restaurant Was not Created"
             ]);
         }
     }


     public function deleterestaurant($id){
         try {
             $existingrestaurant = Restaurant::findOrFail($id);
             if($existingrestaurant){
                 $existingrestaurant->destroy($id);
                 return response()->json("restaurant id `$id` Has been deleted!");
             }
             else{
                 return "restaurant Not Deleted.";
             }

         } catch(\Exception $e){
             return response()->json([
                 "Error"=>"restaurant Was not Deleted"
             ]);
         }
     }

}
