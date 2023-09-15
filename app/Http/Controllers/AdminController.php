<?php

namespace App\Http\Controllers;

use App\Models\{
    Category,
    Contestant,
    Payment,
    Setting,
    SystemSetting
};
use Illuminate\Http\Request;
use Str;

class AdminController extends Controller
{
    //

    function index(){
        $category = Category::all();
        $data = Contestant::orderByDesc('votes')->paginate(20);
        return view('admin.index', compact('data','category'));
    }

    function profile(){
        return view('admin.profile');
    }

    // Contest Category
    function categories(){
        $data = Category::paginate(30);
        return view('admin.category', compact('data'));
    }
    function create_category(Request $request){
        $data = new Category();
        $data->name = $request->name;
        $data->slug = uniqueSlug($request->name, 'categories');
        $data->status = 1;
        $data->save();

        return back()->withSuccess('Category Created Successfully');
    }
    function edit_category($id,Request $request){
        $data = Category::findOrFail($id);
        $data->name = $request->name;
        $data->slug = uniqueSlug($request->name, 'categories');
        $data->status = $request->status;
        $data->save();

        return back()->withSuccess('Category Updated Successfully');
    }
    function delete_category($id){
        Category::findOrFail($id)->delete();
        return back()->withSuccess("Category Deleted Successfully");
    }
    function category_contestants($slug){
        $category = Category::all();
        $parent = Category::whereSlug($slug)->first();
        $data = Contestant::whereCategoryId($parent->id)->paginate(20);
        $title = "{$parent->name} Contestants";
        return view('admin.contestant', compact('data','category','title'));
    }

    function contestants(){
        $category = Category::all();
        $data = Contestant::orderByDesc('id')->paginate(20);
        $title = "All Contestants";
        return view('admin.contestant', compact('data','category','title'));
    }

    function create_contestant(Request $request){
        $input = $request->all();
        $input['slug'] = uniqueSlug($request->name, 'contestants');
        if($request->hasFile('image')){
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = Str::random(30). '.' . $extension; // Generating a random string of 20 characters plus the file extension
            $image->move(public_path('uploads/contestants'), $imageName);
            $input['image'] = 'contestants/'.$imageName;
        }
        $service = Contestant::create($input);

        return back()->withSuccess('Contestant Created Successfully');
    }
    function update_contestant($id, Request $request){
        $input = $request->all();
        if($request->hasFile('image')){
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = Str::random(25). '.' . $extension; // Generating a random string of 20 characters plus the file extension
            $image->move(public_path('uploads/contestants'), $imageName);
            $input['image'] = 'contestants/'.$imageName;
        }
        $service = Contestant::findOrFail($id)->update($input);

        return back()->withSuccess('Contestant Updated Successfully');
    }
    function delete_Contestant($id){
        Contestant::findOrFail($id)->delete();
        return back()->withSuccess("Category Deleted Successfully");
    }
    // Results
    function all_results() {
        $contests = Category::where('status', 1)->get();
        return view('admin.result.index' , compact('contests'));
    }
    function view_result($id)
    {
        $contest = Category::find($id);
        // get Contestants
        $contestants = Contestant::where('category_id', $contest->id)->OrderByDesc('votes')->get();
        // dd($contestants);
        return view('admin.result.view', compact('contest','contestants'));
    }

    // Settings
    function payment_settings(){
        return view('admin.settings.payment');
    }
    function settings(){
        return view('admin.settings.index');
    }
    function update_settings(Request $request){
        $input = $request->all();
        if($request->hasFile('favicon')){
            $image = $request->file('favicon');
            $imageName = 'favicon.png';
            $image->move(public_path('uploads'),$imageName);
            $input['favicon'] =$imageName;
        }
        if($request->hasFile('logo')){
            $image = $request->file('logo');
            $imageName = 'logo.png';
            $image->move(public_path('uploads'),$imageName);
            $input['logo'] =$imageName;
        }
        if($request->hasFile('sponsor')){
            $image = $request->file('sponsor');
            $imageName = Str::random(13).'.png';
            $image->move(public_path('uploads'),$imageName);
            $input['sponsor'] =$imageName;
        }
        if($request->hasFile('banner')){
            $image = $request->file('banner');
            $imageName = Str::random(13).'.png';
            $image->move(public_path('uploads'),$imageName);
            $input['banner'] =$imageName;
        }

        $setting = Setting::first();
        $setting->update($input);

        return redirect()->back()->with('success',__('Settings Updated Successfully.'));
    }
    public function store_settings(Request $request)
    {
        foreach ($request->types as $key => $type) {
            $this->overWriteEnvFile($type, $request[$type]);
        }
        return back()->withSuccess("Settings updated successfully");

    }
    function systemUpdate(Request $request)
    {
        $setting = SystemSetting::where('name', $request->name)->first();
        if($setting !=null){
            $setting->value = $request->value;
            $setting->save();
        }
        else{
            $setting = new SystemSetting();
            $setting->name = $request->name;
            $setting->value = $request->value;
            $setting->save();
        }

        return '1';
    }
    public function overWriteEnvFile($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                file_put_contents($path, str_replace(
                    $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                ));
            }
            else{
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }
    }


    // reports
    function payment_history(){
        $payments = Payment::orderByDesc('id')->paginate(30);
        return view('admin.report.payment', compact('payments'));
    }

    function vote_history(){
        return view('admin.report.vote');
    }
}
