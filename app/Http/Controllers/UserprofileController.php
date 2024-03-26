<?php

namespace App\Http\Controllers;

use App\Models\Userprofile;
use App\Models\Interest;
use App\Models\Event;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserprofileController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return view('userprofiles/new');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // すべての興味・関心を取得
        $interests = Interest::all();

        // ビューに興味・関心のリストを渡す
        return view('userprofiles.new', compact('interests'));    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'profile_name' => 'required',
            'picture' => 'nullable|image|max:204800000',
            'link_x' => 'nullable',
            'link_fb' => 'nullable',
            'link_insta' => 'nullable',
            'birth_date' => 'nullable|date',
            'state' => 'nullable',
            'number_of_child' => 'nullable|integer',
            'introduction' => 'nullable',
            'topic' => 'nullable',
            'hobby' => 'nullable',
            'easy_to_talk' => 'nullable',
            // 必要に応じて他のフィールドを追加
        ]);
    
        // $data = $request->all();
    
        $data = $request->except(['picture']);

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('public/profile_images');
            $filename = basename($path);
            $data['picture'] = $filename; // ファイル名を$data配列に追加
        }
    



        

        $userProfile = new UserProfile();
        // $userProfile のその他の属性を設定

        // Userprofile::create($data);

        // ユーザーIDの設定
        $userProfile->user_id = Auth::id(); // 認証されたユーザーのID
        
            
        // フォームからのデータを$userProfileに設定
        $userProfile->profile_name = $request->profile_name;
        $userProfile->link_x = $request->link_x;
        $userProfile->link_fb = $request->link_fb;
        $userProfile->link_insta = $request->link_insta;
        $userProfile->birth_date = $request->birth_date;
        $userProfile->state = $request->state;
        $userProfile->number_of_child = $request->number_of_child;
        $userProfile->introduction = $request->introduction;
        $userProfile->topic = $request->topic;
        $userProfile->hobby = $request->hobby;
        $userProfile->easy_to_talk = $request->easy_to_talk;        
        // 他のフィールドも同様に設定


        for ($i = 1; $i <= 6; $i++) {
            $fieldName = 'purpose' . $i; 
            $userProfile->$fieldName = $request->input($fieldName, 0); 
        }

        // $userProfile->interest1 = $request->input('interest1', 0);
        for ($i = 1; $i <= 15; $i++) {
            $fieldName = 'interest' . $i; // フィールド名を動的に生成
            $userProfile->$fieldName = $request->input($fieldName, 0); // リクエストから値を取得、デフォルトは0
        }

        for ($i = 1; $i <= 5; $i++) {
            $userProfile->{'name_of_child'.$i} = $request->input('name_of_child'.$i);
            $userProfile->{'sex'.$i} = $request->input('sex'.$i);
            $userProfile->{'birth_date_of_child'.$i} = $request->input('birth_date_of_child'.$i);
        }        

        $userProfile->save();

    
        return redirect()->route('dashboard')->with('success', 'プロフィールが正常に作成されました。');
    }

    /**
     * Display the specified resource.
     */
    
    // public function show(Userprofile $userprofile)
    // {
    //     //
    // }

    public function show($id)
    {
        $userProfile = UserProfile::findOrFail($id);
    
        // 登録イベント一覧（申込中または募集中のイベント）
        // イベントに対する申し込みがない場合（募集中）、または申し込みがあってもpending状態のイベントを取得
        $eventsPending = Event::where('user_id', $id)
        ->whereDoesntHave('books', function($query) {
            $query->where('status', '=', 'matching'); // マッチング済みを除外
        })
        ->with(['books' => function($query) {
            $query->where('status', '=', 'pending');
        }])
        ->get();
        
        // マッチング済みイベント一覧
        $eventsMatching = Event::where('user_id', $id)
                                 ->whereHas('books', function($query) {
                                    $query->where('status', 'matching');
                                 })
                                 ->with('books.user.userprofile')
                                 ->get();
    
        return view('mypage', compact('userProfile', 'eventsPending', 'eventsMatching'));
    
    }    

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Userprofile $userprofile)
    // {
    //     //
    // }

    // public function edit($id)
    // {
    // $userProfile = UserProfile::where('user_id', $id)->firstOrFail();
    // return view('userprofiles.edit', compact('userProfile'));
    // }

    public function edit()
    {
    // ログインユーザーのIDを使用してプロフィール情報を取得
    $userProfile = UserProfile::where('user_id', auth()->id())->firstOrFail();

    // $interestsCategories = [
    //     'news' => 'ニュース',
    //     'business' => 'ビジネススキル',
    //     'career' => 'キャリア・働き方・コーチング',
    //     'self_enlightenment' => '自己啓発',
    //     'management' => '起業・経営',
    //     'marketing' => 'マーケティング・セールス',
    //     'programming' => 'プログラミング',
    //     'design' => 'デザイン',
    //     'health' => '健康・スポーツ',
    //     'music' => '音楽・ライブ',
    //     'movie' => '映画',
    //     'camera' => 'カメラ',
    //     'game' => 'ゲーム',
    //     'comic' => '漫画',
    //     'invest' => '投資',
    //     'side_job' => '副業',
    //     'education' => '教育',
    //     'fashion' => 'ファッション',
    //     'art' => 'アート',
    //     'english' => '英語・語学',
    //     'cook' => '料理・グルメ',
    //     'fortune' => '占い・スピリチュアル',
    //     'mindfulness' => 'マインドフルネス',
    //     'medical' => '医療・介護',
    // ];

    $selectedCategories = [];

    $interests = Interest::all();
    // 既に関連付けられている興味・関心のIDを取得
    $selectedInterests = $userProfile->interests()->pluck('interests.id')->toArray();

    return view('userprofiles.edit', compact('userProfile', 'selectedCategories'));
    }

    

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, $id)
    {
        $this->validate($request, [
            // バリデーションルールをここに設定
            'profile_name' => 'required',
            'picture' => 'nullable',
            'link_x' => 'nullable',
            'link_fb' => 'nullable',
            'link_insta' => 'nullable',
            'birth_date' => 'nullable',
            'state' => 'nullable',
            'number_of_child' => 'nullable',
            'introduction' => 'nullable',
            'topic' => 'nullable',
            'hobby' => 'nullable',
            'easy_to_talk' => 'nullable',
            // 他に必要なフィールドがあれば追加
        ]);

        
        // 画像のアップロード処理
        // if ($request->hasFile('picture')) {
        //     $path = $request->file('picture')->store('public/profile_images');
        //     $path = Storage::url($path);
        // } else {
        //     $path = $request->input('oldPicture'); 
        // }

        // $userProfile = UserProfile::find($id);
        // $userProfile->picture = $path;
        // $userProfile->save();
        
    
        $userProfile = UserProfile::where('user_id', $id)->firstOrFail();
        // $userProfile->interests()->sync($request->interests);

        if ($request->hasFile('picture')) {
            // 古い画像が存在する場合は削除
            if ($userProfile->picture && Storage::disk('public')->exists($userProfile->picture)) {
                Storage::disk('public')->delete($userProfile->picture);
            }
    
            // 新しい画像を保存
            $path = $request->file('picture')->store('profile_images', 'public');
            $userProfile->picture = $path;
        }
    
        $userProfile->save();
            

        for ($i = 1; $i <= 6; $i++) {
            $fieldName = 'purpose' . $i; 
            $userProfile->$fieldName = $request->input($fieldName, 0); 
        }


        // $userProfile->interest1 = $request->input('interest1', 0);
        for ($i = 1; $i <= 15; $i++) {
            $fieldName = 'interest' . $i; // フィールド名を動的に生成
            $userProfile->$fieldName = $request->input($fieldName, 0); // リクエストから値を取得、デフォルトは0
        }

        for ($i = 1; $i <= 5; $i++) {
            $userProfile->{'name_of_child'.$i} = $request->input('name_of_child'.$i);
            $userProfile->{'sex'.$i} = $request->input('sex'.$i);
            $userProfile->{'birth_date_of_child'.$i} = $request->input('birth_date_of_child'.$i);
        }

        $userProfile->update($request->all());
        
    
    return redirect()->route('dashboard')->with('success', 'プロフィールが更新されました。');
    }




    // public function update(Request $request, Userprofile $userprofile)
    // {


    //     // プロフィールデータの保存後にdashboardにリダイレクトする
    //     return redirect()->route('dashboard');    }


    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Userprofile $userprofile)
    {
        //
    }

    public function find_papa()
    {
        // user_idの降順でユーザープロフィールを取得
        $userProfilesfind = UserProfile::orderBy('user_id', 'desc')->get();
        // dd($userProfilesfind);

        // ビューにデータを渡す
        return view('find_papa', ['userProfiles' => $userProfilesfind]);
    }

    public function search(Request $request)
    {
        $query = UserProfile::query();
    
        // フリーワード検索
        if ($request->filled('free')) {
            $query->where(function($q) use ($request) {
                $q->where('profile_name', 'like', '%'.$request->free.'%')
                  ->orWhere('introduction', 'like', '%'.$request->free.'%')
                  ->orWhere('hobby', 'like', '%'.$request->free.'%'); 
                  
            });
        }
    
        // エリア検索
        if ($request->filled('area')) {
            $query->where('state', 'like', '%'.$request->area.'%');
        }
    
        // 子供の月齢検索は追加のロジックが必要になる場合があります（例: 生年月日から計算）
        
    
        $userProfiles = $query->get();
    
        return view('find_papa', compact('userProfiles'));
    }


    public function myPage($id)
    {
        $userId = Auth::id();
    
        // 自分が申し込んでマッチング済みのイベントを取得
        $matchedEvents = Book::where('user_id', $userId)
                              ->where('status', 'matching')
                              ->with('event') // ここで関連するイベントの情報も一緒に取得
                              ->get()
                              ->pluck('event'); // イベント情報だけを抽出
    
        return view('mypage', compact('matchedEvents'));
    }    

}
