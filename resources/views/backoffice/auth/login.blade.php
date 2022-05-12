@extends('backoffice.auth.master')

@section('content')
	<div class="app-content container">
			<div class="content-wrapper">
				<div class="content-header row"></div>
				<div class="content-body"><section class="flexbox-container">
					<div class="col-12 d-flex align-items-center justify-content-center">
						<div class="col-md-4 col-10 box-shadow-2 p-0">
							<div class="card border-grey border-lighten-3 m-0">
								<div class="card-header border-0 pb-0">
									<div class="card-title text-center">
										<div class="p-1"><img src="{{ asset('frontoffice/assets/img/logo.svg') }}" width="200" alt="branding logo"></div>
									</div>
									<h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"><span>Login Administrator</span></h6>
								</div>

								<div class="card-content">
									<div class="card-body">
										<form class="form-horizontal form-simple" action="{{ route('sysadmin.login') }}" method="POST" novalidate>
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
											@if (session('status'))
												<div class="alert alert-danger">
													<button type="button" class="close" data-dismiss="alert">×</button>
													{{ session('status') }}
												</div>
											@endif

											<fieldset class="form-group position-relative has-icon-left mb-1">
												<input type="email" class="form-control form-control-lg input-lg" id="email" name="email" placeholder="Your Email" required>
												<div class="form-control-position">
													<i class="ft-user"></i>
												</div>
												@if ($errors->has('email'))
												<small style="color: red;">{{ $errors->first('email') }}</small>
												@endif
											</fieldset>

											<fieldset class="form-group position-relative has-icon-left">
												<input type="password" class="form-control form-control-lg input-lg" id="password" name="password" placeholder="Enter Password" required>
												<div class="form-control-position">
													<i class="fa fa-key"></i>
												</div>
												@if ($errors->has('password'))
												<small style="color: red;">{{ $errors->first('password') }}</small>
												@endif
											</fieldset>

											<div class="form-group row">
												<div class="col-md-6 col-12">
													<a href="{{ route('sysadmin.forgotpassword') }}" class="card-link">Lupa Password?</a>
												</div>
											</div>
											<button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i> Login</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	<!-- ////////////////////////////////////////////////////////////////////////////-->

@endsection