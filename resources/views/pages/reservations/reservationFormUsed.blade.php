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
          <h1 class="main-title text-center">予約フォーム</h1>
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
                      <input type="text" class="form-control" id="name" name="name" placeholder="田中太郎">
                      @if($errors->has('name'))
                          <div class="error text-danger">
                              <p>{{ $errors->first('name') }}</p>
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

                  <div class="text-center mt-5">
                    <input type="submit" value="送信" class="btn btn-secondary w-100">
                  </div>

                  <input type="hidden" class="form-control" id="date" name="reservation_date" value="{{ Request::get('targetDate') }}">
                  <input type="hidden" class="form-control" id="time" name="reservation_time" value="{{ Request::get('targetTime') }}">
              </form>
          </div>
          {{-- 予約フォーム ここまで--}}
        </div>
      </div>
      
@endsection