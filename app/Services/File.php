<?php
namespace App\Services;

use App\Interfaces\FileInterface;
use App\Models\File as ModelsFile;
use App\Models\Group_file;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\Storage;
use Psy\VersionUpdater\Downloader\FileDownloader;

class File implements FileInterface
{

    public function upload($attribute)
    {

              $file = new ModelsFile();
              $file->state = "free";

              if($attribute->hasFile('file'))
              {
                 // $filenamewithext=$request->file('image')->getClientOriginalName();
                  $file1=$attribute->file('file')->getClientOriginalName();
                  $filename=$file1;
                  $path=$attribute->file('file')->move('upload/',$filename);

                  $file->name=$filename;
                  $file->path=$path;
              }
              $file->user_id = auth('user')->user()->id ;
              $file->save();

            return redirect('files/index')->with('message', 'created succesfully!');

    }

    public function changeReserved($attribute,$id)
    {

        $file = ModelsFile::find($id);

        if($file->state == 'reserved' && $file->user_id == auth('user')->user()->id)
                  {
                    $file->state = 'free';
                    $file->reserved_id = null ;
                    $file->save();
                    return redirect('files/index')->with('message', 'changed succesfully!');

                  }

                  else if($file->state == 'free')
                  {
                    $file->state = 'reserved';
                    $file->reserved_id = auth('user')->user()->id ;
                    $file->save();

                    return redirect('files/index')->with('message', 'changed succesfully!');

                  }

                  else{
                    return redirect('files/index')->with('message', 'can not changed!');

                  }






            return response()->json(['file updated'], 200);

    }
    public function update($attribute,$id)
    {

        $file = ModelsFile::query()->find($id);
        $user = auth()->guard('user-api')->user();

        if($file->state != $user->id)
                  {
                    return response()->json([
                      'message' => 'File is un available!',
                    ], 401);
                  }


        if(!$attribute->file('filename'))
        {
            return response()->json(['update file not found'], 400);
        }

        $allowedfileExtension=['txt','docx','pdf','jpg','png'];
        $files = $attribute->file('filename');

            $extension = $files->getClientOriginalExtension();

            $check = in_array($extension,$allowedfileExtension);

            if($check) {

              $path = $file->path ;
              Storage::disk('mystorage')->delete($path );

              $name = $attribute->filename->getClientOriginalName();
              $path = Storage::disk('mystorage')->put('', $attribute->filename);

              $file->path = $path;
              $file->name = $name;
              $file->save();

            }
            else {
                return response()->json(['invalid_file_format'], 422);
            }

            $date = Carbon::now();
            $report = new Report();
            $report->file_id = $file->id ;
            $report->operation_name = "Update" ;
            $report->operation_date =  $date ;
            $report->user_name =  $user->name  ;
            $report->save();

            return response()->json(['file updated'], 200);

    }

    public function delete($id)
    {
        $file = ModelsFile::query()->find($id);
              if($file->state == "0")
                  {
                    Storage::delete($file->path);
                    $searchlist = Group_file::query()->where('file_id',$id)->get() ;
                    foreach($searchlist as $deletefile)
                    {
                      $deletefile->delete();
                    }

                    $date = Carbon::now();
                    $user= auth()->guard('user-api')->user();

                    $report = new Report();
                    $report->file_id = $file->id ;
                    $report->operation_name = "Delete" ;
                    $report->operation_date =  $date ;
                    $report->user_name =  $user->name  ;
                    $report->save();

                    $path = $file->path ;
                    Storage::disk('mystorage')->delete($path );
                    $file->delete();


                    return response()->json([
                      'message' => 'Deleted successfuly!',
                    ], 200);
                  }
                  else
                  {
                    return response()->json([
                      'message' => 'File is used!',
                  ], 401);
                  }

    }

    public function readfile($id)
    {
        $user= auth()->guard('user-api')->user();

        $file = ModelsFile::query()->find($id) ;
        if(!(($file->state==0)||($file->state==$user->id)))
        {
            return response()->json(['You cant open this file because it is being used'], 401);
        }

        $path = $file->path ;
        $name = $file->name ;
        $type = substr($name , strpos($name,'.')+1,strlen($name)-1);
        $download  = Storage::disk('mystorage')->get($path);
        $response = FacadesResponse::make($download, 200);
        $response->header('Content-Type', "application/$type");
        return $response;

    }

    public function checkIn($id)
    {

        $user= auth()->guard('user-api')->user();

        $file = ModelsFile::query()->find($id) ;
        if($file->state!=0)
        {
            return response()->json(['This file is already booked'], 401);
        }

        $file->state = $user->id ;
        $file->save();

        $date = Carbon::now();
        $report = new Report();
        $report->file_id = $file->id ;
        $report->operation_name = "Check in" ;
        $report->operation_date =  $date ;
        $report->user_name =  $user->name  ;
        $report->save();

        return response()->json([
            'The file is booked successfully!',
        ],200);
    }

    public function checkout($id)
    {
            $user= auth()->guard('user-api')->user();
            $file = ModelsFile::query()->find($id) ;
            if($file->state!=$user->id)
            {
                return response()->json(['wrong operation'], 401);
            }

            $file->state = 0 ;

            $file->save();

            $date = Carbon::now();
            $report = new Report();
            $report->file_id = $file->id ;
            $report->operation_name = "Check out" ;
            $report->operation_date =  $date ;
            $report->user_name =  $user->name  ;
            $report->save();

            return response()->json([

                'The file is unbooked successfully!',

            ],200);
    }

    public function BulkcheckIn($attribute)
    {

        $user= auth()->guard('user-api')->user();

        DB::beginTransaction();

        $booked = false ;
        foreach($attribute->ids as $id)
        {
            $file = ModelsFile::query()->find($id) ;

            if(!$file)
            return response()->json(['Invalid id'], 401);

            DB::table('files')
            ->where('id', $id)
            ->lockForUpdate()
            ->get();

            if($file->state!=0)
            {
                $booked = true ;
            }
        }

        foreach($attribute->ids as $id)
        {
           $file = ModelsFile::query()->find($id) ;
           $file->state = $user->id ;
           $file->save();
           $date = Carbon::now();
           $report = new Report();
           $report->file_id = $file->id ;
           $report->operation_name = "Check in" ;
           $report->operation_date =  $date ;
           $report->user_name =  $user->name  ;
           $report->save();

        }


        if($booked)
        {
            DB::rollBack();
            return response()->json([
                'Some files are booked !',
            ],401);
        }


        DB::commit();


        return response()->json([
            'All files are booked successfully!',
        ],200);
    }

    public function filestate($id)
    {
        $file = ModelsFile::find($id)->get();
        if($file[0]->state==0)
        return "free";
        else
        {
            return response()->json([
                "Booked for user {$file[0]->state}"
            ],200);
        }
    }

    public function filereport($id)
    {
        $reports = Report::where('file_id',$id)->get();
        $total_report = "" ;
        foreach($reports as $report)
        {
            $total_report .= "operation:$report[operation_name] , user:$report[user_name] , date:$report[operation_date]\n" ;
        }
        Storage::disk('mystorage')->put("/reports/file $id report.txt",$total_report );
        $download  = Storage::disk('mystorage')->get("/reports/file $id report.txt");
        $response = FacadesResponse::make($download, 200);
        $response->header('Content-Type', "application/txt");
        return $response;
    }


}
