@extends('layout.common')
@include('layout.header')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
@endsection
@section('content')

    @if (session('successReservation'))
        <div class="alert alert-success top-alert">
            <p>{!! session('successReservation') !!}</p>
        </div>   
    @endif

    @if (session('successCancel'))
        <div class="alert alert-success top-alert">
            <p>{{ session('successCancel') }}</p>
        </div>   
    @endif
    
<div class="row animation">
    <div class="col-md-6">
        <section class="mb-4">
            <h2>コンセプト</h2>
            <p>
                ことばの訓練を通して、自己肯定感を養い、<br>
                社会で自分らしく生きていくスキルを身につけます。<br>
                親子指導や集団指導もあります。
            </p>
        </section>
        
        <section>
            <h2>対象児童</h2>
           <p>
                障がいの有無は問いません。<br>
                コミュニケーション面や学習面など、<br>
                様々なお悩みに対応しています。
            </p>
        </section>
        
        </div>
    </div>
</div>

@endsection