<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\captain;
use App\Models\customer;
use App\Models\delivery;
use App\Models\User;
use App\Models\vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {


        try {
            if($request->type == "customer")
            {
                $user = customer::where('phone_number',$request->phone_number)->first();
                if(!$user)
                return response()->json(
                    [
                           'status' => false,
                           'message'=>'Credentials is wrong',
                       ],401);
               // return Hash::check($request->password, $user->password);
               if(Hash::check($request->password, $user->password))
               {
                   $token=$user->createToken('myauth')->plainTextToken;

                       return response()->json([
                           'status' => true,
                           'message'=>'welcome',
                           'token' => $token,
                           'data' => $user,
                       ],200);
               }
                else
                {
                    return response()->json([
                        'status' => true,
                        'message'=>"Credentials is wrong",
                        ],401);
                }
            }
            elseif($request->type == "vendor")
            {

                $user = vendor::where('phone_number',$request->phone_number)->first();
                if(!$user)
                return response()->json(
                    [
                           'status' => false,
                           'message'=>'Credentials is wrong',
                       ],401);
               // return Hash::check($request->password, $user->password);
               if(Hash::check($request->password, $user->password))
               {
                   $token=$user->createToken('myauth')->plainTextToken;

                       return response()->json([
                           'status' => true,
                           'message'=>'welcome',
                           'token' => $token,
                           'data' => $user,
                       ],200);
               }
                else
                {
                    return response()->json([
                        'status' => true,
                        'message'=>"Credentials is wrong",
                        ],401);
                }
            }
            elseif($request->type == "captain")
            {

                $user = captain::where('phone_number',$request->phone_number)->first();
                if(!$user)
                return response()->json(
                    [
                           'status' => false,
                           'message'=>'Credentials is wrong',
                       ],401);
               // return Hash::check($request->password, $user->password);
               if(Hash::check($request->password, $user->password))
               {
                   $token=$user->createToken('myauth')->plainTextToken;

                       return response()->json([
                           'status' => true,
                           'message'=>'welcome',
                           'token' => $token,
                           'data' => $user,
                       ],200);
               }
                else
                {
                    return response()->json([
                        'status' => true,
                        'message'=>"Credentials is wrong",
                        ],401);
                }
            }
            elseif($request->type == "delivery")
            {

                $user = delivery::where('phone_number',$request->phone_number)->first();
                if(!$user)
                return response()->json(
                    [
                           'status' => false,
                           'message'=>'Credentials is wrong',
                       ],401);
               // return Hash::check($request->password, $user->password);
               if(Hash::check($request->password, $user->password))
               {
                   $token=$user->createToken('myauth')->plainTextToken;

                       return response()->json([
                           'status' => true,
                           'message'=>'welcome',
                           'token' => $token,
                           'data' => $user,
                       ],200);
               }
                else
                {
                    return response()->json([
                        'status' => true,
                        'message'=>"Credentials is wrong",
                        ],401);
                }
            }
            elseif($request->type == "admin")
            {

                $user = admin::where('phone_number',$request->phone_number)->first();
                if(!$user)
                return response()->json(
                    [
                           'status' => false,
                           'message'=>'Credentials is wrong',
                       ],401);
               // return Hash::check($request->password, $user->password);
               if(Hash::check($request->password, $user->password))
               {
                   $token=$user->createToken('myauth')->plainTextToken;

                       return response()->json([
                           'status' => true,
                           'message'=>'welcome',
                           'token' => $token,
                           'data' => $user,
                       ],200);
               }
                else
                {
                    return response()->json([
                        'status' => true,
                        'message'=>"Credentials is wrong",
                        ],401);
                }
            }

            else{
                return response()->json(
                    [
                           'status' => false,
                           'message'=>'something went wrong wrong',
                       ],400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }

    }

    public function signup(Request $request)
    {
        try {
            if($request->type == "customer")
            {

                $user = new customer();
                $user->name = $request->name;
                $user->name = $request->name;
                $user->password = Hash::make($request->password);
                $user->title = $request->title;
                $user->location_id = $request->location_id;
                $user->save();
            }
            elseif($request->type == "vendor")
            {

                $user = new vendor();
                $user->phone_number = $request->phone_number;
                $user->password = Hash::make($request->password);
                $user->save();
            }
            elseif($request->type == "captain")
            {

                $user = new captain();
                $user->name = $request->name;
                $user->phone_number = $request->phone_number;
                $user->password = Hash::make($request->password);
                $user->location_id = $request->location_id;
                $user->save();
            }
            elseif($request->type == "delivery")
            {

                $user = new delivery();
                $user->phone_number = $request->phone_number;
                $user->name = $request->name;
                $user->password = Hash::make($request->password);
                $user->vehicle_information = $request->vehicle_information;
                $user->captain_id = $request->captain_id;
                $user->save();
            }
            elseif($request->type == "admin")
            {

                $user = new admin();
                $user->phone_number = $request->phone_number;
                $user->name = $request->name;
                $user->special_code = $request->special_code;
                $user->password = Hash::make($request->password);
                $user->email = $request->email;
                $user->save();
            }
            else
            {
                    return response()->json(
                        [
                               'status' => false,
                               'message'=>'something went wrong wrong',
                           ],400);
            }

            return response()->json([
                'status' => true,
                'message' => "you created ".$request->type." successfully",
                'data' => $user

            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }




    function addShopWithLocation(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'photo' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'latitude' => 'numeric|between:-90,90',
            'longitude' =>'numeric|between:-180,180',
         //   'vendor_id' => 'required|exists:vendors,id',
            'category_id' => 'required|exists:categories,id',

        ]);
        $location = new location([
            'street' => $request->street,
            'city' => $request->city,
            'building' => $request->building,
            'floor' => $request->floor,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);
        $location->save();


/*
        $shop = new shop([
            'name' => $request->name,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'photo' => $request->photo,

            'vendor_id' => auth('vendor')->user()->id,
            'category_id' => $request->category_id
        ]);
*/


$shop = new shop();

if($request->hasFile('photo'))
{
   // $filenamewithext=$request->file('image')->getClientOriginalName();
    $file=$request->file('photo')->getClientOriginalName();
    $filename=$file;
    $path=$request->file('photo')->move('upload/image_product/',$filename);

    $shop->photo=$filename;
}




        $shop->name = $request->input('name');
        $shop->description = $request->input('description');
        $shop->phone_number = $request->input('phone_number');
        //$shop->photo = $request->input('photo');
        $shop->vendor_id = auth('vendor')->user()->id;
        $shop->category_id = $request->input('category_id');



        $shop->locatio_id = $location->id;
        $shop->save();

        // Return a success message
        return response()->json(['message' => 'طلبك  قيد المعالجة']);
    }
}
