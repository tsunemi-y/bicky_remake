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
            <h1 class="main-title text-center">予約</h1>
            {{-- 予約カレンダー ここから--}}
            <table class="reserv-table">
                <caption><a href="?ym={{ $calenderInfo['prevMonth'] }}" class="month-select" style="padding-right: 1.5rem">&lt;</a>{{ $calenderInfo['calenderTitle'] }}<a href="?ym={{ $calenderInfo['nextMonth'] }}" class="month-select" style="padding-left: 1.5rem">&gt;</a></caption>
                <thead>
                    <tr>
                        <th>日</th>
                        <th>月</th>
                        <th>火</th>
                        <th>水</th>
                        <th>木</th>
                        <th>金</th>
                        <th>土</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calenderInfo['calenders'] as $calender)
                        {!! $calender !!}
                    @endforeach
                </tbody>
            </table>
            {{-- 予約カレンダー ここまで--}}

            {{-- 予約時間 ここから--}}
            @foreach($calenderInfo['timeList'] as $time)
                {!! $time !!}
            @endforeach
            {{-- 予約時間 ここまで--}}
        </div>
    </div>

　{{-- 初回確認モーダル --}}
  <div class="modal fade" id="firstCheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">初回確認</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          初めてのご利用ですか？
        </div>
        <div class="modal-footer">
          <a href="{{ route('reservationForm', ['targetDate' => '', 'targetTime' => '' ]) }}" id="js-noBtn"><button type="button" class="btn btn-secondary">いいえ</button></a>
          <a href="{{ route('reservationForm', ['targetDate' => '', 'targetTime' => '', 'modalBtn' => '']) }}" id="js-yesBtn"><button type="button" class="btn btn-primary">はい</button></a>
        </div>
      </div>
    </div>
  </div>
    
@endsection