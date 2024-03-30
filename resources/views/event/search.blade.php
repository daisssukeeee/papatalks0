<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('1on1を探す') }}
        </h2>
    </x-slot>

    <style>
        .event-container {
            max-width: 800px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .event-item {
            padding-bottom: 20px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }

        .event-item:last-child {
            border-bottom:
             none;
        }

        .event-title {
            font-size: 20px;
            font-weight: bold;
        }


    </style>


    <form action="{{ route('events.search') }}" method="GET" class="search">

        <div class="search" style="padding-left: 20px;">
            <div>
                <div class="" style="padding-top: 15px;">
                    <p>日時</p>
                    <input  type="datetime-local" name="free" type="text" class="form-control" placeholder="" value="">
                </div>
            </div>

            {{-- <div>
                <div class="" style="padding: 0;" >
                <p>子供の月齢</p>
                <select name="" class="" style="width: 15%;" placeholder="選択してください">
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
            </div> --}}

            <div>
                <div class="" style="padding-top: 15px;">
                    <p>コメント</p>
                    <input name="area" type="text" class="form-control"  value="">
                </div>
            </div>
    </form>



          <br>

          <x-primary-button style="margin-left: 0px;">👆１on１を検索</x-primary-button>


          <br><br><br>

    <div class="event-container">
          <h1 class="event-title"><strong>登録中の1on1</strong></h1>
          <br>
          <ul>
              {{-- @foreach ($userProfiles as $userProfile)
              <div style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 20px;">
                  <img class="rounded-circle" style="width: 100px;" srcset="https://res.cloudinary.com/air-rec/image/upload/c_fit,f_auto,q_auto,w_200/wcyllyv4cxq19busiw4w.jpg 576w, https://res.cloudinary.com/air-rec/image/upload/c_fit,f_auto,q_auto,w_200/wcyllyv4cxq19busiw4w.jpg 768w, https://res.cloudinary.com/air-rec/image/upload/c_fit,f_auto,q_auto,w_200/wcyllyv4cxq19busiw4w.jpg 992w, https://res.cloudinary.com/air-rec/image/upload/c_fit,f_auto,q_auto,w_200/wcyllyv4cxq19busiw4w.jpg 1200w" src="https://res.cloudinary.com/air-rec/image/upload/c_fit,f_auto,q_auto,w_200/wcyllyv4cxq19busiw4w.jpg" />
                  <p><strong>{{ $userProfile->profile_name }}</strong></p>
                  <p>{{ $userProfile->introduction }}</p>
              </div>
              @endforeach --}}

            @foreach ($events as $event)
              <div style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 20px;">
                  <p>開始日時： {{ $event->start_date }}</p>
                  <p>コメント： {{ $event->comment }}</p>
                  <p>作成者名：
                    @if($event->userprofile)
                        <a href="{{ route('mypage.show', ['id' => $event->userprofile->id]) }}">
                            {{ $event->userprofile->profile_name }}
                        </a>
                    @else
                        ユーザーが存在しません
                    @endif
                </p>
                  
                  <p>{{ $event->start_date }}: {{ $event->name }}
                      @php
                          $userApplied = $event->bookings->contains(function ($booking) {
                              return $booking->user_id === auth()->id() && $booking->status === 'pending';
                          });
                          $isMatching = $event->bookings->contains(function ($booking) {
                              return $booking->status === 'matching';
                          });
                      @endphp
                      @if (auth()->user()->id != $event->user_id && !$userApplied && !$isMatching)
                          <!-- イベント申込ボタン -->
                          <form action="{{ route('book.event', $event->id) }}" method="POST">
                              @csrf
                              <x-primary-button>イベント申込</x-primary-button>
                            </form>
                      @elseif ($isMatching)
                          <!-- マッチング済の表記 -->
                          <span>マッチング済</span>
                      @elseif($userApplied)
                          <!-- 申請中テキスト -->
                          <button disabled>申請中</button>
                      @endif
              
                      @if (auth()->user()->id == $event->user_id)
                          <!-- 削除ボタン -->
                          <form action="{{ route('event.delete', $event->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <x-primary-button>削除</x-primary-button>
                          </form>
                      @endif
                  </p>
          
              </div>
          @endforeach
        </div>

          </ul>
        
        </div>
          <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    </div>

    


</x-app-layout>