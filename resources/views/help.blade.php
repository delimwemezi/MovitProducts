@extends('layouts.app')

@section('content')

<style>
  .help-wrap {
    max-width: 800px;
    margin: 3rem auto;
    padding: 30px;
    font-family: sans-serif;
    line-height: 1.8;

    background: url('{{ asset('images/background 09.jpg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    border-radius: 15px;
    color: #e91e63;
  }

  .help-wrap h1 {
    color: #e91e63;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    text-align: center;
  }

  .help-wrap p {
    color: #c2185b;
    line-height: 1.8;
    margin-bottom: 2rem;
  }

  .form-group { margin-bottom: 1.2rem; }
  .form-group label { display: block; font-weight: bold; margin-bottom: 0.4rem; color: #c2185b; }
  .form-group input,
  .form-group textarea {
    width: 100%; padding: 0.75rem 1rem;
    border: 1.5px solid #f48fb1; border-radius: 8px;
    font-size: 1rem; font-family: sans-serif;
    outline: none; box-sizing: border-box;
  }
  .form-group input:focus,
  .form-group textarea:focus { border-color: #e91e63; }
  .form-group textarea { height: 150px; resize: vertical; }
   .btn-send {
    background: #e91e63; color: #fff;
    padding: 0.8rem 2rem; border: none;
    border-radius: 8px; font-size: 1rem;
    cursor: pointer; width: 100%;
  }
  .btn-send:hover { background: #c2185b; }

  .alert-success { background: #e8f5e9; color: #2e7d32; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
  .alert-error   { background: #fce4ec; color: #c62828; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
  
</style>

<div class="help-wrap">
  <h1>Help Center</h1>
  <p>Have a question or need assistance? Fill in the form below and our team will get back to you as soon as possible.</p>

  @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div class="alert-error">❌ {{ session('error') }}</div>
  @endif

  <div class="contact-form">
    <h2>Send Us a Message</h2>

    <form action="/help/send" method="POST">
      @csrf

      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required />
      </div>

      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required />
      </div>

      <div class="form-group">
        <label>Message</label>
        <textarea name="message" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
      </div>

      <button type="submit" class="btn-send">Send Message</button>
    </form>
  </div>
</div>
@include('partials.alerts')
@endsection