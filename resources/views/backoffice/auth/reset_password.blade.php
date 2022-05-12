@extends('backoffice.auth.master')

@section('content')

	<!-- ////////////////////////////////////////////////////////////////////////////-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                                <div class="card-header border-0 pb-0">
                                    <div class="card-title text-center">
                                        <img src="{{ asset('frontoffice/assets/img/logo.svg') }}" width="200" alt="branding logo">
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Masukan Password Baru</span></h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal" action="{{ route('sysadmin.update.password') }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="text" id="token" name="token" value="{{ $data->token }}" hidden>

                                            <input type="text" id="email" name="email" value="{{ $data->email }}" hidden>

                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control form-control-lg input-lg" id="password" name="password" placeholder="Enter New Password" required>
                                                <div class="form-control-position">
                                                    <i class="fa fa-key"></i>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <small style="color: red;">{{ $errors->first('password') }}</small>
                                                @endif
                                            </fieldset>

                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control form-control-lg input-lg" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password" required>
                                                <div class="form-control-position">
                                                    <i class="fa fa-key"></i>
                                                </div>
                                                @if ($errors->has('confirm_password'))
                                                    <small style="color: red;">{{ $errors->first('confirm_password') }}</small>
                                                @endif
                                            </fieldset>

                                            <button type="submit" class="btn btn-outline-info btn-lg btn-block"><i class="ft-unlock"></i> Recover Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
	<!-- ////////////////////////////////////////////////////////////////////////////-->

@endsection