<!DOCTYPE html>
<html lang="id"> <!-- Deklarasi HTML dengan bahasa Indonesia -->
<head>
  <meta charset="UTF-8"> <!-- Set karakter encoding UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Supaya tampilan responsif di HP & PC -->
  <title>KPOM 2025 - Login</title> <!-- Judul tab browser -->
  
  <!-- Font dari Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">

  <style>
    /* Reset default browser style */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif; /* Pakai font Poppins */
    }

    /* Body utama */
    body {
      height: 100vh; /* Full layar */
      display: flex; /* Flexbox untuk center */
      justify-content: center; /* Rata tengah horizontal */
      align-items: center; /* Rata tengah vertikal */
      overflow: hidden; /* Hilangkan scroll */
      background: radial-gradient(circle at bottom, #1e1e2f, #0a0a0f); /* Background gradient gelap */
      position: relative; /* Supaya bintang bisa absolute */
      color: #fff; /* Warna teks default putih */
      opacity: 0;
      transform: scale(0.98);
      animation: fadeIn 1.2s ease-out forwards;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.98); }
      to { opacity: 1; transform: scale(1); }
    }

    /* Style bintang kecil */
    .star {
      position: absolute;
      width: 2px;
      height: 2px;
      background: white; /* Warna bintang putih */
      border-radius: 50%; /* Jadi bulat */
      animation: twinkle 1s infinite ease-in-out; /* Animasi kedip */
    }

    /* Animasi bintang */
    @keyframes twinkle {
      0%, 100% { opacity: 0.2; transform: scale(1); } /* redup */
      50% { opacity: 1; transform: scale(1.4); } /* terang & membesar */
    }

    /* Kotak login */
    .login-container {
      position: relative;
      background: rgba(65, 65, 65, 1); /* Transparan putih */
      padding: 40px 30px; /* Jarak isi */
      border-radius: 15px; /* Sudut membulat */
      box-shadow: 0 8px 20px rgba(0, 0, 0, 1); /* Bayangan */
      backdrop-filter: blur(12px); /* Efek kaca blur */
      text-align: center; /* Isi rata tengah */
      z-index: 10; /* Supaya di atas bintang */
    }

    /* Judul "KPOM 2025" */
    .login-container h1 {
      font-size: 32px;
      margin-bottom: 20px;
      background: linear-gradient(45deg, #ff6ec7, #4facfe); /* Gradasi teks */
      -webkit-background-clip: text; /* Potong background sesuai teks */
      -webkit-text-fill-color: transparent; /* Supaya gradasi masuk ke teks */
      animation: glow 2s infinite alternate; /* Animasi glow */
    }

    /* Animasi glow untuk judul */
    @keyframes glow {
      from { text-shadow: 0 0 5px #ff6ec7; } /* Glow pink kecil */
      to { text-shadow: 0 0 20px #4facfe; } /* Glow biru besar */
    }

    /* Input box */
    .login-container input {
      width: 100%; /* Full lebar */
      padding: 12px;
      margin: 12px 0;
      border: none; /* Hilangkan border */
      border-radius: 8px; /* Sudut melengkung */
      outline: none; /* Hilangkan garis fokus */
      font-size: 16px;
      text-align: center; /* Teks rata tengah */
    }

    /* Tombol login */
    .login-container button {
      margin-top: 10px;
      width: 100%; /* Full lebar */
      padding: 12px;
      background: linear-gradient(135deg, #6a11cb, #2575fc); /* Gradasi biru ungu */
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer; /* Ubah kursor jadi tangan */
      transition: transform 0.2s, box-shadow 0.2s; /* Efek hover smooth */
    }

    /* Efek hover tombol */
    .login-container button:hover {
      transform: scale(1.05); /* Sedikit membesar */
      box-shadow: 0 4px 12px rgba(37,117,252,0.4); /* Kasih bayangan biru */
    }
  </style>
</head>
<body>
  
  <!-- Box Login -->
  <div class="login-container">
    <h1>KPOML 2025</h1> <!-- Judul aplikasi -->
      <!-- Pesan error -->
      <div id="error-box" style="display:none; margin-bottom: 15px; padding: 10px; border-radius: 8px; background: rgba(255,0,0,0.2); color: #ff8080; font-size: 14px;">
      <i class="fa-solid fa-circle-exclamation"></i> <span id="error-msg"></span>
      </div>

    <form action="login_process.php" method="POST"> <!-- Form kirim ke login_process.php -->
      <input type="text" name="nis" placeholder="Masukkan NIS / NIM" required> <!-- Input NIS -->
      <button type="submit">Login</button> <!-- Tombol submit -->
    </form>
  </div>

  <!-- Script untuk bikin bintang random -->
  <script>
    const numStars = 100; // Jumlah bintang
    for (let i = 0; i < numStars; i++) {
      let star = document.createElement("div"); // Buat div baru
      star.className = "star"; // Kasih class star
      star.style.top = Math.random() * window.innerHeight + "px"; // Posisi random vertical
      star.style.left = Math.random() * window.innerWidth + "px"; // Posisi random horizontal
      star.style.animationDuration = (2 + Math.random() * 3) + "s"; // Durasi animasi random
      document.body.appendChild(star); // Masukkan ke body
    }
    
      // cek parameter error di URL
      const urlParams = new URLSearchParams(window.location.search);
      const errorBox = document.getElementById("error-box");
      const errorMsg = document.getElementById("error-msg");

      if (urlParams.get("error") === "nis_invalid") {
        errorBox.style.display = "block";
        errorMsg.textContent = "NIS tidak valid! Silakan coba lagi.";
      } 
      else if (urlParams.get("error") === "user_already_voted") {
        errorBox.style.display = "block";
        errorMsg.textContent = "Anda sudah melakukan voting sebelumnya!";
      }
  </script>
</body>
</html>
