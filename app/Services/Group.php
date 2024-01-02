<?php
namespace App\Services;

use App\Interfaces\GroupInterface;
use App\Models\File;
use App\Models\Group as ModelsGroup;
use App\Models\Group_file;
use App\Models\Group_user;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class Group implements GroupInterface
{
   

    public function allGroupFiles($id)
    {
        $files = Cache::get($id);
        if($files==null)
        return response()->json([
            "no files"
        ],401);
        

        return response()->json([
            $files
        ],200);

    }

    public function allGroupUsers($id)
    {
        $group_users = Group_user::where('group_id',$id)->get();
        if(sizeof($group_users)==0)
        return  response()->json(["no users"], 200);  

        $collection=collect([]);
        foreach($group_users as $group_user){
            $user = User::find($group_user->user_id);
            $usersIngroup=$collection->push($user);
        }
        return  response()->json(["1"=>$usersIngroup], 200);  
    }

    public function createGroup($attribute)
    {
        if(!$attribute->group_name) {
            return response()->json(['No group name'], 401);
        }

        $groups = ModelsGroup::query() ;
        $group = $groups->where('name',$attribute->group_name)->get();
        if(sizeof($group)!=0) {
            return response()->json(['The group is already existed'], 401);
        }

        $user= auth()->guard('user-api')->user();

        $group = new ModelsGroup();
        $group->name = $attribute->group_name ;
        $group->owner = $user->id ; 
        $group->save();

        $joingroup = new Group_user();
        $joingroup->user_id =  $user->id ;
        $joingroup->group_id =  $group->id ;
        $joingroup->save();

        return response()->json([
            'message' => 'The group is created successfully!',
        ],200);
    }

    public function deleteGroup($id)
    {
        $group = ModelsGroup::query()->find($id);
        
        $filesInGroup = Group_file::query() ;
        $fileG = $filesInGroup->where('group_id',$id)->get();
        if(sizeof($fileG)==0) {
            $group->delete();
            $usersInGroup = Group_user::query() ;
            $usersInGroup->where('group_id',$id)->delete();
            return response()->json(['Deleted successfully!'], 200);
        }

        foreach($fileG as $file)
        {
           $search = File::query()->find($file->file_id) ;
           if($search->state!=0)
           return response()->json(["Delete failed because some file are being used"], 401);
        }

        $filesInGroup = Group_file::query() ;
        $filesInGroup->where('group_id',$id)->delete();
        $usersInGroup = Group_user::query() ;
        $usersInGroup->where('group_id',$id)->delete();

        $group->delete();
        Cache::delete($id);
        return response()->json([
            'Deleted successfully'
        ],200);
    }

    public function addFileToGroup($attribute,$id)
    {
        $group = ModelsGroup::query()->where('name',$attribute->group_name)->get();
        
        $searchlist = Group_file::query() ;
        $search = $searchlist->where('group_id',$group[0]->id)->where('file_id',$id)->get();

        if(sizeof($search)!=0) {
            return response()->json(['The file is already in this group'], 401);
        }

        $group_file = new Group_file();
        $group_file->group_id = $group[0]->id ;
        $group_file->file_id = $id ; 
        $group_file->save();

        
        $groupfiles = Cache::get($group[0]->id);
        $new_array = array();
        if($groupfiles!=null)
        {       
            foreach($groupfiles as $groupfile)    
            {
            array_push($new_array,$groupfile);
            }  
            Cache::delete($group[0]->id);
        } 
         
        array_push($new_array,$id);
           
        Cache::forever($group[0]->id, $new_array);
        

        return response()->json([
            'message' => 'The file is added successfully!',
        ],200);

    }

    public function deleteFileFromGroup($attribute,$id)
    {
        
        $group = ModelsGroup::query()->where('name',$attribute->group_name)->get();
       
        $searchlist = Group_file::query() ;
        $search = $searchlist->where('group_id',$group[0]->id)->where('file_id',$id)->get();

        $file = File::query()->find($id);
        if($file->state!=0) {
            return response()->json(['cant remove this file because it is being used'], 401);
        }

        $group_file = Group_file::query()->find($search[0]->id);
        $group_file->delete();

        $groupfiles = Cache::get($group[0]->id);
        Cache::delete($group[0]->id); 
        $index = array_search($id, $groupfiles);
        unset($groupfiles[$index]);
        Cache::forever($group[0]->id,$groupfiles);

        return response()->json([
            'message' => 'The file is removed successfully!',
        ],200);
    }

    public function addUserToGroup($attribute,$id)
    {
        $newuser = User::query()->find($id);
        $user= auth()->guard('user-api')->user();

        if(!$newuser) {
            return response()->json(['Invalid user id'], 401);
        } 
        
        if(!$attribute->group_name) {
            return response()->json(['No group name'], 401);
        }

        $groups = ModelsGroup::query() ;
        $group = $groups->where('name',$attribute->group_name)->get();
        if(sizeof($group)==0) {
            return response()->json(['The group is not existed'], 401);
        }

        if($group[0]->owner != $user->id) {
            return response()->json(['You dont have access to add on this group'], 401);
        }

        $searchlist = Group_user::query() ;
        $search = $searchlist->where('group_id',$group[0]->id)->where('user_id',$id)->get();

        if(sizeof($search)!=0) {
            return response()->json(['The user is already in this group'], 401);
        }

        $group_user = new Group_user();
        $group_user->group_id = $group[0]->id ;
        $group_user->user_id = $id ; 
        $group_user->save();

        return response()->json([
            'message' => 'The user is added successfully!',
        ],200);
    }

    public function deleteUserFromGroup($attribute,$id)
    {
        $user= auth()->guard('user-api')->user();

        $group = ModelsGroup::query()->where('name',$attribute->group_name)->get();
        if($group[0]->owner != $user->id) {
            return response()->json(['You dont have access to delete from this group'], 401);
        }

        if($user->id == $id)
        {
            return response()->json(['wrong operation'], 401);

        }

        $groups = ModelsGroup::query() ;
        $group = $groups->where('name',$attribute->group_name)->get();
        if(sizeof($group)==0) {
            return response()->json(['The group is not existed'], 401);
        }

        $searchlist = Group_user::query() ;
        $search = $searchlist->where('group_id',$group[0]->id)->where('user_id',$id)->get();

        if(sizeof($search)!=0) {
            return response()->json(['The user is already in this group'], 401);
        }
        
        $user_files = File::query()->where('state',$id)->get();
        foreach($user_files as $file)
        {
            $resault = Group_file::query()->where('group_id',$group[0]->id)->where('file_id',$file->id)->get();
            if(sizeof($resault)!=0)
            {
                return response()->json(['This user is using some files in this group'], 401);

            }
        }
       
        Group_user::query()->where('group_id',$group[0]->id)->where('user_id',$id)->delete();

        return response()->json([
            'message' => 'The user is removed successfully!',
        ],200);
    }

     

    public function deleteCash()
    {

        Cache::flush();

        return response()->json([
            "Cash deleted"
        ],200);
    }

}
