@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm mt-5">
            <div class="card-body p-4">
                <h3 class="text-center mb-4 fw-bold">Register</h3>
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required minlength="3" maxlength="40" class="form-control">
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email (@gmail.com)</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="form-control">
                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" required minlength="6" maxlength="12" class="form-control">
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Nomor Handphone (08...)</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" required class="form-control">
                        @error('phone_number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Submit Button</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
