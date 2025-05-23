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
          <h1 class="main-title">キャンセルコード認証画面</h1>
            
            <form action="{{ route('VerifyCancelCode') }}" method="post" class="mx-auto w-100">
                @csrf

                @if (session('cancelError'))
                    <div class="alert alert-danger top-alert">
                        <p>{{ session('cancelError') }}</p>
                    </div>   
                @endif
                <div class="mb-3 mx-auto">
                    <label for="id" class="form-label">id</label>
                    <input type="text" class="form-control" id="id" name="id">
                    @if($errors->has('id'))
                        <div class="error text-danger">
                            <p>{{ $errors->first('id') }}</p>
                        </div>
                    @endif
                </div>

                <div class="mb-3 mx-auto">
                    <label for="cancel_code" class="form-label">キャンセルコード</label>
                    <input type="text" class="form-control" id="cancel_code" name="cancel_code">
                    @if($errors->has('cancel_code'))
                        <div class="error text-danger">
                            <p>{{ $errors->first('cancel_code') }}</p>
                        </div>
                    @endif
                </div>
                
                <div class="text-center mt-5">
                    <input type="submit" value="送信" class="btn btn-secondary w-100">
                </div>
                    
            </form>
                
        </div>
      </div>
      
@endsection