<?php
namespace App\Services;

use App\Interfaces\UserInterface;
use App\Models\File;
use App\Models\Group;
use App\Models\Group_user;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class User implements UserInterface
{


    public function hello()
    {
        Cache::forever("jawad", "yessss");

        return response()->json(["done"], 200);
    }

    public function user_register($attribute)
    {

        $public = Group::query()->where('name','public')->get();

        if(sizeof($public)==0) {
            return response()->json(['The group (public) is not existed yet'], 401);
        }

        $public_id = $public[0]->id ;

        $info['name']=$attribute->name;
        $info['email']=$attribute->email;
        $info['password']=$attribute->password;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string','min:8'],
        ];

        $valid = Validator::make($info , $rules);

        if($valid->fails())
        {
            return response()->json([
                "success" => '0',
                "msg" => $valid->errors()->all()
            ], 422);
        }

        $user = ModelsUser::create([
            'name' => $attribute->name,
            'email' => $attribute->email,
            'password' => bcrypt($attribute->password),
            'role' => 'user'
        ]);

        $token = $user->createToken('Laravel-9-Passport-Auth')->accessToken;

        Group_user::create([
            'user_id' => $user->id ,
            'group_id' => $public_id ,
        ]);

        return response()->json(['token' => $token], 200);
    }

    public function admin_register($attribute)
    {

        $info['name']=$attribute->name;
        $info['email']=$attribute->email;
        $info['password']=$attribute->password;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string','min:8'],
        ];

        $valid = Validator::make($info , $rules);

        if($valid->fails())
        {
            return response()->json([
                "success" => '0',
                "msg" => $valid->errors()->all()
            ], 422);
        }

        $user = ModelsUser::create([
            'name' => $attribute->name,
            'email' => $attribute->email,
            'password' => bcrypt($attribute->password),
            'role' => 'admin',
        ]);

        $token = $user->createToken('Laravel-9-Passport-Auth')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function login($attribute)
    {
        $validator = Validator::make($attribute->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()],401);
        }

        if(auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'user']);

            $user = ModelsUser::select('users.*')->find(auth()->guard('user')->user()->id);
            $success =  $user;
            $success['token'] =  $user->createToken('MyApp',['user'])->accessToken;

            return response()->json($success, 200);
        }
        else
        {
            return response()->json(['error' => ['Email and Password are Wrong. 22']], 401);
        }
    }

    public function allUserGroups()
    {
        $user= auth()->guard('user-api')->user();
        $group_users = Group_user::where('user_id' , $user->id)->get() ;
        $collection=collect([]);
        if(sizeof($group_users)==0)
        return response()->json(['no groups found'], 401);

        foreach($group_users as $group_user){
            $group = Group::find($group_user->group_id);
            $usergroups=$collection->push($group);
        }
        return response()->json([ $usergroups], 200);

    }

    public function allUserOwnedGroups()
    {
        $user= auth()->guard('user-api')->user();
        $groups = Group::where('owner' , $user->id)->get() ;
        $collection=collect([]);
        if(sizeof($groups)==0)
        return response()->json(['no groups found'], 401);

        foreach($groups as $group){
            $group = Group::find($group->id);
            $usergroups=$collection->push($group);
        }
        return response()->json([ $usergroups], 200);

    }

    public function allUserFiles()
    {

        $user= auth('user')->user();
        $files = File::where('user_id',$user->id)->get();

        return view('pages.files.index')->with('files',$files);

    }
    public function ViewAddFile()
    {

        return view('pages.files.ViewAddFile');

    }

    public function adminAllFiles()
    {
        $user= auth()->guard('user-api')->user();
        if($user->role != "admin")
         return response()->json(['No premession'], 401);


        $files = File::all();
        if(sizeof($files)==0)
        return response()->json(['no files found'], 401);


        return response()->json([ $files], 200);
    }


}
