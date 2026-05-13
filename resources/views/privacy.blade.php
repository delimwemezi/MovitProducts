@extends('layouts.app')

@section('content')
<div style="
    max-width:100%;
    margin:auto;
    padding:30px;
    line-height:1.8;

    /*background: url('{{ asset('images/background 09.jpg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;*/

    background-color: pink;

    border-radius: 15px;
    color:  #e91e63;
">
    <h1 style="color:#d63384; text-align:center;">Privacy Policy</h1>

    <p>
        Your privacy is not just a policy to us — it is a promise. At Movit, we handle your
        personal information with the utmost care, discretion, and respect. We collect only
        what is necessary, protect it with modern security standards, and never share it
        without your consent. Because you trust us with your beauty needs, we take every
        step to protect the trust you place in us.
    </p>
</div>
@include('partials.alerts')
@endsection