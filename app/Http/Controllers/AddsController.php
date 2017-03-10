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

class AddsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 地址列表显示
     */
    public function index()
    {
        $tasks = Place::orderBy('created_at', 'DESC')->get();
        return view('admin.addr',compact('tasks'));
    }

    /**
     * 地址增加
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'addr' => 'required|max:255',
        ]);

        //日志记录，详见common/helpers
        Logs('1','增加了地址',($request->addr),'1');

        //增加任务
        $task = new Place;
        $task->user_id = (Auth::user()->name);
        $task->addr = $request->addr;
        $task->save();
        return back();
    }

    /**
     * 地址修改
     * @param Request $request
     * @param $addr
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,$addr)
    {
        //日志记录，详见common/helpers
        Logs('1','修改了地址',($request->addr),'1');
        Place::where('id',$addr)->update(['addr'=>($request->addr),'user_id'=>(Auth::user()->name)]);
        return back();

    }

    /**
     * 地址删除
     * @param $addr
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($addr)
    {
        //日志记录，详见common/helpers
        Logs('1','删除了地址',(Place::findOrFail($addr)->get()),'1');
        Place::findOrFail($addr)->delete();
        return back();
    }

}
