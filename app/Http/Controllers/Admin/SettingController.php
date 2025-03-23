<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settingCount = Setting::count();
        if($settingCount > 0){
            $setting = Setting::first();
            return view('admin.setting.edit', compact('setting'));
        }else{
            return view('admin.setting.create');
        }
    }

    public function store(Request $request)
    {
        $input = $request->except(['_token']);
        Setting::create($input);
        return redirect()->route('setting.index' )->with('success', 'Setting Data Added successfully.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $setting = Setting::where('id', $id)->first();
        return view('admin.setting.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::where('id', $id)->first();
        $input = $request->all();
        unset($input['_token']);

        Setting::where('id', $id)->update($input);
        return redirect()->route('setting.index')->with('success', 'Setting Data Updated successfully.');
    }

    public function upload()
    {
        if ($request->hasfile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')-> getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $filename);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' =>$url]);
        }
    }
}