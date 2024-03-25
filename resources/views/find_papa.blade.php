<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('パパ友を探す') }}
        </h2>
    </x-slot>

    <form action="{{ route('user.search') }}" method="GET">
        <div class="search">
            <div>
                <div class="" style="padding: 0;">
                    <p>フリーワード</p>
                    <input name="free" type="text" class="form-control" placeholder="興味、趣味などで検索..." value="">
                </div>
            </div>

            <div>
                <div class="" style="padding: 0;">
                    <p>エリア</p>
                    <input name="area" type="text" class="form-control"  value="">
                </div>
            </div>

            <div>
                <div class="" style="padding: 0;" >
                <p>子供の月齢</p>
                <select name="child_age" class="" style="width: 15%;" placeholder="選択してください">
                    <option value="" selected>選択してください</option>
                    <option value="0ヶ月〜5ヶ月">0ヶ月〜5ヶ月</option>
                    <option value="6ヶ月〜11ヶ月">6ヶ月〜11ヶ月</option>
                    <option value="1才0ヶ月〜1才 5ヶ月">1才0ヶ月〜1才 5ヶ月</option>
                    <option value="1才6ヶ月〜1才11ヶ月">1才6ヶ月〜1才11ヶ月</option>
                    <option value="2才0ヶ月〜2才 5ヶ月">2才0ヶ月〜2才 5ヶ月</option>
                    <option value="2才6ヶ月〜2才11ヶ月">2才6ヶ月〜2才11ヶ月</option>
                    <option value="3才0ヶ月〜3才 5ヶ月">3才0ヶ月〜3才 5ヶ月</option>
                    <option value="3才6ヶ月〜3才11ヶ月">3才6ヶ月〜3才11ヶ月</option>
                    <option value="4才0ヶ月〜4才 5ヶ月">4才0ヶ月〜4才 5ヶ月</option>
                    <option value="4才6ヶ月〜4才11ヶ月">4才6ヶ月〜4才11ヶ月</option>
                    <option value="5才以上">5才以上</option>
                </select>
                </div>
            </div>

          <br><br>

          <div class="text-center">
            <button class="">
                <span class="">👆ユーザーを検索</span>
            </button>
          </div>
        </div>

    </form>

          <br>
          <h1>ユーザープロフィール</h1>
          <br>
          <ul>
            @foreach ($userProfiles as $userProfile)
                <div style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 20px;">
                    <img class="rounded-circle" style="width: 100px;" src="https://res.cloudinary.com/air-rec/image/upload/c_fit,f_auto,q_auto,w_200/wcyllyv4cxq19busiw4w.jpg" />
                    <p>
                        <strong>名前：<a href="{{ route('mypage.show', ['id' => $userProfile->id]) }}">{{ $userProfile->profile_name }}</a></strong>
                    </p>
                    <p>{{ $userProfile->introduction }}</p>
                </div>
            @endforeach
          </ul>
        
          <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    


</x-app-layout>
