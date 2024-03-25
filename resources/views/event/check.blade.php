<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <br>
            {{ __('イベント確認') }}
        </h2>
    </x-slot>


    <body>
        <p><strong>登録イベント一覧</strong></p>
        <ul>
            @foreach ($eventsPending as $event)
                <li>{{ $event->name }}- 開始日時: {{ $event->start_date }}
                    @if ($event->books->isEmpty())
                        <span>募集中</span>
                    @else
                        @foreach ($event->books as $book)
                            <form action="{{ route('book.approve', $book->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit">承認</button>
                            </form>
                            <!-- 申込をしたユーザーのプロフィール名を表示 -->
                            → 申込者: {{ $book->user->userprofile->profile_name ?? 'プロフィール未設定' }}                            
                        @endforeach
                    @endif
                </li>
            @endforeach
        </ul>

        <br>
    
        <p><strong>マッチング済みイベント一覧</strong></p>
        <ul>
            @foreach ($eventsMatching as $event)
                <li>{{ $event->name }} - 開始日時: {{ $event->start_date }}
                    @foreach ($event->books as $book)
                        - 申込者: {{ $book->user->userprofile->profile_name }}

                        <!-- Zoom URLの表示 -->
                        @if ($event->books->first()->zoom)
                            <p>Zoom URL: {{ $event->books->first()->zoom }}
                                <form action="{{ route('zoom.delete', ['bookId' => $event->books->first()->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('本当に削除しますか？');">削除</button>
                                </form>
                            </p>                            
                        @endif                        

                        @if (auth()->id() == $event->user_id)
                        <!-- Zoom URL 入力フォーム -->
                        <form action="{{ route('event.updateZoom', $event->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="zoom" placeholder="Zoom URL" value="{{ $event->books->first()->zoom ?? '' }}">
                            <button type="submit">保存</button>
                        </form>
                        @endif              

                    @endforeach
                

                </li>
            @endforeach
        </ul>
    </body>




</x-app-layout>
