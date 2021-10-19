@extends('layout.common')
@include('layout.header')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection
@section('pageJs')
    <script src="{{ asset('js/reservation.js') }}"></script>  
@endsection
@section('content')
    <div class="row">
        <div class="col">
          <h1 class="main-title">予約フォーム</h1>
          {{-- 予約フォーム ここから--}}
          <div>
              <form action="{{ route('createReservation') }}" method="post">
                  @csrf

                  @if($errors->has('date'))
                      <div class="error text-danger">
                          <p>{{ $errors->first('reservation_date') }}</p>
                      </div>
                  @endif

                  @if($errors->has('time'))
                      <div class="error text-danger">
                          <p>{{ $errors->first('reservation_time') }}</p>
                      </div>
                  @endif

                  <div class="mb-3">
                      <label for="name" class="form-label">氏名</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="田中太郎" value="{{ old('name') }}">
                      @if($errors->has('name'))
                          <div class="error text-danger">
                              <p>{{ $errors->first('name') }}</p>
                          </div>
                      @endif
                  </div>

                  <div class="mb-3 w-25">
                      <label for="age" class="form-label">年齢</label>
                      <input type="text" class="form-control" id="age" name="age" placeholder="5" value="{{ old('age') }}">
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
                      <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}">
                      @if($errors->has('email'))
                          <div class="error text-danger">
                              <p>{{ $errors->first('email') }}</p>
                          </div>
                      @endif
                  </div>

                  <div class="mb-3">
                      <label for="diagnosis" class="form-label">診断名</label>
                      <input type="text" class="form-control" id="diagnosis" name="diagnosis" placeholder="自閉症の疑い" value="{{ old('diagnosis') }}">
                      @if($errors->has('diagnosis'))
                          <div class="error text-danger">
                              <p>{{ $errors->first('diagnosis') }}</p>
                          </div>
                      @endif
                  </div>

                  <div class="mb-3">
                      <label for="address" class="form-label">住所</label>
                      <input type="text" class="form-control" id="address" name="address" placeholder="〇〇区" value="{{ old('address') }}">
                      @if($errors->has('address'))
                          <div class="error text-danger">
                              <p>{{ $errors->first('address') }}</p>
                          </div>
                      @endif
                  </div>

                  <div class="mb-3">
                      <label for="Introduction" class="form-label">紹介先</label>
                      <input type="text" class="form-control" id="Introduction" name="Introduction" placeholder="〇〇区役所" value="{{ old('Introduction') }}">
                      @if($errors->has('Introduction'))
                          <div class="error text-danger">
                              <p>{{ $errors->first('Introduction') }}</p>
                          </div>
                      @endif
                  </div>

                  <div class="mb-3">
                      <label for="note" class="form-label">その他</label>
                      <textarea class="form-control" id="note" name="note" rows="3">{{ old('note') }}</textarea>
                  </div>

                  <div class="text-center mt-5">
                      <input type="submit" value="送信" class="btn btn-secondary w-100">
                  </div>

                  <input type="hidden" class="form-control" id="date" name="reservation_date" value="{{ Request::get('targetDate') }}">
                  <input type="hidden" class="form-control" id="time" name="reservation_time" value="{{ Request::get('targetTime') }}">
                  <input type="hidden" class="form-control" id="modalBtn" name="modal_btn" value="{{ Request::get('modalBtn') }}">
              </form>
          </div>
          {{-- 予約フォーム ここまで--}}
        </div>
      </div>
      
@endsection