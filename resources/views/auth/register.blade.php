<title>Register | Profityo</title>
<x-guest-layout>
    <h5 class="login-box-msg">Register !</h5>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="input-group mb-3">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-regular fa-user"></span>
            </div>
          </div>
          <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Name">
          <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="input-group mb-3">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-regular fa-envelope"></span>
            </div>
          </div>
          <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="Email" placeholder="Email"/>
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="input-group mb-3">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-regular fa-eye"></span>
            </div>
          </div>
          <x-text-input id="password" class="form-control"
                            type="password"
                            name="password"
                            required autocomplete="new-password" autocomplete="New Password" placeholder="Password" />
           <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="input-group mb-3">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-regular fa-eye"></span>
            </div>
          </div>
          <x-text-input id="password_confirmation" class="form-control"
                            type="password"
                            name="password_confirmation" required autocomplete="confirmation-password" placeholder="Confirm Password"/>
           <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <x-primary-button>
          {{ __('Register') }}
        </x-primary-button>
        <p class="text-center font_18">Already' Have An Account? <a href="{{ route('login') }}" class="back_text">Login</a></p>
        
    </form>
</x-guest-layout>
