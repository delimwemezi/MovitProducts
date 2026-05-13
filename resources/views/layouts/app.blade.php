
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
 
     <title>Movit @hasSection('title') - @yield('title') @endif</title>
 
    <!-- ✅ Falcon Favicon -->
    <link rel="icon" type="image/favicon.ico" href="/favicon.ico">
    <link rel="shortcut icon" type="image/favicon.ico" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/favicon.ico">
 
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
 
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
 
    @stack('styles')
</head>
<body>
    @include('navbar')          {{-- navbar once here --}}
    
    @if(session('success')) ... @endif
    @if(session('error')) ... @endif

    <main class="main-content">
        <div class="container">
            @yield('content')   {{-- home page content goes here --}}
        </div>
    </main>

    @include('footer')          {{-- footer once here --}}
    @stack('scripts')

     <script>
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', function () {
            this.classList.toggle('active');
        });
    });
</script>

</body>
</html>