@extends('layout.common')
@include('layout.header')
@section('pageJs')
    <script src="{{ asset('js/login.js') }}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col">
      <x-breadcrumb item="TOP" item2="ログイン" url="https://bicky.herokuapp.com/login" />
      <h1 class="main-title">ログイン</h1>
      {{-- ログインフォーム ここから--}}
      <div>
          <form action="{{ route('login') }}" method="post">
              @csrf

              <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <div class="error text-danger">
                        <p>{{ $errors->first('email') }}</p>
                    </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="password" name="password">
                @if($errors->has('password'))
                    <div class="error text-danger">
                        <p>{{ $errors->first('password') }}</p>
                    </div>
                @endif
              </div>

              <div class="text-center mt-5">
                  <input type="submit" value="送信" class="btn btn-secondary w-100" id="jsLoginBtn">
              </div>

          </form>
      </div>
      {{-- ログインフォーム ここまで--}}
    </div>
</div>
@endsection
