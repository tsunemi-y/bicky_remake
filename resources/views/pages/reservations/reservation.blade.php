@extends('layout.common')
@include('layout.header')
@section('description')
    <meta name="description" content="平日・休日の訓練を受け付けます。言葉の遅れ、発達障害、構音障害などが気になられましたらご予約ください。">
@endsection

@section('title')
    <title>予約 | ビッキーことば塾 | 島本町・大山崎町・高槻市 | 発達障害や言葉の遅れが気になる子供の訓練</title>
@endsection

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

@section('pageJs')
    <script src="{{ asset('js/reservation.js') }}"></script>  
@endsection

@section('content')

    @if (session('differentReservation'))
        <div class="alert alert-success top-alert">
            <p>{{ session('differentReservation') }}</p>
        </div>   
    @endif

    <div class="row">
        <div class="col">
            <x-breadcrumb item="TOP" item2="予約" url="https://bicky.herokuapp.com/reservation" />
            <h1 class="main-title">予約</h1>

            <p class="mb-4">下記手順でご予約ください。<br>
              1.日時を指定<br>
              2.初回予約か2回目以降の予約かを選択<br>
              3.必要情報をフォームに入力<br>
              <span class="d-inline-block mb-1">※初回予約時は、氏名・メールアドレス以外も入力して頂く必要がございます。</span><br>
              <span class="text-danger">※休日のご予約は下記メールアドレスからお願い致します。</span><br>
              <a href="mailto:hattatsushien@gmail.com">hattatsushien@gmail.com</a>
            </p>
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
            {{-- @foreach($calenderInfo['avaTimes'] as $avaTime)
                {!! $time !!}
            @endforeach --}}
            {{-- 予約時間 ここまで--}}
        </div>
    </div>

　{{-- 初回確認モーダル --}}
  <div class="modal fade" id="avaTimeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">下記時間からご選択ください。</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('createReservation') }}" method="post" id="jsAvaTime">
            @csrf
            <input type="hidden" value="" id="jsRequestedAvaDate" name="avaDate">
            <input type="hidden" value="" id="jsRequestedAvaTime" name="avaTime">
          </form>
        </div>
        <div class="modal-footer">
          

        </div>
      </div>
    </div>
  </div>

    <script>
      const avaTimes = @json($calenderInfo['avaTimes']);
    </script>  
    
@endsection
