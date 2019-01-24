<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tag;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }
    
        return view('welcome', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        //tag保存
        $tagIds = [];
        $str = $request->content;
        //$str = preg_replace('/\n|\r\n|\r|( |　)+/', ' ', $str);
        $str = preg_replace('/\s+/', ' ', $str);
        $regex = '/#[\w｜ぁ-んァ-ヶ亜-熙|０-９]+(\s|$)/';
        preg_match_all($regex, $str, $matches);
        foreach($matches[0] as $match){
            $match = str_replace(' ','', $match);
            $tag = Tag::firstOrCreate([
                'tag_name' => $match,
            ]);
            $tagIds[] = $tag->id;
        }
        //中間テーブルへの登録
        $micropost = $request->user()->microposts()->orderBy('id', 'desc')->first();
        $micropost->tags()->sync($tagIds);
        return back();
    }
    
    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);
        
        if(\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }
        
        return back();
    }
}
