<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PutraCoffie</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>

        body{
            background: #f8f5f2;
            height: 100vh;
        }

        .login-card{
            border-radius: 15px;
            border: none;
        }

        .login-header{
            color: #4B2E2B;
            font-weight: 600;
        }

        /* Button Coffee */
        .btn-coffee {
            --bs-btn-color: #fff;
            --bs-btn-bg: #4B2E2B;
            --bs-btn-border-color: #4B2E2B;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #6F4E37;
            --bs-btn-hover-border-color: #6F4E37;
            --bs-btn-active-bg: #3b2422;
            --bs-btn-active-border-color: #3b2422;
        }

        .form-control:focus {
            border-color: #4B2E2B;
            box-shadow: 0 0 0 0.25rem rgba(75,46,43,0.25);
        }

    </style>

</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    
    <div class="card login-card shadow-sm" style="width:400px;">
        
        <div class="card-body p-4">

            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.webp') }}" width="70">
                <h4 class="login-header mt-2">PutraCoffee</h4>
                <small class="text-muted">Silahkan login terlebih dahulu</small>
            </div>

            <form class="needs-validation" novalidate action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                        <div class="invalid-feedback">
                            Email harus diisi
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                        <div class="invalid-feedback">
                            Password harus diisi
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button class="btn btn-coffee" type="submit">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Login
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Validation Script -->
<script>

(() => {
  'use strict'

  const forms = document.querySelectorAll('.needs-validation')

  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()

</script>

</body>
</html>