<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Userprofile;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    // 新規登録フォームの表示
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // フォームデータの処理
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'start_date' => 'required|date',
        ]);

        // データの保存
        Event::create([
            'start_date' => $request->start_date,
            'comment' => $request->comment,
            'user_id' => Auth::id(), // 現在認証されているユーザーのIDを使用

        ]);

        // 完了後にリダイレクト
        return redirect()->route('dashboard')->with('status', 'イベントが登録されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $userId)
    {
        $user = Userprofile::with(['events' => function($query) {
            $query->where('start_date', '>=', now())->orderBy('start_date', 'asc');
        }])->findOrFail($userId);

        // ユーザーに関連するイベントを取得
        // ここで$eventsPendingと$eventsMatchingのデータを取得する処理を記述

        return view('mypage', compact('user', 'eventsPending', 'eventsMatching'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }

    // public function search()
    // {
    // return view('event.search');
    // }

    public function search_events(Request $request)
    {
        $query = Event::query();

        // 現在時刻以降のイベントをstart_dateの昇順で取得
        $query->where('start_date', '>=', now())
              ->orderBy('start_date', 'asc')
              ->with(['books' => function($query) {
                  $query->where('status', '!=', 'matching');
              }]);
    
        // 日時での検索（フリーワード検索）
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }
    
        // コメントでの検索
        if ($request->filled('comment')) {
            $query->where('comment', 'like', '%' . $request->comment . '%');
        }
    
        $events = $query->get();
    
        // 各イベントに対して、matchingステータスの申込みがあるか確認し、フラグを設定
        $events->each(function ($event) {
            $event->isVisible = $event->books->isEmpty() || !$event->books->contains('status', 'matching');
        });
    
        // ビューにデータを渡す
        return view('event.search', ['events' => $events]);

        
    }

    
    public function bookEvent(Request $request, $id)
    {
        // Books テーブルに申込情報を保存
        Book::create([
            'event_id' => $id,
            'user_id' => auth()->user()->id,
            'reservation' => true, // 申込済み
            'status' => 'pending', // 承認待ち
        ]);
    
        return back()->with('success', 'イベントに申し込みました。');
    }
    
    public function deleteEvent($id)
    {
        $event = Event::find($id);
    
        // イベント登録者のみ削除可能
        if (auth()->user()->id == $event->user_id) {
            $event->delete();
            return back()->with('success', 'イベントを削除しました。');
        } else {
            return back()->with('error', 'イベントの削除権限がありません。');
        }
    }    

    public function check($userId)
    {
        if (Auth::id() != $userId) {
            abort(403); // ユーザーIDがログイン中のユーザーIDと不一致の場合はアクセス拒否
        }
    
        // 承認待ちまたはまだ申し込みがないイベントを取得
        $eventsPending = Event::where('user_id', $userId)
                              ->where(function ($query) {
                                  $query->whereHas('books', function ($q) {
                                      $q->where('status', 'pending');
                                  })
                                  ->orWhereDoesntHave('books');
                              })
                              ->with(['books' => function ($query) {
                                  $query->where('status', 'pending')->with('user');
                              }])
                              ->get();
                              
        //承認待ちで申込者の名前を取得
        $events = Event::with(['books.user.userprofile'])->where('user_id', Auth::id())->get();

        
    
        // マッチング済みの申込みを含むイベントを取得
        $eventsMatching = Event::where('user_id', $userId)
                               ->whereHas('books', function ($query) {
                                   $query->where('status', 'matching');
                               })->with(['books' => function ($query) {
                                   $query->where('status', 'matching')->with('user');
                               }])
                               ->get();

        // 自分が申し込んでマッチング済みのイベントを取得
        $eventsAppliedMatching = Book::where('user_id', $userId)
                                    ->where('status', 'matching')
                                    ->with('event.books.user.userprofile') // イベント情報とそれに関連するユーザープロフィールをロード
                                    ->get()
                                    ->pluck('event'); // Book から Event へのリレーションを通じてイベント情報を取得

        // 重複を排除
        $eventsAppliedMatching = $eventsAppliedMatching->unique('id');

        // マッチング済みイベント一覧に自分が申し込んだイベントも含める
        $eventsMatching = $eventsMatching->merge($eventsAppliedMatching)->unique('id');                               
    
        return view('event.check', compact('eventsPending', 'eventsMatching'));
    }
    
    public function approve($bookId)
    {
    $book = Book::find($bookId);
    $book->status = 'matching'; // ステータスをマッチングに更新
    $book->save();

    return back()->with('success', '申込みを承認しました。');
    }


    public function updateZoom(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $book = $event->books()->where('status', 'matching')->first();
    
        if ($book && $request->user()->id == $event->user_id) {
            $book->zoom = $request->zoom;
            $book->save();
            
            return back()->with('success', 'Zoom URLが更新されました。');
        }
    
        return back()->with('error', '更新に失敗しました。');
    }


    public function deleteZoom($bookId)
    {
        $book = Book::findOrFail($bookId);
    
        // ここで権限の確認を行うべきです。例えば、
        // if (Auth::id() != $book->event->user_id) {
        //     abort(403);
        // }
    
        // Zoom URLを削除
        $book->zoom = null;
        $book->save();
    
        return back()->with('success', 'Zoom URLが削除されました。');
    }    


}
