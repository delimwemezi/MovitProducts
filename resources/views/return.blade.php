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
    color: #e91e63;
">
<h1 style="color:#d63384; text-align:center;">Return Policy</h1>
    <p>
        At Movit, customer satisfaction is important to us. If you receive a damaged
        or incorrect product, you may request a return or exchange within 7 days
        of receiving your order.
    </p>

    <p>
        To be eligible for a return, products must be unused, unopened, and in their
        original packaging.
    </p>

    <p>
        Please note that opened beauty and personal care products cannot be returned
        for hygiene and safety reasons unless the item was damaged or delivered incorrectly.
    </p>

    <p>
        For return assistance, please contact our customer support team through the
        Contact page with your order details.
    </p>
</div>
@include('partials.alerts')
@endsection