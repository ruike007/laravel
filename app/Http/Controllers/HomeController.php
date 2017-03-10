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

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task = Task::where('team','<=',Auth::user()->token_id)->orderBy('created_at', 'DESC')->paginate(30);
        //自定义解密函数，见common、helpers.php
        $tasks = DecryptByMe($task);
        return view('home', compact('tasks'));
    }


    /**
     * 搜索函数
     * @param Request $request
     * @return 不同页面和结果
     */
    public function search(Request $request)
    {
        //模糊搜索出item.place.others是数据，并且权限不能低于当前用户
        $task = Task::where('team','<=',Auth::user()->token_id)->where('item','like','%'.$request->item.'%')
            ->orwhere('place','like','%'.$request->item.'%')->paginate(100);
        //自定义解密函数，见common、helpers.php
        $tasks = DecryptByMe($task);
        //用户等级判断，有编辑权限自动跳转到编辑页面
        if(Auth::user()->token_id > 1)
        {
            $addrs = Place::orderBy('created_at', 'ASC')->get();
            return view('task', compact('addrs','tasks'));
        }
        else return view('home', compact('tasks'));
    }


}
