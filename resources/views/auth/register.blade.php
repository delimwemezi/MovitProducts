@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="auth-shell">
    <div class="auth-card">
        <h1>Create account</h1>
        <p>Create your account to save product lists and see your order history.</p>

        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="field-group">
                <label for="name">Full name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="field-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="field-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="field-group">
                <label for="password_confirmation">Confirm password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="primary-btn">Create account</button>
        </form>

        <p class="auth-link">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
    </div>
</div>

@push('styles')
<style>
    .auth-shell { max-width: 520px; margin: 60px auto; padding: 0 16px; }
    .auth-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 18px; box-shadow: 0 10px 25px rgba(15,23,42,0.05); padding: 28px; }
    .auth-card h1 { margin-top: 0; }
    .field-group { display: grid; gap: 8px; margin-bottom: 16px; }
    .field-group input { width: 100%; border: 1px solid #d1d5db; border-radius: 10px; padding: 12px 14px; }
    .primary-btn { width: 100%; border: none; background: linear-gradient(135deg, #7c3aed, #ec4899); color: white; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; }
    .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 10px 12px; border-radius: 10px; margin-bottom: 16px; }
    .auth-link { text-align: center; margin-top: 18px; }
</style>
@endpush
@endsection
