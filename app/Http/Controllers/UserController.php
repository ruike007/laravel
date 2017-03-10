<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Task;
use App\User;
use App\Place;
use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Session;
use \Illuminate\Support\Facades\Crypt;
use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *管理员用户管理
     * 列表显示
     */
    public function index()
    {
        $name = Auth::user()->name;
        return view('user', compact('name'));
    }

    /**
     *修改密码
     * @param $admin
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

            $this->validate($request,[
                'password_old' => 'required|max:64|min:6',
                'password' => 'required|confirmed|max:64|min:6',
            ], [
                'password_old.required' => '原始密码不能为空',
                'password_old.max' => '原始密码太长',
                'password_old.min' => '原始密码太短，不能少于6位数',

                'password.required' => '新的密码不能为空',
                'password.max' => '新的密码太长',
                'password.min' => '新的密码太短，不能少于6位数',
                'password.confirmed' =>'两次密码不一致',

            ]);
            $old = $request->password_old;
            $res = Auth::user()->password;

            if(Hash::check($old, $res) )
            {
                $psw_new = bcrypt($request->password_new);
                User::where('id',Auth::user()->id)->update(['password'=>$psw_new]);

               session()->flash('success','密码修改成功，请牢记您的新密码');
                return redirect('/user');
            }
            else
            {
                return redirect('/user')
                    ->withInput()
                    ->withErrors('初始密码错误');
            }
            return redirect('/user');
        }


}
