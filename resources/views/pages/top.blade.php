@extends('layout.common')
@include('layout.header')

@section('description')
    <meta name="description" content="JR島本駅から徒歩5分!!言語聴覚士・保育士・高校教諭など複数の免許を持った指導員が言語訓練を行います。言葉の遅れ、発達障害、構音障害などのお子様の訓練を行います。">
@endsection

@section('title')
    <title>ビッキーことば塾 ｜ 島本町・大山崎町・高槻市 | 発達障害/自閉症/ADHD/発達や言葉の遅れが気になる子供の訓練</title>
@endsection

@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
@endsection

@section('pageJs')
  <script src="{{ asset('js/top.js') }}"></script> 
@endsection

@section('content')
    
<div class="row animation">
    <div class="col">
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

{{-- 会員登録後モーダル --}}
@if (session('registration'))
<div class="modal fade" id="registration" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p>{!! session('registration') !!}</p>
      </div>
    </div>
  </div>
</div>
@endif

<script>
  const isRegistration = @json(!empty(session('registration')));
</script>  

@endsection