<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');
    }

    public function index(Request $request)
    {
        //  $data['users'] = User::all();


        $data['users'] = User::whereRoleIs('admin')->when($request->search, function ($q) use ($request) {
            return $q->where('first_name', 'like', '%' . $request->search . '%')->orWhere('last_name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(5);


        return view('dashboard.users.index')->with($data);
    }

    public function create()
    {
        return view('dashboard.users.create');
    }


    public function store(Request $request)
    {

        //dd($request->all());

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'img' => 'nullable|image|mimes:jpg,png,jpeg',
            'permissions' => 'required|exists:permissions,name',
        ]);

        $data = $request->except(['password', 'password_confirmation', 'permissions']);
        $data['password'] = bcrypt($request->password);

        $imgNewName = $data['img']->hashName();
        \Image::make($data['img'])->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('uploads/users/' . $imgNewName));

        $data['img'] = $imgNewName;

        //dd($data);
        $user = User::create($data);
        if ($request->permissions) {
            $user->attachRole('admin');
            $user->syncPermissions($request->permissions);
        }

        session()->flash('status', 'User added successfully!');
        return redirect(route('dashboard.users.index'));
    } //end of store user


    public function edit(User $user)
    {
        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {

        // dd($request->all());

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'img' => 'nullable|image|mimes:jpg,png,jpeg',
            'permissions' => 'required|exists:permissions,name',
        ]);

        $data = $request->except(['permissions']);

        if ($request->img) {
            if ($user->img !== 'default.png') {
                Storage::disk('uploads')->delete('users/' . $user->img);
            }

            $imgNewName = $data['img']->hashName();

            \Image::make($data['img'])->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/users/' . $imgNewName));

            $data['img'] = $imgNewName;
        }

        $user->update($data);
        if ($request->permissions) {
            $user->syncPermissions($request->permissions);
        } else {
            $permissions = ['create_users', 'read_users', 'update_users', 'delete_users', 'create_cats', 'read_cats', 'update_cats', 'delete_cats'];
            $user->detachPermissions($permissions);
        }


        session()->flash('status', 'User updated successfully!');
        return redirect(route('dashboard.users.index'));
    } //end of update user


    public function destroy(User $user)
    {
        if ($user->img !== 'default.png') {
            Storage::disk('uploads')->delete('users/' . $user->img);
        }

        $user->delete();
        session()->flash('status', 'User deleted successfully!');
        return redirect(route('dashboard.users.index'));
    } //end of destroy user
}
