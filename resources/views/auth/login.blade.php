@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<style>
	.custom-alert {
    background: rgba(255, 0, 0, 0.1);
    border: 1px solid #ff4d4d;
    color: #ff4d4d;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 20px;
    width: 100%;
    max-width: 400px;
    text-align: left;
    box-shadow: 0 2px 6px rgba(255, 0, 0, 0.2);
    animation: slideIn 0.3s ease-out;
}

.custom-alert ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.custom-alert li::before {
    content: "⚠️ ";
    margin-right: 6px;
}
@keyframes slideIn {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}

</style>
	<div class="section">
		@if (!Auth::check())
    <button id="backBtn" class="btn btn-outline-secondary mb-3">
        ← Back
    </button>
@endif

		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
			          	<input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
			          	<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										@if ($errors->any())
											<div class="custom-alert">
												<ul>
													@foreach ($errors->all() as $error)
														<li> {{ $error }}</li>
													@endforeach
												</ul>
											</div>
										@endif
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Log In</h4>
                                            <form method="POST" action="{{ route('login.post') }}">
                                            @csrf
											<div class="form-group">
												<input type="email" name="email" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">
                                                  
												<i class="input-icon uil uil-at"></i>
											</div>	
											<div class="form-group mt-2">
												<input type="password" name="password" class="form-style" placeholder="Your Password" id="logpass" autocomplete="new-password">
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
                                            <div class="form-check">
                                                <input type="checkbox" name="remember" class="form-check-input">
                                                <!-- <label class="form-check-label">Remember me</label> -->
                                            </div>
											<!-- <a href="#" class="btn mt-4">submit</a> -->
                                              <button type="submit" class="btn mt-4">Login</button>
                                            </form>
                            				<!-- <p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p> -->
				      					</div>
			      					</div>
			      				</div>
								<div class="card-back">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Sign Up</h4>                                            
                                            <form method="POST" action="{{ route('register.post') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="text" name="name" class="form-style" placeholder="Your Full Name" id="logname" autocomplete="off">
                                                    <i class="input-icon uil uil-user"></i>
                                                </div>	
                                                <div class="form-group mt-2">
                                                    <input type="email" name="email" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">
                                                    <i class="input-icon uil uil-at"></i>
                                                </div>	
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password" class="form-style" placeholder="Your Password" id="logpass" autocomplete="new-password">
                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password_confirmation" class="form-style" placeholder="please Enter Password Again" id="logpass" autocomplete="off">
                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                </div>
                                                <!-- <a href="#" class="btn mt-4">submit</a> -->
                                                <button type="submit" class="btn mt-4">Register</button>
                                            </form>
				      					</div>
			      					</div>
			      				</div>
			      			</div>
			      		</div>
			      	</div>
		      	</div>
	      	</div>
	    </div>
	</div>
@endsection
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const backBtn = document.getElementById('backBtn');

       
        if (window.history.length <= 1) {
            backBtn.style.display = 'none'; 
        }

        backBtn?.addEventListener("click", function () {
            window.history.back();
        });
    });
</script>

@endsection


	