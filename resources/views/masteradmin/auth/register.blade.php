<x-guest-layout>
    <h5 class="login-box-msg">Register !</h5>
    @if(Session::has('link-success'))
      <p class="text-success" > {{ Session::get('link-success') }}</p>
    @endif
    @if(Session::has('link-error'))
      <p class="text-danger" > {{ Session::get('link-error') }}</p>
    @endif
              
    <form method="POST" action="{{ route('business.register.store') }}">
        @csrf
        <div>
        <div class="form-group mb-2">
    <label for="user_first_name">First Name <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-user"></i>
            </span>
        </div>
        <input 
            type="text" 
            class="form-control @error('user_first_name') is-invalid @enderror" 
            id="user_first_name" 
            name="user_first_name" 
            placeholder="Enter First Name" 
            value="{{ old('user_first_name') }}"
        >
        </div>
        @error('user_first_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
   
</div>


<div class="form-group mb-2">
    <label for="user_email">Email <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-envelope"></i>
            </span>
        </div>
        <input 
            type="email" 
            class="form-control @error('user_email') is-invalid @enderror" 
            id="user_email" 
            name="user_email" 
            placeholder="Enter Email" 
            value="{{ old('user_email') }}"
        >
        </div>
        @error('user_email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
   
</div>


<div class="form-group mb-2">
    <label for="user_business_name">Business Name <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-user"></i>
            </span>
        </div>
        <input 
            type="text" 
            class="form-control @error('user_business_name') is-invalid @enderror" 
            id="user_business_name" 
            name="user_business_name" 
            placeholder="Enter Business Name" 
            value="{{ old('user_business_name') }}"
        >
        </div>
        @error('user_business_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
   
</div>


<div class="form-group mb-2">
    <label for="user_phone">Phone <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-phone"></i>
            </span>
        </div>
        <input 
            type="text" 
            class="form-control @error('user_phone') is-invalid @enderror" 
            id="user_phone" 
            name="user_phone" 
            placeholder="Enter Phone" 
            value="{{ old('user_phone') }}"
        >
        </div>
        @error('user_phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    
</div>


<div class="form-group mb-2">
    <label for="user_password">Password <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-eye"></i>
            </span>
        </div>
        <input 
            type="password" 
            class="form-control @error('user_password') is-invalid @enderror" 
            id="user_password" 
            name="user_password" 
            placeholder="Enter Password" 
            value="{{ old('user_password') }}"
        >
      
    </div>
    @error('user_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
</div>


<div class="form-group mb-3">
    <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="fas fa-eye"></i>
            </span>
        </div>
        <input 
            type="password" 
            class="form-control @error('password_confirmation') is-invalid @enderror" 
            id="password_confirmation" 
            name="password_confirmation" 
            placeholder="Enter Confirm Password" 
            value="{{ old('password_confirmation') }}"
        >
     
    </div>
    @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
</div>


        <x-primary-button>
          {{ __('Register') }}
        </x-primary-button>
        <p class="text-center font_18 mb-0">Already' Have An Account? <a href="{{ route('business.login') }}" class="back_text">Login</a></p>
    </form>

</x-guest-layout>

