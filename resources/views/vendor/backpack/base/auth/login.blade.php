@extends('backpack::layout')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-offset-3 col-md-offset-5">
                            <img src="{{ url ('logo.jpg') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center text-danger" style="padding-top: 20px">
                            <p><strong><em> PT PRIMAJASA PERDANARAYAUTAMA</em></strong></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 col-md-offset-0 col-xs-offset-1 col-xs-10">
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                                {!! csrf_field() !!}

                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}{{ old('email') }}" placeholder="Username or Email" required>
                                        <input id="email" type="hidden" value="" name="email">
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="password" class="form-control" name="password" placeholder="Password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> {{ trans('backpack::base.remember_me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            {{ trans('backpack::base.login') }}
                                        </button>
                                        <a class="btn btn-link" href="{{ route('password.request') }}">{{ trans('backpack::base.forgot_your_password') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_scripts')
    <script>
        $('#username').on('change', function () {
            $('#email').val($('#username').val());
        });
    </script>
@endsection