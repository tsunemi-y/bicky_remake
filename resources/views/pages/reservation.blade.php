@extends('layout.common')
@include('layout.header')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <h1 class="main-title text-center">予約</h1>
            {{-- 予約フォーム ここから--}}
            <div>
                <form action="{{ route('reservation.sendMail') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">氏名</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="田中太郎">
                        @if($errors->has('name'))
                            <div class="error text-danger">
                                <p>{{ $errors->first('name') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 w-25">
                        <label for="age" class="form-label">年齢</label>
                        <input type="text" class="form-control" id="age" name="age" placeholder="5">
                        @if($errors->has('age'))
                            <div class="error text-danger">
                                <p>{{ $errors->first('age') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label d-block">性別</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="男の子" checked>
                            <label class="form-check-label" for="male">
                            男の子
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="女の子">
                            <label class="form-check-label" for="female">
                            女の子
                            </label>
                        </div>
                        @if($errors->has('gender'))
                            <div class="error text-danger">
                                <p>{{ $errors->first('gender') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                        @if($errors->has('email'))
                            <div class="error text-danger">
                                <p>{{ $errors->first('email') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="diagnosis" class="form-label">診断名</label>
                        <input type="text" class="form-control" id="diagnosis" name="diagnosis" placeholder="自閉症の疑い">
                        @if($errors->has('diagnosis'))
                            <div class="error text-danger">
                                <p>{{ $errors->first('diagnosis') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">住所</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="〇〇区">
                        @if($errors->has('address'))
                            <div class="error text-danger">
                                <p>{{ $errors->first('address') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="Introduction" class="form-label">紹介先</label>
                        <input type="text" class="form-control" id="Introduction" name="Introduction" placeholder="〇〇区役所">
                        @if($errors->has('Introduction'))
                            <div class="error text-danger">
                                <p>{{ $errors->first('Introduction') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 input-w-md">
                        <label for="date" class="form-label">予約日</label>
                        <input type="date" class="form-control" id="date" name="date">
                        @if($errors->has('date'))
                            <div class="error text-danger">
                                <p>{{ $errors->first('date') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3 input-w-md">
                        <label for="time" class="form-label">予約時間</label>
                        <select class="form-control" aria-label="Default select example" id="time" name="time">
                            <option value="11：00～11：40">11：00～11：40</option>
                            <option value="13：00～13：40">13：00～13：40</option>
                            <option value="14：00～14：40">14：00～14：40</option>
                            <option value="15：00～15：40">15：00～15：40</option>
                            <option value="16：00～16：40">16：00～16：40</option>
                        </select>
                        @if($errors->has('time'))
                            <div class="error text-danger">
                                <p>{{ $errors->first('time') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">その他</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    </div>
                    <div class="text-center">
                        <input type="submit" value="送信" class="btn btn-secondary w-100">
                    </div>
                </form>
            </div>
            {{-- 予約フォーム ここまで--}}
        </div>
    </div>
@endsection