@extends('layouts.app')

@section('content')

<style>
  .about-page { font-family: sans-serif; color: #333; }

  /* Hero */
  .about-hero {
    max-width: 100%;
    margin:auto;
    padding:30px;
    line-height:2.8;
    background: url('{{ asset('images/background 09.jpg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 15px;
    color: white;
    /*background: linear-gradient(135deg, #fce4ef, #f8bbd0);*/
    padding: 4rem 2rem;
    text-align: center;
  }
  .about-hero h1 {
    font-size: 2.5rem;
    color: #c2185b;
    margin-bottom: 0.5rem;
  }
  .about-hero p {
    color:  #c2185b;
    font-size: 1rem;
  }

  /* Sections */
  .about-section {
    max-width: 850px;
    margin: 3rem auto;
    padding: 0 2rem;
  }

  .about-card {
    max-width:100%;
    margin:auto;
    padding:30px;
    line-height:1.8;
    
    /*background: url('{{ asset('images/background 08.jpg') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;*/

     background-color: pink;

    border-radius: 15px;
    border-left: 5px solid #e91e63;
    border-radius: 10px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 16px rgba(233,30,99,0.07);
  }
  .about-card h2 {
    color: #c2185b;
    font-size: 1.4rem;
    margin-bottom: 1rem;
  }
  .about-card p {
    color:  #e91e63;
    line-height: 1.9;
    font-size: 1rem;
  }

  /* Stats bar */
  .stats-bar {
    background: #e91e63;
    color: #fff;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 2rem;
    padding: 2.5rem 2rem;
    text-align: center;
  }
  .stat-item h3 { font-size: 2rem; margin: 0; }
  .stat-item p  { font-size: 0.85rem; margin: 0.3rem 0 0; opacity: 0.85; }
</style>

<div class="about-page">

  {{-- Hero --}}
  <div class="about-hero">
    <h1>About Movit Products</h1>
    <p>Celebrating African Beauty since 1997</p>
  </div>

  {{-- Stats --}}
  <div class="stats-bar">
    <div class="stat-item">
      <h3>25+</h3>
      <p>Years of Excellence</p>
    </div>
    <div class="stat-item">
      <h3>146</h3>
      <p>Districts in Uganda</p>
    </div>
    <div class="stat-item">
      <h3>8</h3>
      <p>African Markets</p>
    </div>
    <div class="stat-item">
      <h3>1997</h3>
      <p>Founded</p>
    </div>
  </div>

  {{-- Content Cards --}}
  <div class="about-section">

    <div class="about-card">
      <h2>🌍 Who We Are</h2>
      <p>
        For over two decades, Movit Products Limited has been at the forefront of the Beauty
        and Personal Care industry in Africa. Founded in 1997 by visionary entrepreneur
        Mr. Simpson Birungi, we have grown into Uganda's leading beauty and personal care company.
        Our mission is to enhance everyday living while celebrating the rich heritage of African
        Beauty — through innovation, quality, and a deep understanding of the African consumer.
      </p>
    </div>

    <div class="about-card">
      <h2>Our Story</h2>
      <p>
        Movit's journey began in 1997 with a bold vision: to create world-class beauty and
        personal care products rooted in African identity. From humble beginnings in Kampala,
        Uganda, we have expanded our reach across 8 African markets, touching lives in Kenya,
        Tanzania, Rwanda, Burundi, DRC, South Sudan, Zambia, and Malawi. Every step of our
        growth has been driven by passion, purpose, and an unwavering commitment to the
        people of Africa.
      </p>
    </div>

  </div>

</div>
@include('partials.alerts')
@endsection