<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Task;
use App\User;
use App\Place;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Session;
use \Illuminate\Support\Facades\Crypt;
use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
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
        $tasks = User::orderBy('created_at', 'DESC')->get();
        return view('admin', compact('tasks'));
    }

    /**
     * 删除用户
     * @param $admin
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($admin)
    {
        if($admin == (Auth::user()->id)){
            //日志记录，详见common/helpers
            Logs('4','企图删除自己ID',($admin),'0');

            return redirect('/admin')
                ->withInput()
                ->withErrors('用户无法删除自己');
        }
        //日志记录，详见common/helpers
        Logs('4','删除了用户',(User::findOrFail($admin)->get()),'1');

        User::findOrFail($admin)->delete();

        return redirect('/admin');
    }

    /**
     * 更新数据
     * @param Request $request
     * @param $admin
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request,$admin)
    {
        $this->validate($request,[
            'name' => 'required|max:64',
            'email' => 'required|email|max:128',
            'token_id' => 'required|numeric|between:0,1'
        ]);

        //日志记录，详见common/helpers
        Logs('3','修改了用户',(User::findOrFail($admin)->get()),'1');

        User::where('id',$admin)->update(['name'=>($request->name),'email'=>($request->email),'token_id'=>($request->token_id)]);
        return redirect('/admin');

    }
}
