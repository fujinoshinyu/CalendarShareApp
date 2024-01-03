<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;    // 画像の保存に使用するStorageクラス
use Illuminate\Support\Facades\DB;         // DBの保存に使用
use Illuminate\Support\Facades\Log;        // エラーが発生した場合のログの保存に使用

use App\Models\profile;                    // DB「profiles」テーブルにデータを登録する際に使用

class ImageUploadController extends Controller
{
    // 入力画面の表示
    public function image()
    {
        return view('image_upload');
    }
    
    public function confirm(Request $request)
    {
        $request->validate([
            'name' => ['required','max:10'],
            'image' => ['image','mimes:jpeg,png,jpg,gif'],
        ]);

        $name = $request->name;
        $image = $request->file('image');

        if ($image) {
            // 拡張子の取得
            $extension = $image->getClientOriginalExtension();

            // 新しいファイル名を作る（ランダムな文字数とする）
            $new_name = uniqid() . "." . $extension;

            // 一時的にtmpフォルダに保存する
            $image_path = Storage::putFileAs(
                'tmp', $request->file('image'), $new_name
            );

        } else {
            $new_name = 'noimage.jpg';
            $extension = '0';
            $image_path = 'noimage.jpg';
        }

        return view('image_upload_confirm', compact('image_path','extension','name'));
    }
    
    public function complete(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = profile::create([  
                 "name" => $request->name,  
                "extension" => $request->extension,  
            ]);
            DB::commit();

            // 新しいファイル名を作る
            // この場合、IDをファイル名にしている↓
            $new_name = $data->id . '.' . $request->extension;
    
            if($request->image_path == 'noimage.jpg'){
                // ノーイメージ画像をコピーして、ユーザー毎の画像を用意する場合はこのコード↓
                // Storage::copy($request->image_path, 'img/'.$new_name);
    
                // 後々、Webサイトの改装時にノーイメージ画像を変更したい場合があるので、
                // 各ユーザー毎にノーイメージ画像を量産すると地獄を見るのでおすすめできません
                // 今回の場合、DBの「拡張子」カラムに「0」が登録されるように作ったので、
                // 拡張子が0ならノーイメージ画像を表示判定ができる仕様にしてみました
            } else {
                // 一時保存のtmpから本番の格納場所imgへ移動
                Storage::move($request->image_path, 'img/'.$new_name);
            }
    
            return view('image_upload_complete');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e);
            print_r('エラーが発生しました。');
            exit;
        }

    }

}
