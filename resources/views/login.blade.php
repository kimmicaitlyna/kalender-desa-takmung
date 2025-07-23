<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" 
          crossorigin="anonymous">

    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" 
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" 
            crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" 
            crossorigin="anonymous"></script>

    <style>
        body {
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center h-100">
        <div class="row w-100">
            <div class="col-12 col-md-6 col-lg-4 mx-auto bg-light p-4 rounded-3 shadow">
                <h3 class="text-center mb-4">Login to Your Account</h3>
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Enter email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("loginForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            try {
                const response = await fetch("http://127.0.0.1:8000/api/admin/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ email, password })
                });

                const resData = await response.json();
                console.log("status:", response.status);
                console.log("resData:", resData);

                if ((response.status === 200 || response.status === 201) && resData.status === true) {
                    alert("Login berhasil!");

                    // Simpan token ke localStorage
                    localStorage.setItem("adminToken", resData.data.token);

                    // Redirect ke halaman admin
                    window.location.href = '/admin/kalender';
                } else {
                    alert("Login gagal: " + resData.message);
                }

            } catch (error) {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat login. Periksa koneksi ke server.");
            }
        });
    </script>


</body>
</html>
