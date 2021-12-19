@extends('layout.common')
@include('layout.header')

@section('content')
<div class="row">
    <div class="col">
      <x-breadcrumb item="TOP" item2="新規登録" url="https://bicky.herokuapp.com/register" />
      <h1 class="main-title">新規登録</h1>
      {{-- 新規登録フォーム ここから--}}
      <div>
          <form action="{{ route('register') }}" method="post">
              @csrf

              <div class="mb-3">
                  <label for="parentName" class="form-label">保護者氏名</label>
                  <input type="text" class="form-control" id="parentName" name="parentName" placeholder="田中太郎" value="{{ old('parentName') }}">
                  @if($errors->has('parentName'))
                      <div class="error text-danger">
                          <p>{{ $errors->first('parentName') }}</p>
                      </div>
                  @endif
              </div>

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

              <div class="mb-3">
                <label for="password-confirm" class="form-label">パスワード確認</label>
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation">
                @if($errors->has('password-confirm'))
                    <div class="error text-danger">
                        <p>{{ $errors->first('password-confirm') }}</p>
                    </div>
                @endif
              </div>

              <div class="mb-3">
                <label for="childName" class="form-label">利用児氏名</label>
                <input type="text" class="form-control" id="childName" name="childName" placeholder="田中太郎" value="{{ old('childName') }}">
                @if($errors->has('childName'))
                    <div class="error text-danger">
                        <p>{{ $errors->first('childName') }}</p>
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
                  <label for="introduction" class="form-label">紹介先</label>
                  <input type="text" class="form-control" id="introduction" name="introduction" placeholder="〇〇区役所" value="{{ old('introduction') }}">
                  @if($errors->has('introduction'))
                      <div class="error text-danger">
                          <p>{{ $errors->first('introduction') }}</p>
                      </div>
                  @endif
              </div>

              <div class="text-center mt-5">
                  <input type="submit" value="送信" class="btn btn-secondary w-100">
              </div>

          </form>
      </div>
      {{-- 新規登録フォーム ここまで--}}
    </div>
</div>
@endsection
