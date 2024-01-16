<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    //上传图片
    public function image(Request $request)
    {
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $disk = Storage::disk('public');
                $photo = $request->file('image');
                $realPath = $photo->getRealPath();//临时文件路径
                $hash = hash_file('md5', $realPath);
                //查找文件是否已经存在
                $info = File::where('hash', $hash)->first();
                if($info){
                    //直接返回地址
                    return $this->returnJson(0, $disk->url($info['path']));
                }
                $extend = $photo->getClientOriginalExtension();
                $time = date('Y-m-d');
                $fileName = '/uploads/image/' . $time . '/' . $hash . '.' . $extend;
                $bool = $disk->put($fileName, file_get_contents($realPath));
                // 判断是否上传成功
                if ($bool) {
                    //写入数据库
                    $insert = [
                        'type' => File::TYPE_2,
                        'name' => $photo->getClientOriginalName(),
                        'hash' => $hash,
                        'mime_type' => $photo->getMimeType(),
                        'size' => $photo->getSize(),
                        'path' => $fileName,
                        'extend' => $extend,
                    ];
                    File::create($insert);
                    //php artisan storage:link 通过命令建立软连接到public下
                    return $this->returnJson(0, $disk->url($fileName));
                }
            }
            return $this->returnJson(1, null, '上传图片失败');
        } catch (\Throwable $e) {
            loger($request->route()->getActionName(), $e->getMessage());
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //上传文件
    public function file(Request $request)
    {
        try {
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $disk = Storage::disk('public');
                $file = $request->file('file');
                $realPath = $file->getRealPath();//临时文件路径
                $hash = hash_file('md5', $realPath);
                //查找文件是否已经存在
                $info = File::where('hash', $hash)->first();
                if($info){
                    //直接返回地址
                    return $this->returnJson(0, [
                        'name' => $info['name'],
                        'url' => $disk->url($info['path']),
                    ]);
                }
                $extend = $file->getClientOriginalExtension();
                $time = date('Y-m-d');
                $fileName = '/uploads/file/' . $time . '/' . $hash . '.' . $extend;
                $bool = $disk->put($fileName, file_get_contents($realPath));
                // 判断是否上传成功
                if ($bool) {
                    //写入数据库
                    $insert = [
                        'type' => File::TYPE_1,
                        'name' => $file->getClientOriginalName(),
                        'hash' => $hash,
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                        'path' => $fileName,
                        'extend' => $extend,
                    ];
                    $result = File::create($insert);
                    //php artisan storage:link 通过命令建立软连接到public下
                    return $this->returnJson(0, [
                        'name' => $insert['name'],
                        'url' => $disk->url($fileName),
                    ]);
                }
            }
            return $this->returnJson(1, null, '上传文件失败');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

}
