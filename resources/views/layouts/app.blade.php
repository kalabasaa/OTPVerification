<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · OTPVerification</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
    <style>
        :root {
            --bg: #FDFDFC; --card: #fff; --text: #1b1b18; --muted: #706f6c;
            --line: #e3e3e0; --red: #FF2D20; --red-dark: #e0241a;
            --ok-bg: #ecfdf3; --ok-text: #027a48; --err: #d92d20;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #0a0a0a; --card: #161615; --text: #EDEDEC; --muted: #A1A09A;
                --line: #3E3E3A; --ok-bg: #0b2a1b; --ok-text: #6ee7a8; --err: #ff6b5e;
            }
        }
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; display: grid; place-items: center; padding: 1.5rem;
            background: var(--bg); color: var(--text);
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
        .card {
            width: 100%; max-width: 400px; background: var(--card); padding: 2rem;
            border-radius: 12px; box-shadow: 0 0 0 1px var(--line), 0 8px 24px rgba(0,0,0,.06);
        }
        .icon {
    width: 44px; height: 44px; border-radius: 10px; background: var(--red);
    display: grid; place-items: center; margin: 0 auto 1.25rem;
}
.icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
.icon.logo { background: none; border-radius: 0; width: auto; height: auto; }
.icon.logo svg { stroke: none; fill: #fff; width: 72px; height: 72px; }h1 { margin: 0 0 .4rem; font-size: 1.4rem; font-weight: 600; }
        p.sub { margin: 0 0 1.5rem; color: var(--muted); font-size: .92rem; line-height: 1.5; }
        input {
            width: 100%; padding: .75rem .9rem; font: inherit; color: var(--text);
            background: transparent; border: 1px solid var(--line); border-radius: 8px; outline: none;
        }
        input:focus { border-color: var(--red); box-shadow: 0 0 0 3px rgba(255,45,32,.15); }
        input.otp { text-align: center; font-size: 1.6rem; letter-spacing: .5em; padding-left: 1.1em; font-weight: 600; }
        .field-error { margin: .5rem 0 0; color: var(--err); font-size: .85rem; }
        .alert { padding: .7rem .9rem; border-radius: 8px; font-size: .9rem; margin-bottom: 1.25rem; background: var(--ok-bg); color: var(--ok-text); }
        .btn {
            width: 100%; margin-top: 1rem; padding: .8rem; font: inherit; font-weight: 500; color: #fff;
            background: var(--red); border: 0; border-radius: 8px; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: .6rem; transition: background .15s;
        }
        .btn:hover { background: var(--red-dark); }
        .btn[disabled] { opacity: .75; cursor: wait; }
        .spinner {
            display: none; width: 16px; height: 16px; border-radius: 50%;
            border: 2px solid rgba(255,255,255,.4); border-top-color: #fff; animation: spin .7s linear infinite;
        }
        .btn.loading .spinner { display: block; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .link { display: block; margin-top: 1.25rem; text-align: center; font-size: .88rem; color: var(--muted); text-decoration: none; }
        .link:hover { color: var(--red); }
    </style>
</head>
<body>
    <main class="card">
        @yield('content')
    </main>

    <script>
        // loading state on submit
        document.querySelectorAll('form[data-loading]').forEach(function (form) {
            form.addEventListener('submit', function () {
                var btn = form.querySelector('button[type=submit]');
                btn.disabled = true;
                btn.classList.add('loading');
                btn.querySelector('.label').textContent = form.dataset.loading;
            });
        });

        // digits only for the OTP box
        document.querySelectorAll('input[data-digits]').forEach(function (input) {
            input.addEventListener('input', function () {
                input.value = input.value.replace(/\D/g, '').slice(0, 6);
            });
        });

        // reset stuck loading state when coming back with the back button
        window.addEventListener('pageshow', function (e) {
            if (e.persisted) location.reload();
        });
    </script>
</body>
</html>