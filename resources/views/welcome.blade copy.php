<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Bloggy Storm</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		{{-- BOOTSTRAP JS--}}
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		{{-- FAVICON --}}
		<link rel="shortcut icon" href="attached/img/favicon_2.ico" type="image/x-icon">
		<link rel="icon" href="attached/img/favicon_2.ico" type="image/x-icon">

		<!-- Styles -->
		<link href="{{ asset('attached/css/app.css') }}" rel="stylesheet">

	</head>
	<body>
		<div class="flex-center position-ref full-height">
			@if (Route::has('login'))
				<div class="top-right links">
					@auth
						<a href="{{ url('/') }}">Homeee</a>
					@else
						<div class="dropdown">
							<a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Login</a>
							<div class="dropdown-menu w_400" aria-labelledby="dropdownMenuLink">
								<form method="POST" action="{{ route('login') }}">
										@csrf
										<div class="form-group row">
												<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

												<div class="col-md-6">
														<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

														@error('email')
																<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																</span>
														@enderror
												</div>
										</div>

										<div class="form-group row">
												<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

												<div class="col-md-6">
														<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

														@error('password')
																<span class="invalid-feedback" role="alert">
																		<strong>{{ $message }}</strong>
																</span>
														@enderror
												</div>
										</div>

										<div class="form-group row">
												<div class="col-md-6 offset-md-4">
														<div class="form-check">
																<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

																<label class="form-check-label" for="remember">
																		{{ __('Remember Me') }}
																</label>
														</div>
												</div>
										</div>

										<div class="form-group row mb-0">
												<div class="col-md-8 offset-md-4">
														<button type="submit" class="btn btn-primary">
																{{ __('Login') }}
														</button>

														@if (Route::has('password.request'))
																<a class="btn btn-link" href="{{ route('password.request') }}">
																		{{ __('Forgot Your Password?') }}
																</a>
														@endif
												</div>
										</div>
								</form>
							</div>
							@if (Route::has('register'))
								<a class="btn btn-light" href="{{ route('register') }}">Register</a>
							@endif
						</div>
					@endauth
				</div>
			@endif

			<div class="content">
				<div class="title m-b-md">
					<a href="https://www.freepik.es/fotos-vectores-gratis/personas"><img src="{{ asset('attached/img/img_001.jpg')}}" alt="" width="600px" style="border-radius: 200px; padding-top: 20px;"></a>
					<p>Bloggy Storm</p>
				</div>
			</div>
		</div>
	</body>
</html>
