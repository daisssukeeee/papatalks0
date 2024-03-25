<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <br>
            {{ __('プロフィールページ') }}
        </h2>
    </x-slot>



    <div class="container">
        <h1>{{ $userProfile->profile_name }} のプロフィール</h1>
        <div>
            <img src="{{ $userProfile->picture_url }}" alt="{{ $userProfile->profile_name }}" style="width: 150px; height: 150px; border-radius: 75px;">
        </div>
        <p><strong>生年月日：</strong>{{ $userProfile->birth_date }}</p>
        <p><strong>居住地：</strong>{{ $userProfile->state }}</p>
        <p><strong>子供の数：</strong>{{ $userProfile->number_of_child }}</p>
        <p><strong>自己紹介：</strong>{{ $userProfile->introduction }}</p>
        <p><strong>趣味：</strong>{{ $userProfile->hobby }}</p>
        <p><strong>こんな話がしたい：</strong>{{ $userProfile->topic }}</p>
        <p><strong>話しやすい曜日・時間帯：</strong>{{ $userProfile->easy_to_talk }}</p>
        <p><strong>Facebookアカウント：</strong><a href="{{ 'https://www.facebook.com/' . $userProfile->link_fb }}">{{ $userProfile->link_fb }}</a></p>
        <p><strong>Xアカウント：</strong><a href="{{ 'https://twitter.com/' . $userProfile->link_x }}">{{ $userProfile->link_x }}</a></p>
        <p><strong>Instagramアカウント：</strong><a href="{{ 'https://www.instagram.com/' . $userProfile->link_insta }}">{{ $userProfile->link_insta }}</a></p>
        {{-- 必要に応じて他のプロフィール情報を追加 --}}
        <div>
            <p><strong>利用目的</strong></p>
            @php
            $purposes = [
                1 => '育児の相談をしたい',
                2 => '育児の相談に乗ります',
                3 => '育児の情報交換をしたい',
                4 => '育児の日々の取り組みを気軽に話したい',
                5 => '仕事の話がしたい',
                6 => '趣味の話がしたい',
            ];
            @endphp
        
            <ul>
            @for ($i = 1; $i <= 6; $i++)
                @if ($userProfile->{'purpose'.$i} == 1)
                    <li>{{ $purposes[$i] }}</li>
                @endif
            @endfor
            </ul>
        </div>
        <div>
            <h4><strong>興味・関心</strong></h4>
            @php
            $interests = [
                1 => 'キャリア・働き方',
                2 => '健康・スポーツ',
                3 => '音楽',
                4 => '映画',
                5 => 'カメラ',
                6 => 'ゲーム',
                7 => '漫画',
                8 => '投資',
                9 => '副業',
                10 => '教育',
                11 => 'ファッション',
                12 => '英語・語学',
                13 => '料理・グルメ',
                14 => 'マインドフルネス',
                15 => '医療・介護',
            ];
            @endphp
        
            <ul>
            @for ($i = 1; $i <= 15; $i++)
                @if ($userProfile->{'interest'.$i} == 1)
                    <li>{{ $interests[$i] }}</li>
                @endif
            @endfor
            </ul>
        </div>
        
        @php
        $sexes = [
            1 => '男',
            2 => '女',
            3 => '回答しない',
        ];
        @endphp
        
        {{-- 第一子の情報は常に表示 --}}
        <div>
            <h4><strong>第1子</strong></h4>
            <p>名前: {{ $userProfile->name_of_child1 }}</p>
            <p>性別: {{ $sexes[$userProfile->sex1] ?? '未設定' }}</p>
            <p>生年月日: {{ $userProfile->birth_date_of_child1 }}</p>
        </div>
        
        {{-- 第二子から第五子の情報を条件付きで表示 --}}
        @for ($i = 2; $i <= 5; $i++)
            @php
                $nameKey = 'name_of_child'.$i;
                $sexKey = 'sex'.$i;
                $birthdateKey = 'birth_date_of_child'.$i;
            @endphp
        
            @if (!empty($userProfile->$nameKey) || !empty($userProfile->$sexKey) || !empty($userProfile->$birthdateKey))
                <div>
                    <h4><strong>第{{ $i }}子</strong></h4>
                    <p>名前: {{ $userProfile->$nameKey }}</p>
                    <p>性別: {{ $sexes[$userProfile->$sexKey] ?? '未設定' }}</p>
                    <p>生年月日: {{ $userProfile->$birthdateKey }}</p>
                </div>
            @endif
        @endfor
    </div>

{{-- 登録イベント一覧 --}}
<p><strong>登録イベント一覧</strong></p>
<ul>
    @foreach ($eventsPending as $event)
        <li>{{ $event->name }} - 開始日時: {{ $event->start_date }}
            @if ($event->books->isEmpty())
                <span>募集中</span>
            @else
                @foreach ($event->books as $book)
                    <!-- 申込み承認フォームや申込者情報など -->
                @endforeach
            @endif
        </li>
    @endforeach
</ul>



{{-- マッチング済みイベント一覧 --}}
<p><strong>マッチング済みイベント一覧</strong></p>
<ul>
    @foreach ($eventsMatching as $event)
        <li>{{ $event->name }} - 開始日時: {{ $event->start_date }}
            @foreach ($event->books as $book)
                - 申込者: {{ $book->user->userprofile->profile_name }}
            @endforeach
        </li>
    @endforeach

    {{-- @foreach ($matchedEvents as $event)
    <div>
        <p>開始日時: {{ $event->start_date }}</p>
        @foreach ($event->books as $book)
        - 申込者: {{ $book->user->userprofile->profile_name }}
        @endforeach
    </div>
    @endforeach     --}}
</ul>

</x-app-layout>
