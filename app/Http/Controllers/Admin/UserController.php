<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\DataTables\UsersDataTable;
use Auth;


class UserController extends Controller
{
    /**
     * Show the dashboard of the admin panel.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(){
        return view('admin.index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        if(request()->encode){
            ini_set('memory_limit', '4576M');
            ini_set('max_execution_time', 3000);
            foreach (User::get() as $user) {
                if($user->profile_picture)
                    $user->encode($user->profile_picture, ['ext'=>'jpg','sizes'=>User::$profile_picture_sizes]);
                if($user->store_logo)
                    $user->encode($user->store_logo, ['ext'=>'jpg','sizes'=>User::$profile_picture_sizes]);
                if($user->store_banner)
                    $user->encode($user->store_banner, ['ext'=>'jpg','w'=>1180, 'h'=>300, 'allowed'=>['o', '', 's']]);
            }
            dd('done');
        }
        return $dataTable->render('admin.users.users');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.add-admin');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $admin = new User;
        $admin->slug = uniqid();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->role_id = User::ROLE_ADMIN;
        $admin->email_verified_at = now();

        if($admin->save()){
            $admin->profile_picture = null;
            $admin->upload_profile_picture($request->file('profile_picture'));
            return redirect()->back()->with(['success' => 'Admin was added successfully.']);
        } else {
            return redirect()->back()->with(['failure' => 'Error! Something went wrong, please try again.']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user=null)
    {
        $user = $user ? $user : Auth::user();
        return view('admin.users.user')->with('user', $user);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('admin.users.edit-admin-profile')->with('admin', Auth::user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $admin = Auth::user();

        if(!isset($request->password) || !Hash::check($request->password, $admin->password))
            return response()->json(__('Wrong Password'), 500);

        $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$admin->id,
            'profile_picture' => 'image|max:8192',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        $admin->upload_profile_picture($request->file('profile_picture'));
        
        if($admin->save()){
            return response()->json(__('Saved Successfully'), 200);
        } else {
            return response()->json(__('An Error Occured, Please try again.'), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'new_password' => 'required|min:8|confirmed',
            'password' => 'required',
        ]);

        if(Hash::check($request->password, $admin->password)){
            $admin->password = Hash::make($request->new_password);
        
            if($admin->save()){
                return response()->json(__('Saved Successfully'), 200);
            } else {
                return response()->json(__('An Error Occured, Please try again.'), 500);
            }
        } else {
            return response()->json(__('Wrong Password'), 500);
        }
    }


    /**
     * Toggle user's state.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function toggle_active_state($user)
    {
        $user = User::find($user);
        if($user && !$user->is_superadmin()) {
            $user->active = !$user->active;
            if( $user->save() ){
                return response()->json(__('Saved Successfully'), 200);
            }
        }
        return response()->json(__('An Error Occured, Please try again.'), 500);
    }


    /**
     * Change user role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function change_user_role(Request $request, $user)
    {
        $user = User::findOrFail($user);
        $request->validate([
            'role' => 'required|in:'. User::ROLE_ADMIN .','. USER::ROLE_USER
        ]);

        if(!$user->is_superadmin()) {
            $user->role_id = $request->role;
            if( $user->save() ){
                return response()->json( $user->role() , 200);
            }
        }
        return response()->json(__('An Error Occured, Please try again.'), 500);
    }
}
