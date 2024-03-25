<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <br>
            {{ __('プロフィール設定') }}
        </h2>
    </x-slot>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール設定</title>
    <link rel="stylesheet" href="./info.css" type="text/css">

</head>

<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
}

.settings {
    background-color: #fff;
    text-align: left;
    margin: 20px auto;
    width: 80%;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
    padding: 20px;
}

h3 {
    font-size: 36px;
    padding-top: 20px;
    padding-bottom: 10px;
    padding-left: 30px;
}

h5 {
    font-size: 20px;
}

.form-group.row {
    margin-bottom: 15px;
}

.form-group.row label {
    font-weight: bold;
    flex: 0 0 30%;
}

.form-group.row .col-sm-9 {
    flex: 1;
}

img.rounded-circle {
    border-radius: 50%;
}

.form-control-plaintext {
    background-color: #f8f8f8;
    border: 1px solid #ccc;
    padding: 10px;
}

.form-control,
select.dropdown,
textarea.form-control {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.form-control[type="text"] {
    width: 30%; /* 幅を70%短縮 */
}

textarea.form-control {
    resize: vertical;
}

.form-group.row:last-child {
    margin-bottom: 50px;
}

.btn-primary {
    background-color: rgb(0, 218, 0);
    color: #fff;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: rgb(0, 240, 0);
}


</style>

<body>
    
{{-- <h3 style="margin: 10px 0;">プロフィール設定</h3> --}}

<form action="{{ route('userprofiles.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  {{-- <label for="name">名前:</label>
  <input type="text" name="name" id="name" required> --}}

  <div class="settings">
 
      <div class="form-group row">
        <label class="">
        <h5>プロフィール画像</h5>
        </label>
        <div class="">
          {{-- 画像表示 --}}
          @if(true)
            <img class="rounded-circle" style="width: 100px;" src="{{ asset('profile_images/HBtIKCH2ExSgQvTkyy0sIOtDrPaGWE5cxDK2YYb0.avif') }}" />
          @else
            <img class="rounded-circle" style="width: 100px;" src="https://res.cloudinary.com/air-rec/image/upload/c_fit,f_auto,q_auto,w_200/wcyllyv4cxq19busiw4w.jpg" />
          @endif
          <div class="mt-3"><label class="form-label">プロフィール画像を変更</label></div>
          <input type="file" class="form-control form-control-file" name="picture" id="picture">
        </div>
        {{-- <div>
          <x-picture-input />
          <x-input-error class="mt-2" :messages="$errors->get('picture')" />
        </div> --}}
      </div>

      {{-- <div class="form-group row">
        <label class="" for="user_email">
          <h5>メールアドレス</h5>
        </label>                
        <div class="">
            <input type="text" class="form-control" name="user[email]" value="" maxlength="50" required>
        </div>
      </div> --}}

      <div class="form-group row">
        <label class="">
        <h5>名前</h5>
        </label>
        <div class="">
          <input type="text" class="form-control" name="profile_name" id="profile_name" value="" maxlength="30" required>
        </div>
      </div>
      
      <div class="form-group row">
        <label class="">
        <h5>生年月日</h5>
        </label>
          <div class="">
            <input type="date" class="form-control" name="birth_date" id="birth_date" value="" maxlength="50">
          </div>
      </div>   

      <div class="form-group row">
        <label class="">
        <h5>居住地</h5>
        </label>
          <div class="">
            <input type="text" class="form-control" name="state" id="state" value="" maxlength="50">
          </div>
      </div>          

      <div class="form-group row">
        <label class="">
        <h5>子供の数</h5>
        </label>
          <div class="">
            <input type="number" class="form-control" name="number_of_child" id="number_of_child" value="" maxlength="50">
          </div>
      </div>          

      <div class="form-group row">
        <label class="">
        <h5>自己紹介</h5>
        </label>
        <div class="">
          <textarea rows="10" cols="50" class="form-control" name="introduction" id="introduction"></textarea>
        </div>
      </div>

      <div class="form-group row">
        <label class="">
        <h5>趣味</h5>
        </label>
        <div class="">
          <textarea rows="5" class="form-control" name="hobby" id="topic">{{ $userProfile->hobby }}</textarea>
        </div>
      </div>            

      <div class="form-group row">
        <label class="">
        <h5>こんな話がしたい</h5>
        </label>
        <div class="">
          <textarea rows="5" class="form-control" name="topic" id="topic"></textarea>
        </div>
      </div>

      <div class="form-group row">
        <label class="">
        <h5>話しやすい曜日・時間帯</h5>
        </label>
        <div class="">
          <textarea rows="5" class="form-control" name="easy_to_talk" id="easy_to_talk"></textarea>
        </div>
      </div>

      <div class="form-group row" style="margin-bottom:50px;">            
        <label class="col-sm-3 col-form-label">
        <h5>Facebookアカウント</h5>
        </label>
        <div class="input-group col-sm-9">
          <div class="input-group-prepend">
            <span class="input-group-text" style="font-size: 0.6rem;">https://www.facebook.com/</span>
          </div>
          <input type="text" class="form-control" name="link_fb" id="link_fb" value="" placeholder="username">                    
        </div>            
      </div>

      <div class="form-group row" style="margin-bottom:50px;">            
        <label class="col-sm-3 col-form-label">
        <h5>Xアカウント</h5>
        </label>
        <div class="input-group col-sm-9">
          <div class="input-group-prepend">
            <span class="input-group-text" style="font-size: 0.6rem;">https://twitter.com/</span>
          </div>
          <input type="text" class="form-control" name="link_x" id="link_x" value="" placeholder="username">                    
        </div>            
      </div>

      <div class="form-group row" style="margin-bottom:50px;">            
        <label class="col-sm-3 col-form-label">
        <h5>Instagramアカウント</h5>
        </label>
        <div class="input-group col-sm-9">
          <div class="input-group-prepend">
            <span class="input-group-text" style="font-size: 0.6rem;">https://www.instagram.com/</span>
          </div>
          <input type="text" class="form-control" name="link_insta" id="link_insta" value="" placeholder="username">                    
        </div>            
      </div>






      <div class="form-group row" style="min-height: 100px; margin-bottom:60px;">
        <label class="">
        <h5>利用目的</h5>
        </label>

        <div class="">
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
          
          @foreach ($purposes as $index => $label)
              <label>
                  <input type="hidden" name="purpose{{ $index }}" value="0">
                  <input type="checkbox" name="purpose{{ $index }}" value="1"> {{ $label }}
              </label>
              @if ($index % 2 == 0)
                  <br>
              @else
                  &nbsp;&nbsp;
              @endif
          @endforeach
        </div>
      </div>



      <div class="form-group row" style="min-height: 150px; margin-bottom:50px;">
        <label class="">
        <h5>興味・関心</h5>
        </label>
 
        <div class="">
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
          
          @foreach ($interests as $index => $label)
              <label>
                  <input type="hidden" name="interest{{ $index }}" value="0">
                  <input type="checkbox" name="interest{{ $index }}" value="1"> {{ $label }}
              </label>
              @if ($index % 3 == 0)
                  <br>
              @else
                  &nbsp;&nbsp;
              @endif
          @endforeach
        </div>
      </div>

      <h5>第一子</h5>
        <div class="child-fieldset">
          <label>子供の名前:</label>
          <input type="text" name="name_of_child1"/>　

          <label>子供の性別:</label>
          <select name="sex1" value="$userProfile->sex1">
            <option value="">選択してください</option>
            <option value="1">男</option>
            <option value="2">女</option>
            <option value="3">回答しない</option>
          </select>　

          <label>子供の生年月日:</label>
          <input type="date" name="birth_date_of_child1"/>
        </div>
        <br>

        <h5>第二子</h5>
        <div class="child-fieldset">
          <label>子供の名前:</label>
          <input type="text" name="name_of_child2"/>　
        
          <label>子供の性別:</label>
          <select name="sex2">
            <option value="">選択してください</option>
            <option value="1">男</option>
            <option value="2">女</option>
            <option value="3">回答しない</option>
          </select>　
        
          <label>子供の生年月日:</label>
          <input type="date" name="birth_date_of_child2"/>
        </div>
        <br>
        

        <h5>第三子</h5>
        <div class="child-fieldset">
          <label>子供の名前:</label>
          <input type="text" name="name_of_child3"/>　
        
          <label>子供の性別:</label>
          <select name="sex3">
            <option value="">選択してください</option>
            <option value="1">男</option>
            <option value="2">女</option>
            <option value="3">回答しない</option>
          </select>　
        
          <label>子供の生年月日:</label>
          <input type="date" name="birth_date_of_child3"/>
        </div>
        <br>
        

        <h5>第四子</h5>
        <div class="child-fieldset">
          <label>子供の名前:</label>
          <input type="text" name="name_of_child4"/>　
        
          <label>子供の性別:</label>
          <select name="sex4">
            <option value="">選択してください</option>
            <option value="1">男</option>
            <option value="2">女</option>
            <option value="3">回答しない</option>
          </select>　
        
          <label>子供の生年月日:</label>
          <input type="date" name="birth_date_of_child4"/>
        </div>
        <br>
        

        <h5>第五子</h5>
        <div class="child-fieldset">
          <label>子供の名前:</label>
          <input type="text" name="name_of_child5"/>　
        
          <label>子供の性別:</label>
          <select name="sex5">
            <option value="">選択してください</option>
            <option value="1">男</option>
            <option value="2">女</option>
            <option value="3">回答しない</option>
          </select>　
        
          <label>子供の生年月日:</label>
          <input type="date" name="birth_date_of_child5"/>
        </div>
        <br>
        


      <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">



      {{-- <form action="{{ route('update.userprofile') }}" method="POST"> --}}

          <!-- 他のフィールドを追加 -->
          <button type="submit">送信</button>
      </form>






</body>
</html>


</x-app-layout>
