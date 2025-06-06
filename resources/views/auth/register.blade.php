@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<h2>Register</h2>
<form method="POST" action="{{ route('register.post') }}">
    @csrf
    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="name" required>
    </div>
    <div class="form-group">
        <label>Email address</label>
        <input type="email" class="form-control" name="email" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password" required>
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" class="form-control" name="password_confirmation" required>
    </div>
    <button type="submit" class="btn btn-success mt-3">Register</button>
</form>
@endsection
