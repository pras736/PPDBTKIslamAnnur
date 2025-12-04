<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - TK Islam Annur</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />

    <style>
      :root{
        --brand: #16a34a; /* emerald-600 */
        --brand-700: #15803d;
        --muted: #6b7280;
      }
      .bg-brand{ background-color: var(--brand) !important; }
      .text-brand{ color: var(--brand) !important; }
      .btn-brand{ background-color: var(--brand); border-color: var(--brand); color: #fff; }
      .btn-brand:hover{ background-color: var(--brand-700); border-color: var(--brand-700); }
      .logo-rounded{ border-radius: 0.5rem; border: 2px solid #e5e7eb; background:#fff; }
      .card-auth{ max-width: 480px; }
    </style>
  </head>
  <body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
          <div class="text-center mb-4">
            <a href="/" class="d-inline-flex align-items-center gap-2 text-decoration-none">
              <img src="{{ asset('images/logo-tk-annur.jpg') }}" width="56" height="56" alt="Logo" class="logo-rounded" />
              <span class="h5 mb-0 text-brand fw-bold">TK Islam Annur</span>
            </a>
          </div>

          <div class="card shadow-sm card-auth mx-auto">
            <div class="card-body p-4">
              <h3 class="h5 mb-3 text-center">Masuk ke Akun</h3>

              @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
              @endif

              @if($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form method="POST" action="{{ url('/login') }}">
                @csrf

                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input id="username" name="username" type="text" class="form-control" value="{{ old('username') }}" required autofocus />
                </div>

                <div class="mb-3">
                  <label for="password" class="form-label">Kata Sandi</label>
                  <input id="password" name="password" type="password" class="form-control" required autocomplete="current-password" />
                </div>

                <div class="mb-3 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                    <label class="form-check-label" for="remember">Ingat saya</label>
                  </div>
                  <div>
                    @if (Route::has('password.request'))
                      <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa kata sandi?</a>
                    @else
                      <a href="/password/reset" class="small text-decoration-none">Lupa kata sandi?</a>
                    @endif
                  </div>
                </div>

                <div class="d-grid mb-3">
                  <button type="submit" class="btn btn-brand">Masuk</button>
                </div>

                {{-- Divider untuk Login dengan Google --}}
                <div class="d-flex align-items-center my-3">
                  <hr class="flex-grow-1">
                  <span class="px-2 text-muted small">atau</span>
                  <hr class="flex-grow-1">
                </div>

                {{-- Tombol Login dengan Google --}}
                <div class="d-grid mb-3">
                  <a href="{{ route('auth.google') }}" class="btn btn-outline-danger d-flex align-items-center justify-content-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                      <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                      <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                      <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                      <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Login dengan Google
                  </a>
                </div>

                <div class="text-center small text-secondary">
                  Belum punya akun?
                  @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-decoration-none">Daftar</a>
                  @else
                    <a href="/register" class="text-decoration-none">Daftar</a>
                  @endif
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
