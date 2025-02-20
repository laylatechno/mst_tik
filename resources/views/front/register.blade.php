<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="{{$title}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#625AFA">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags -->
    <!-- Title -->
    <title>{{$title}}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/upload/profil/' . ($profil->favicon ?: 'https://static1.squarespace.com/static/524883b7e4b03fcb7c64e24c/524bba63e4b0bf732ffc8bce/646fb10bc178c30b7c6a31f2/1712669811602/Squarespace+Favicon.jpg?format=1500w')) }}">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="{{ asset('template/front') }}/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('template/front') }}/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('template/front') }}/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('template/front') }}/img/icons/icon-180x180.png">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('template/front') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('template/front') }}/css/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('template/front') }}/css/animate.css">
    <link rel="stylesheet" href="{{ asset('template/front') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('template/front') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('template/front') }}/css/nice-select.css">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('template/front') }}/style.css">
    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('template/front') }}/manifest.json">
</head>

<body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
        <div class="spinner-grow text-secondary" role="status">
            <div class="sr-only"></div>
        </div>
    </div>
    <!-- Login Wrapper Area-->
    <div class="login-wrapper d-flex align-items-center justify-content-center text-center">
        <!-- Background Shape-->
        <div class="background-shape"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10 col-lg-8">
                    <a href="/">
                        <img id="logoImage"
                            src="{{ asset('/upload/profil/' . $profil->logo) }}"
                            alt="Logo"
                            data-light="{{ asset('/upload/profil/' . $profil->logo) }}"
                            data-dark="{{ asset('/upload/profil/' . $profil->logo_dark) }}">
                    </a>
                    <!-- Register Form-->
                    <div class="register-form mt-5">
                        <form id="registerForm">
                            <div class="form-group text-start mb-4">
                                <span>Username</span>
                                <label for="user"><i class="ti ti-user"></i></label>
                                <input class="form-control" id="user" name="user" type="text" required placeholder="Masukkan user tanpa spasi">
                            </div>

                            <div class="form-group text-start mb-4">
                                <span>Email</span>
                                <label for="email"><i class="ti ti-at"></i></label>
                                <input class="form-control" id="email" name="email" type="email" required placeholder="Masukkan email anda">
                            </div>

                            <div class="form-group text-start mb-4">
                                <span>Nama Pemilik</span>
                                <label for="name"><i class="ti ti-user"></i></label>
                                <input class="form-control" id="name" name="name" type="text" required placeholder="Masukkan nama pemilik">
                            </div>

                            <div class="form-group text-start mb-4">
                                <span>No WhatsApp Aktif</span>
                                <label for="wa_number"><i class="ti ti-ticket"></i></label>
                                <input class="form-control" id="wa_number" name="wa_number" type="text" required placeholder="Masukkan No WA anda">
                            </div>

                            <div class="form-group text-start mb-4"><span>Password</span>
                                <label for="password"><i class="ti ti-key"></i></label>
                                <input class="input-psswd form-control" id="password" type="password" name="password" placeholder="Masukkan Password">
                                <button type="button" id="toggle-password" class="btn btn-primary mt-2">Lihat Password</button>
                            </div>
                            <div class="form-group text-start mb-4"><span>Konfirmasi Password</span>
                                <label for="password"><i class="ti ti-key"></i></label>
                                <input class="input-psswd form-control" id="confirm-password" type="password" name="confirm-password" placeholder="Masukkan Konfirmasi Password">
                                <button type="button" id="toggle-confirm-password" class="btn btn-primary mt-2">Lihat Password</button>
                            </div>

                            <div class="form-group text-start mb-4">
                                <span>Tentang Toko (Ringkasan)</span>
                                <label for="about"><i class="ti ti-book"></i></label>
                                <input class="form-control" id="about" name="about" type="text" placeholder="Contoh : Menjual Berbagai Macam Fashion Pria & Wanita">
                            </div>

                            <button class="btn btn-warning btn-lg w-100" type="submit"><i class="ti ti-pencil"></i> Daftar</button>
                        </form>
                        <script>
                            document.getElementById("toggle-password").addEventListener("click", function() {
                                var passwordField = document.getElementById("password");
                                var passwordType = passwordField.type === "password" ? "text" : "password";
                                passwordField.type = passwordType;
                                this.textContent = passwordField.type === "password" ? "Lihat Password" : "Sembunyikan Password";
                            });

                            document.getElementById("toggle-confirm-password").addEventListener("click", function() {
                                var confirmPasswordField = document.getElementById("confirm-password");
                                var passwordType = confirmPasswordField.type === "password" ? "text" : "password";
                                confirmPasswordField.type = passwordType;
                                this.textContent = confirmPasswordField.type === "password" ? "Lihat Password" : "Sembunyikan Password";
                            });
                        </script>

                    </div>
                    <!-- Login Meta-->
                    <div class="login-meta-data">
                        <p class="mt-3 mb-0">Sudah punya akun?<a class="mx-1" href="/login">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <!-- All JavaScript Files-->
    <script src="{{ asset('template/front') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/front') }}/js/jquery.min.js"></script>
    <script src="{{ asset('template/front') }}/js/waypoints.min.js"></script>
    <script src="{{ asset('template/front') }}/js/jquery.easing.min.js"></script>
    <script src="{{ asset('template/front') }}/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('template/front') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('template/front') }}/js/jquery.counterup.min.js"></script>
    <script src="{{ asset('template/front') }}/js/jquery.countdown.min.js"></script>
    <script src="{{ asset('template/front') }}/js/jquery.passwordstrength.js"></script>
    <script src="{{ asset('template/front') }}/js/jquery.nice-select.min.js"></script>
    <script src="{{ asset('template/front') }}/js/theme-switching.js"></script>
    <script src="{{ asset('template/front') }}/js/active.js"></script>
    <script src="{{ asset('template/front') }}/js/pwa.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            event.preventDefault();

            // Reset previous error messages
            const errorElements = document.querySelectorAll('.error-message');
            errorElements.forEach(element => element.remove());

            // Get form data
            const formData = new FormData(this);

            // Check if passwords match
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (password !== confirmPassword) {
                showError('confirm-password', 'Password dan konfirmasi password tidak sama');
                return;
            }

            // Send AJAX request
            fetch('/proses_daftar', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/login';
                            }
                        });
                    } else {
                        // Show error messages
                        if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                showError(field, data.errors[field][0]);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengirim data. Silakan coba lagi nanti.',
                        confirmButtonText: 'OK'
                    });
                });
        });

        // Function to show error messages
        function showError(field, message) {
            const inputElement = document.getElementById(field);
            const errorElement = document.createElement('div');
            errorElement.className = 'error-message text-danger mt-1';
            errorElement.textContent = message;
            inputElement.parentNode.appendChild(errorElement);
        }
    </script>


</body>

</html>