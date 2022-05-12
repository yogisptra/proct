@extends('backoffice.auth.master')

@section('content')


    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                            <div class="p-1"><img src="{{ asset('frontoffice/assets/img/logo.svg') }}" width="200" alt="branding logo">
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Lupa Password</span></h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal" action="{{ route('sysadmin.forgetpassword.send') }}" method="POST">
                                            @csrf
                                            @if($message = Session::get('error'))
                                                <div class="alert alert-danger">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    {{$message}}
                                                </div>
                                            @elseif ($message = Session::get('success'))
                                                <div class="alert alert-success">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    {{$message}}
                                                </div>
                                            @endif
    
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="email" class="form-control form-control-lg input-lg" id="email" name="email" placeholder="Your Email Address" required>
                                                <div class="form-control-position">
                                                    <i class="ft-mail"></i>
                                                </div>
                                            </fieldset>
                                            <button type="submit" class="btn btn-outline-info btn-lg btn-block"><i class="ft-unlock"></i> Recover Password</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer border-0">
                                    <p class="float-sm-left text-center"><a href="{{ route('sysadmin.login') }}" class="card-link">Login</a></p>
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