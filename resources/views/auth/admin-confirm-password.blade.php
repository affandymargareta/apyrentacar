<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />

        <!-- Scripts -->
        
    </head>
    <bod>
<!-- Section: Design Block -->
<section class="background-radial-gradient overflow-hidden">
  <style>
    .background-radial-gradient {
      background-color: hsl(218, 41%, 15%);
      background-image: radial-gradient(650px circle at 0% 0%,
          hsl(218, 41%, 35%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%),
        radial-gradient(1250px circle at 100% 100%,
          hsl(218, 41%, 45%) 15%,
          hsl(218, 41%, 30%) 35%,
          hsl(218, 41%, 20%) 75%,
          hsl(218, 41%, 19%) 80%,
          transparent 100%);
    }

    #radius-shape-1 {
      height: 220px;
      width: 220px;
      top: -60px;
      left: -130px;
      background: radial-gradient(#44006b, #ad1fff);
      overflow: hidden;
    }

    #radius-shape-2 {
      border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
      bottom: -60px;
      right: -110px;
      width: 300px;
      height: 300px;
      background: radial-gradient(#44006b, #ad1fff);
      overflow: hidden;
    }

    .bg-glass {
      /* background-color: hsla(0, 0%, 100%, 0.9) !important; */
      /* background-color: #00BCD4 !important; */
      background-color: #fff !important;
      backdrop-filter: saturate(200%) blur(25px); 
    }
  </style>

  <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
    <div class="row gx-lg-5 align-items-center mb-5">
      <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
        <h4 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
        `Thank You For Using Apy Rent A Car For Your Business <br />
          <span style="color: hsl(218, 81%, 75%)"> Have A Pleasant Journey`</span>
        </h4>
        <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
          Lorem ipsum dolor, sit amet consectetur adipisicing elit.
          Temporibus, expedita iusto veniam atque, magni tempora mollitia
          dolorum consequatur nulla, neque debitis eos reprehenderit quasi
          ab ipsum nisi dolorem modi. Quos?
        </p>
      </div>

      <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
        <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
        <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

        <div class="card bg-glass">
          <div class="card-body px-4 py-5 px-md-5">
                <div class="text-center">
                  <img src="{{ asset('images/apyrentacars.png') }}"
                    style="width: 185px;" alt="logo">
                  <h4 class="mt-2 mb-1 pb-1">This is a secure area of the application. Please confirm your password before continuing.</h4>
                  <h4 class="mt-2 mb-1 pb-1">Admin</h4>
                </div>
            <form method="POST" action="{{ route('admin.password.confirm') }}">
                @csrf
              <!-- 2 column grid layout with text inputs for the first and last names -->

              <!-- Password input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" style="color: #000">Password</label>
                <input type="password" class="form-control" name="password"
                required autocomplete="current-password" value="{{ old('password') }}" style="border: 2px solid #673AB7;" />
                <small class="form-text text-muted">We'll never share your Password with anyone else.</small>
              </div>

              <!-- Submit button -->
              <div class="d-grid gap-2">
                <button type="submit" class="btn" style="background-color: #6747c7; color :#fff;">Confirm</button>
              </div>

              <!-- Register buttons -->
              <!-- <div class="text-center mt-3 mb-3">
                <p style="color: #000">or sign up with:</p>
                  <div class="d-grid gap-2"> -->
                    <!-- Google -->
                    <!-- <a href="#!" class="btn" style="background-color: #dd4b39; color :#fff;"><i class="fab fa-google me-2"></i> Sign in with google</a> -->
                    <!-- Google -->
                    <!-- Facebook -->
                    <!-- <a href="#!" class="btn" style="background-color: #3b5998; color :#fff;"><i class="fab fa-facebook-f me-2"></i> Sign in with Facebook</a> -->
                    <!-- Facebook -->
                    <!-- Github -->
                    <!-- <a href="#!" class="btn" style="background-color: #333333; color :#fff;"><i class="fab fa-github me-2"></i> Sign in with Github</a> -->
                    <!-- Github -->
                  <!-- </div>
              </div> -->
              <!-- Register buttons -->
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Section: Design Block -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
