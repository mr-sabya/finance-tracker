@extends('layouts.app')

@section('content')


<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <!-- Update Profile Information Form -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>

                <!-- Update Password Form -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <livewire:profile.update-password-form />
                    </div>
                </div>

                <!-- Delete User Form -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection