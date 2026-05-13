@if(session('success'))
    <div class="alert success">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert error">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert error">
        <ul>
            @foreach($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<style>
    .alert {
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 14px;
        font-weight: bold;
    }

    .alert.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }
</style>