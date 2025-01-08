<div class="mx-3">
    <form class="form-horizontal mt-3" action="https://themesdesign.in/appzia/layouts/index.html">

        <div class="form-group mb-3">
            <div class="col-12">
                <input type="text" id="name" class="form-control" wire:model="name" placeholder="Name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-group mb-3">
            <div class="col-12">
                <input type="email" id="email" class="form-control" wire:model="email" placeholder="Email">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>


        <div class="form-group mb-3">
            <div class="col-12">
                <input type="password" id="password" class="form-control" wire:model="password" placeholder="Password">
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group mb-3">
            <div class="col-12">
                <input type="password" id="password_confirmation" class="form-control" wire:model="password_confirmation" placeholder="Confim Password">
                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group text-center mt-4">
            <div class="col-12">
                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light w-100" type="submit">Register</button>
            </div>
        </div>

        <div class="form-group mt-3 mb-0">
            <div class="col-sm-12 text-center">
                <p class="text-white">Already have account? <a href="{{ route('login') }}" wire:navigate class="text-color">Login</a></p>
                
            </div>
        </div>

    </form>
</div>