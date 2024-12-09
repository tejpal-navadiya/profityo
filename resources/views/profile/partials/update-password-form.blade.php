
<div class="card-header">
    <h3 class="card-title">{{ __('Change Password') }}</h3>
</div>
<!-- /.card-header -->
<div class="card-body2">
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div class="row pad-5">
            <div class="col-md-6">
                <div class="form-group">
                    <x-input-label for="update_password_current_password" :value="__('Current Password')" /><span class="text-danger">*</span>
                    <x-text-input id="update_password_current_password" name="current_password" type="password"
                        class="form-control" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <x-input-label for="update_password_password" :value="__('New Password')" /><span class="text-danger">*</span>
                    <x-text-input id="update_password_password" name="password" type="password" class="form-control"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" /><span class="text-danger">*</span>
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                        class="form-control" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>
        <div class="row py-20 px-10">
            <div class="col-md-12 text-center">
                <button type="submit" class="add_btn">Save Changes</button></a>
                <!-- <x-primary-button>{{ __('Save') }}</x-primary-button> -->
                @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Password updated sucessfully.') }}</p>
                @endif
            </div>
        </div>
    </form>
</div>