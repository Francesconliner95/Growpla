<body style="background-color:rgba(240,240,240,1); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';">
    <header style="text-align: center; padding: 10px;">
        {{-- <img src="{{ asset("storage/images/logo-fullsize.svg") }}" alt="" style="width: 85%; height: 140px; object-fit: contain;"> --}}
        <h1 style="color:#0AB89F">{{ config('app.name') }}</h1>
    </header>
    <main style="background-color:white; padding:50px; padding-top:30px; border-radius: 20px; margin-top:20px; margin-bottom:40px;">
        <h3 style="color: #3d4852; text-align: center;">Ciao, ti ringraziamo per aver mostrato interesse per Growpla, sei tra i 100 fortunati che la potranno utilizzare la piattaforma prima del lancio sul mercato!
        </h3>
         <p style="text-align:center;">Il tuo codice d'invito è: <strong>ARVTFD3</strong></p>
        <div style="text-align:center; padding:10px; margin:10px;">
            <a href="{{ route('register') }}" style="background-color:#0AB89F; border-radius:10px; border:none; color:white; padding: 10px 20px; text-decoration: none; font-weight:bold; margin:10px;">Registrati</a>
        </div>
        <div style="text-align:center; padding:5px;">
            <span style="color:#3d4852; font-size:13px;">Clicca su "Registrati" per creare il tuo account ed entrare a far parte della nostra community.</span>
        </div>
    </main>
    <footer style="text-align: center;">
        <span style="display:block; font-size: 11px; padding:20px; font-weight:bold; color:#0AB89F;">
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        </span>
    </footer>
</body>
