<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Traits\AttachFilesTrait;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{

    use AttachFilesTrait;

    public function index() {
        // return "true";
        $collection = Setting::all();
        $setting['setting'] = $collection->flatMap(function($collection) {
            return [$collection->key => $collection->value];
        }); 

        return view('pages.setting.index', $setting);
    }

    public function update(Request $request) {
        try {

            $info = $request->except('_token', '_method', 'logo');
            foreach ($info as $key => $value) {
                Setting::where(['key' => $key])->update(['value' => $value]);
            };
            
            if($request->hasFile('logo')) {
                $logo_name = $request->file('logo')->getClientOriginalName();
                Setting::where(['key' => 'logo'])->update(['value' => $logo_name]);
                $this->deletefile($logo_name , 'logo');
                $this->uploadfile($request , 'logo' , 'logo');
            }
            toastr()->success(trans('message.Update'));
            return back();
        } catch (\Exception $e){

            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
