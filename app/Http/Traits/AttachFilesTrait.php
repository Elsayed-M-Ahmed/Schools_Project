<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait AttachFilesTrait
{

public function uploadfile($request , $name ,$folder_name) {

    $file_name = $request->file($name)->getClientOriginalName();

    $request->file($name)->storeAs('attachments/'.$folder_name,$file_name,'upload_attachments');
}
 
public function deletefile($name , $folder_name) {
    if (Storage::disk('upload_attachments')->exists('attachments/'.$folder_name.$name)) {
        Storage::disk('upload_attachments')->delete('attachments/'.$folder_name.$name);
    }
}
}    