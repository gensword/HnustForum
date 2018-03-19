<?php

namespace App\Http\Controllers;

use App\Husers;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HiManController extends Controller
{
    private function saveImg($user_id, $url, $gender=0){
        $newPhoto = new Photo;
        $newPhoto->url = $url;
        $newPhoto->user_id = $user_id;
        $newPhoto->gender = $gender;
        $newPhoto->save();
    }

    public function showImages(Request $request){
        if($request->gender == 'man')
            $gender = 0;
        else $gender = 1;
        $photos = Photo::where('gender', $gender)->get()->shuffle()->all();
        //dd($photos);
        return view('miai.miai', ['photos' => $photos]);
    }

    public function showUploadPage(Request $request){
        return view('miai.uploadImg');
    }

    public function postImages(Request $request){
        $this->validate($request, ['file' => 'bail|required|image|max:5000']);

        $disk = Storage::disk('qiniu');
        $time = date('Y/m/d-H:i:s');
        $filename = $disk->put($time, $request->file('file'));//上传七牛云
        if(!$filename) {
            return response()->json([
                'status' => 0
            ]);
        }
        $img_url = $disk->getDriver()->downloadUrl($filename); //获取下载链接
        $this->saveImg($request->user_id, $img_url, $request->gender == 'man'? 0 : 1);
        return response()->json([
            'status' => 1,
            'imgUri' => $img_url
        ]);
    }
}
