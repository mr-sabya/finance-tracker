<div class="mx-3">



    <form class="form-horizontal mt-3 " action="" wire:submit.prevent="login">

        <div class="form-group mb-3">
            <div class="col-12">
                <input class="form-control" type="email" name="email" wire:model="email" placeholder="Email">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group mb-3">
            <div class="col-12">
                <input class="form-control" type="password" name="password" wire:model="password" placeholder="Password">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="col-12">
                <div class="checkbox checkbox-primary">
                    <input id="checkbox-signup" type="checkbox" wire:model="remember">
                    <label for="checkbox-signup" class="text-color">
                        Remember me
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group text-center mt-3">
            <div class="col-12">

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="login"
                    class="btn btn-primary btn-block btn-lg waves-effect waves-light w-100">
                    <span wire:loading.remove wire:target="login">Login</span>
                    <span wire:loading wire:target="login">Login.....</span>
                </button>
            </div>
        </div>

        <div class="form-group row mt-4 mb-0">
            <div class="col-sm-12 text-center">
                <p>
                    <a href="auth-recoverpw.html" class="text-color">
                        <i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                </p>
                <p class="text-white">Don't have account? <a href="{{ route('register') }}" wire:navigate class="text-color">Register</a></p>
                
            </div>

        </div>
    </form>


</div>