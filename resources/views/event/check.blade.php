<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('イベント確認') }}
        </h2>
    </x-slot>

    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .event-list {
            max-width: 800px;
            margin: 20px auto;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .event-item {
            padding: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        .event-item:last-child {
            border-bottom: none;
        }

        .event-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .event-details {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .event-actions {
            margin-top: 10px;
        }

        .zoom-info {
            background-color: #d1e7dd;
            border-left: 4px solid #0f5132;
            padding: 10px;
            margin-bottom: 10px;
        }

        input[type=text] {
            padding: 5px;
            margin-right: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .confirmation {
            color: #dc3545;
        }
    </style>

    <div class="event-list">
        <p><strong>登録イベント一覧</strong></p>
        <ul>
            @foreach ($eventsPending as $event)
                <li class="event-item">
                    <div class="event-title">{{ $event->name }} - 開始日時: {{ $event->start_date }}</div>
                    @if ($event->books->isEmpty())
                        <div class="event-details">募集中</div>
                    @else
                        @foreach ($event->books as $book)
                            <div class="event-details">
                                <!-- Booking Approval Form -->
                                <form action="{{ route('book.approve', $book->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <x-primary-button>承認</x-primary-button>
                                </form>
                                <!-- Applicant Profile Name -->
                                → 申込者: 
                                @if($book->user->userprofile)
                                    <a href="{{ route('mypage.show', ['id' => $book->user->userprofile->id]) }}">
                                        {{ $book->user->userprofile->profile_name }}
                                    </a>
                                @else
                                    名前未設定
                                @endif                            
                            </div>
                        @endforeach
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    <div class="event-list">
        <p><strong>マッチング済みイベント一覧</strong></p>
        <ul>
            @foreach ($eventsMatching as $event)
                <li class="event-item">
                    <div class="event-title">{{ $event->name }} - 開始日時: {{ $event->start_date }}</div>
                    @foreach ($event->books as $book)
                        <div class="event-details">
                            → 申込者: 
                            @if($book->user->userprofile)
                                <a href="{{ route('mypage.show', ['id' => $book->user->userprofile->id]) }}">
                                    {{ $book->user->userprofile->profile_name }}
                                </a>
                            @else
                                名前未設定
                            @endif  
                        </div>

                        <!-- Zoom Info -->
                        @if ($event->books->first()->zoom)
                            <div class="zoom-info">
                                <p>Zoom URL: {{ $event->books->first()->zoom }}</p>
                                <form action="{{ route('zoom.delete', ['bookId' => $event->books->first()->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="confirmation" onclick="return confirm('本当に削除しますか？');">削除</button>
                                </form>
                            </div>                            
                        @endif

                        <!-- Zoom URL Input Form -->
                        @if (auth()->id() == $event->user_id)
                            <div class="event-actions">
                                <form action="{{ route('event.updateZoom', $event->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="zoom" placeholder="Zoom URL" value="{{ $event->books->first()->zoom ?? '' }}">
                                    <x-primary-button>保存</x-primary-button>
                                </form>
                            </div>
                        @endif
                    @endforeach
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>