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
                  <label for="email" class="form-label">Email</label>
                  <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required autofocus />
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
