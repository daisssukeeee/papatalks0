<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <br>
            {{ __('プロフィールページ') }}
        </h2>
    </x-slot>

    <!-- Styles -->
    <style>
        .profile-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 16px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 20px; 
            font-weight: bold;

        }
        
        .profile-container h1 {
        margin: 0 0 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid #eaeaea;
        }
        
        .profile-container img {
            width: 150px; /* 希望する幅 */
            height: 150px; /* アスペクト比を保持するために幅と同じサイズ */
            border-radius: 50%;
            object-fit: cover; /* 画像が引き延ばされたり圧縮されたりするのを防ぐ */
        }
        
        .profile-table {
            width: 100%;
            margin-top: 16px;
            border-collapse: collapse;
        }
        
        .profile-table th, .profile-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }
        
        .profile-table th {
            background-color: #f8f8f8;
            font-weight: normal; /* 表のヘッダーは通常の太さに保持 */
        }
        
        .profile-table tr:last-child th, .profile-table tr:last-child td {
            border-bottom: none;
        }
        
        ul {
            padding-left: 20px;
        }
        
        ul li {
            list-style-type: disc;
        }
        
        a {
            color: #007bff;
            text-decoration: none;
        }
        
        a:hover {
            text-decoration: underline;
        }
        
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        
        .button:hover {
            background-color: #0056b3;
        }
    </style>

    <!-- Profile Container -->
    <div class="profile-container">
        <h1>{{ $userProfile->profile_name }}のプロフィール</h1>
        <div style="text-align:center;">
            <img src="{{ $userProfile->profile_photo_path ? Storage::url($userProfile->profile_photo_path) : 'https://res.cloudinary.com/air-rec/image/upload/c_fit,f_auto,q_auto,w_200/wcyllyv4cxq19busiw4w.jpg' }}" alt="プロフィール画像">
        </div>
        
        <!-- Profile Information Table -->
        <table class="profile-table">
            <!-- 生年月日 Row -->
            <tr>
                <th>生年月日</th>
                <td>{{ $userProfile->birth_date }}</td>
            </tr>

            <!-- 居住地 Row -->
            <tr>
                <th>居住地</th>
                <td>{{ $userProfile->state }}</td>
            </tr>

            <!-- 子供の数 Row -->
            <tr>
                <th>子供の数</th>
                <td>{{ $userProfile->number_of_child }}</td>
            </tr>

            <!-- 自己紹介 Row -->
            <tr>
                <th>自己紹介</th>
                <td>{{ $userProfile->introduction }}</td>
            </tr>

            <!-- 趣味 Row -->
            <tr>
                <th>趣味</th>
                <td>{{ $userProfile->hobby }}</td>
            </tr>

            <!-- こんな話がしたい Row -->
            <tr>
                <th>こんな話がしたい</th>
                <td>{{ $userProfile->topic }}</td>
            </tr>

            <!-- 話しやすい曜日・時間帯 Row -->
            <tr>
                <th>話しやすい曜日・時間帯</th>
                <td>{{ $userProfile->easy_to_talk }}</td>
            </tr>
            
            <!-- Facebookアカウント Row -->
            <tr>
                <th>Facebookアカウント</th>
                <td><a href="{{ 'https://www.facebook.com/' . $userProfile->link_fb }}">{{ $userProfile->link_fb }}</a></td>
            </tr>
            
            <!-- Xアカウント Row -->
            <tr>
                <th>Xアカウント</th>
                <td><a href="{{ 'https://twitter.com/' . $userProfile->link_x }}">{{ $userProfile->link_x }}</a></td>
            </tr>
            
            <!-- Instagramアカウント Row -->
            <tr>
                <th>Instagramアカウント</th>
                <td><a href="{{ 'https://www.instagram.com/' . $userProfile->link_insta }}">{{ $userProfile->link_insta }}</a></td>
            </tr>

{{-- 利用目的 --}}
<tr>
    <th>利用目的</th>
    <td>
        <ul>
        @for ($i = 1; $i <= 6; $i++)
            @if ($userProfile->{'purpose'.$i} == 1)
                <li>{{ $purposes[$i] }}</li>
            @endif
        @endfor
        </ul>
    </td>
</tr>

{{-- 興味・関心 --}}
<tr>
    <th>興味・関心</th>
    <td>
        <ul>
        @for ($i = 1; $i <= 15; $i++)
            @if ($userProfile->{'interest'.$i} == 1)
                <li>{{ $interests[$i] }}</li>
            @endif
        @endfor
        </ul>
    </td>
</tr>

{{-- 子供の情報 --}}
@for ($i = 1; $i <= 5; $i++)
    @php
        $nameKey = 'name_of_child'.$i;
        $sexKey = 'sex'.$i;
        $birthdateKey = 'birth_date_of_child'.$i;
    @endphp

    @if (!empty($userProfile->$nameKey) || !empty($userProfile->$sexKey) || !empty($userProfile->$birthdateKey))
        <tr>
            <th>第{{ $i }}子の情報</th>
            <td>
                <p>名前: {{ $userProfile->$nameKey }}</p>
                <p>性別: {{ $sexes[$userProfile->$sexKey] ?? '未設定' }}</p>
                <p>生年月日: {{ $userProfile->$birthdateKey }}</p>
            </td>
        </tr>
    @endif
@endfor

{{-- 登録イベント一覧 --}}
<tr>
    <th>登録イベント一覧</th>
    <td>
        <ul>
        @foreach ($eventsPending as $event)
            <li>{{ $event->name }} 開始日時: {{ $event->start_date }}
                @if ($event->books->isEmpty())
                    <span>募集中</span>
                @else
                    @foreach ($event->books as $book)
                        {{-- 申込み承認フォームや申込者情報など --}}
                    @endforeach
                @endif
            </li>
        @endforeach
        </ul>
    </td>
</tr>

{{-- マッチング済みイベント一覧 --}}
<tr>
    <th>マッチング済みイベント一覧</th>
    <td>
        <ul>
        @foreach ($eventsMatching as $event)
            <li>{{ $event->name }} 開始日時: {{ $event->start_date }}
                @foreach ($event->books as $book)
                    - 申込者: {{ $book->user->userprofile->profile_name }}
                @endforeach
            </li>
        @endforeach
        </ul>
    </td>
</tr>
</table>


</x-app-layout>
