<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <br>
            {{ __('イベント新規登録') }}
        </h2>
    </x-slot>

    <form action="{{ route('events.store') }}" method="POST">
        @csrf


        <div class="form-group row">
            <label class="">
            <h5>イベント日時</h5>
            </label>
            <div class="">
                <input type="datetime-local" class="form-control" name="start_date" id="start_date" value="" maxlength="50">
            </div>
        </div>   

        <div class="form-group row">
            <label class="">
            <h5>コメント</h5>
            </label>
            <div class="">
            <textarea rows="3" class="form-control" name="comment" id="comment"></textarea>
            </div>
        </div>

        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <button type="submit">登録</button>


    </form>






</x-app-layout>
