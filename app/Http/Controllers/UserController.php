<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
 
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest('id')->get();
        $users = $users->sortBy('number');
        return view('admin.index', compact('users'));
    }
 
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Add New User";
        $countries = ['Indonesia', 'Malaysia', 'Singapura', 'Thailand', 'Vietnam'];
        $positions = ['CF', 'SS', 'RWF', 'LWF', 'AMF', 'RMF', 'LMF', 'DMF', 'RB', 'LB', 'CB', 'GK'];
        $allNumbers = range(1, 99); 
        $usedNumbers = User::pluck('number')->toArray();
        $availableNumbers = array_diff($allNumbers, $usedNumbers);
        return view('admin.add_edit_user', compact('title', 'countries', 'positions', 'availableNumbers'));
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'age' => 'required',
                'country' => 'required',
                'position' => 'required|array', 
                'position.*' => 'string',
                'number' => 'required|integer|unique:users,number',
                'value' => 'required|integer',
                'email' => 'nullable|email|unique:users,email',
                'photo' => 'mimes:png,jpeg,jpg|max:2048',
            ]
        );
 
        $filePath = public_path('uploads');

        $insert = new User();
        $insert->name = $request->name;
        $insert->age = $request->age;
        $insert->country = $request->country;
        $insert->position = json_encode($request->position);
        $insert->number = $request->number;
        $insert->value = $request->value;
        $insert->email = $request->email;
        $insert->password = bcrypt('password');
 
 
        if ($request->hasfile('photo')) {
            $file = $request->file('photo');
            $file_name = time() . $file->getClientOriginalName();
 
            $file->move($filePath, $file_name);
            $insert->photo = $file_name;
        }
 
        $result = $insert->save();
        Session::flash('success', 'User registered successfully');
        return redirect()->route('user.index');
    }
 
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Update User";
        $edit = User::findOrFail($id);
        $countries = ['Indonesia', 'Malaysia', 'Singapura', 'Thailand', 'Vietnam'];
        $positions = ['CF', 'SS', 'RWF', 'LWF', 'AMF', 'RMF', 'LMF', 'DMF', 'RB', 'LB', 'CB', 'GK'];
        $allNumbers = range(1, 99); 
        $usedNumbers = User::where('id', '!=', $id)->pluck('number')->toArray();
        $availableNumbers = array_diff($allNumbers, $usedNumbers);
        return view('admin.add_edit_user', compact('edit', 'title', 'countries', 'positions', 'availableNumbers'));
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'age' => 'required',
                'country' => 'required',
                'position' => 'required|array',
                'position.*' => 'string',
                'number' => 'required|integer|unique:users,number,' . $id,
                'value' => 'required|integer',
                'email' => 'nullable|email|unique:users,email',
                'photo' => 'mimes:png,jpeg,jpg|max:2048',
            ]
        );
        $update = User::findOrFail($id);
        $update->name = $request->name;
        $update->age = $request->age;
        $update->country = $request->country;
        $update->position = json_encode($request->position);
        $update->number = $request->number;
        $update->value = $request->value;
        $update->email = $request->email;
 
        if ($request->hasfile('photo')) {
            $filePath = public_path('uploads');
            $file = $request->file('photo');
            $file_name = time() . $file->getClientOriginalName();
            $file->move($filePath, $file_name);
            // delete old photo
            if (!is_null($update->photo)) {
                $oldImage = public_path('uploads/' . $update->photo);
                if (File::exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $update->photo = $file_name;
        }
 
        $result = $update->save();
        Session::flash('success', 'User updated successfully');
        return redirect()->route('user.index');
    }
 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $userData = User::findOrFail($request->user_id);
        $userData->delete();
        // delete photo if exists
        if (!is_null($userData->photo)) {
            $photo = public_path('uploads/' . $userData->photo);
            if (File::exists($photo)) {
                unlink($photo);
            }
        }
        Session::flash('success', 'User deleted successfully');
        return redirect()->route('user.index');
    }
}