<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Eml;
use Illuminate\Support\Facades\Storage;
use MimeMailParser\Parser;
use MimeMailParser\Attachment;
use Maatwebsite\Excel\Facades\Excel;


use App\Http\Requests;

class EmlController extends Controller
{
    public function index()
    {
        return view('EmlUpload');
    }

    public function upload(Request $request)
    {
        if ($request->isMethod('post')) {

            $file = $request->file('picture');

            // 文件是否上传成功
            if ($file->isValid()) {

                $parser = new Parser();
                $parser->setPath($file);

                $to = $parser->getHeader('to');
                $subject = $parser->getHeader('subject');
                $text = $parser->getMessageBody('text');

                //收件人字符串截取
                $user =substr($to,0,strpos($to, '<')); //用户
                $email = substr($to,strpos($to,'<')); //邮箱
                //$texts = substr($text,0,strpos($text,'VICTOR ELECTRONIC CO')); //内容

                $eml = new Eml;
                $eml->sendUser = $user;
                $eml->email = $email ;
                $eml->text  = $text;
                $eml->save();

                session()->flash('success','导入成功啦！');
                return redirect('/eml/');
                /**
                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpeg

                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用我们新建的uploads本地存储空间（目录）
                $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                var_dump($bool);
                 **/

            }

        }

        return redirect('/eml/')->withErrors('导入失败');
    }

    public function download()
    {
        $eml_data = Eml::orderBy('created_at', 'DESC')->get();
        $cellData=eml_chage($eml_data);

        Excel::create('邮件导出',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');

        return view('EmlUpload');
    }

    public function jQupload()
    {
        $output_dir = "uploads/";
        if(isset($_FILES["myfile"]))
        {
            $ret = array();

            //	这是针对自定义错误;;
            /*	$custom_error= array();
                $custom_error['jquery-upload-file-error']="文件已存在";
                echo json_encode($custom_error);
                die();
            */
            $error =$_FILES["myfile"]["error"];
            ////你需要处理这两种情况
            //如果任何浏览器不支持使用FormData（）序列化多个文件
            if(!is_array($_FILES["myfile"]["name"])) //单个文件
            {
                $fileName = $_FILES["myfile"]["name"];
                move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
                $ret[]= $fileName;
            }
            else  //多个文件, file[]
            {
                $fileCount = count($_FILES["myfile"]["name"]);
                for($i=0; $i < $fileCount; $i++)
                {
                    $fileName = $_FILES["myfile"]["name"][$i];
                    move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
                    $ret[]= $fileName;
                }

            }
            echo json_encode($ret);
        }
    }
}
