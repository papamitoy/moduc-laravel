@extends("layouts.app")
@section("content")

<div class="container">
    <section id="formHolder">
       <div class="row">
            @if (Auth::check())
            {{ Auth::user()->id }}
            @endif
          <!-- Brand Box -->
          <div class="col-sm-6 brand">
              
             <img style=" width: 100%;" src="assets/img/banner log in.jpg">
          </div>
          <!-- Form Box -->
<div class="col-sm-6 form">

    <!-- Login Form -->
    <div class="login form-peice switched">
       <form class="login-form" action="/login" method="post" id="loginForm" >
        @csrf
          <div class="form-group">
             <label for="loginemail">Email Adderss</label>
             <input type="email" name="email" id="loginemail" required>
          </div>

          <div class="form-group">
             <label for="loginPassword">Password</label>
             <input type="password" name="password" id="loginPassword" required>
          </div>

          <div class="CTA">
             <input type="submit" value="Login"  >
             <a href="#" class="switch">I'm New</a>
          </div>
       </form>
    </div><!-- End Login Form -->


    <!-- Signup Form -->
    <div class="signup form-peice">
       <form class="signup-form" action="/register" method="post" id="registerForm">
         @csrf
          <div class="form-group">
             <label for="name">Full Name</label>
             <input type="text" name="name" id="name" class="name">
             <span class="error"></span>
          </div>

          <select class="form-select" name="type" aria-label="Default select example">
          <option selected value="user">Register as Student</option>
          <option value="adviser">Register as Teacher</option>
          </select>

          <div class="form-group">
             <label for="email">Email Adderss</label>
             <input type="email" name="emailAdress" id="email" class="email">
             <span class="error"></span>
          </div>

          <div class="form-group">
             <label for="username">Username</label>
             <input type="text" name="username" id="username">
          </div>

          <div class="form-group">
             <label for="password">Password</label>
             <input type="password" name="password" id="password" class="pass">
             <span class="error"></span>
          </div>

          <div class="form-group">
             <label for="passwordCon">Confirm Password</label>
             <input type="password" name="passwordCon" id="passwordCon" class="passConfirm">
             <span class="error"></span>
          </div>

          <div class="CTA">
             <input type="submit" value="Signup Now" id="submit">
             <a href="#" class="switch">I have an account</a>
          </div>
       </form>
    </div><!-- End Signup Form -->
 </div>
</div>
</section>
<footer>
   <p>
      <strong>Developers:</strong> <a href="http://mohmdhasan.tk" target="_blank">Charles Lydon Abiero | Juntinjo Ferolino | Carlo way gamit</a>
   </p>
</footer>

@endsection