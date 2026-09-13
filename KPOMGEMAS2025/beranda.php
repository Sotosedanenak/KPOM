<!DOCTYPE html>
<html lang="id"> <!-- HTML pakai bahasa Indonesia -->
<head>
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KPOML 2025 - Beranda</title>

  <!-- Import font Poppins dari Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      background: radial-gradient(circle at bottom, #1e1e2f, #0a0a0f);
      overflow-x: hidden;
      color: #fff;
      position: relative;
      opacity: 0;
      transform: scale(0.98);
      animation: fadeIn 1.2s ease-out forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: scale(0.98); }
      to { opacity: 1; transform: scale(1); }
    }

    /* ================= STAR (Bintang Jatuh) ================= */
    .star {
      position: absolute;
      width: 2px;
      height: 2px;
      background: white;
      border-radius: 50%;
      animation: twinkle 2s infinite ease-in-out, shooting 8s linear infinite;
    }

    @keyframes twinkle {
      0%, 100% { opacity: 0.2; transform: scale(1); }
      50% { opacity: 1; transform: scale(1.5); }
    }

    @keyframes shooting {
      0% {
        transform: translate(0,0);
        opacity: 1;
      }
      80% {
        opacity: 1;
      }
      100% {
        transform: translate(-250px, 250px); /* ke kiri bawah */
        opacity: 0;
      }
    }

    /* ================= NAVBAR ================= */
    .navbar {
      width: 100%;
      padding: 12px 24px;
      display: flex;
      align-items: center;
      background: rgba(36, 36, 36, 1);
      backdrop-filter: blur(6px);
      z-index: 10;
    }

    .navbar img {
      height: 30px;
      margin-right: 10px;
    }

    .navbar h1 {
      font-size: 1.2rem;
      font-weight: 600;
      color: #ffffff;
    }

    /* ================= KONTEN UTAMA ================= */
    .container {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
      z-index: 2;
    }

    @keyframes glow {
      from { text-shadow: 0 0 5px #ff6ec7; }
      to { text-shadow: 0 0 20px #4facfe; }
    }

    .container h2 {
      font-size: 2.5rem;
      font-weight: 600;
      margin-bottom: 40px;
      background: linear-gradient(45deg, #ff6ec7, #4facfe);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: glow 2s infinite alternate;
    }

    .options {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }

    .card {
      background: rgba(65, 64, 64, 1);
      color: #ffffff;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.5);
      backdrop-filter: blur(12px);
      text-decoration: none;
      text-align: center;
      font-weight: 600;
      transition: 0.3s;
      width: 350px;
      z-index: 10;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(255, 255, 255, 0.4);
    }

    .card h3 {
      color: #ffffff;
      margin-bottom: 6px;
    }

    footer {
      text-align: center;
      padding: 10px;
      font-size: 0.8rem;
      color: #aaa;
      z-index: 2;
    }
  </style>
</head>
<body>
  <!-- Bintang random -->
  <div class="star" style="top:20vh; left:80vw; animation-delay:0s;"></div>
  <div class="star" style="top:40vh; left:60vw; animation-delay:1s;"></div>
  <div class="star" style="top:10vh; left:90vw; animation-delay:2s;"></div>
  <div class="star" style="top:30vh; left:70vw; animation-delay:3s;"></div>
  <div class="star" style="top:50vh; left:85vw; animation-delay:4s;"></div>
  <div class="star" style="top:60vh; left:95vw; animation-delay:5s;"></div>
  <div class="star" style="top:15vh; left:75vw; animation-delay:6s;"></div>
  <div class="star" style="top:35vh; left:65vw; animation-delay:7s;"></div>
  <div class="star" style="top:25vh; left:55vw; animation-delay:8s;"></div>
  <div class="star" style="top:5vh; left:45vw; animation-delay:9s;"></div>

  <!-- Navbar -->
  <div class="navbar">
    <img src="gambar/logo web.png" alt="Logo">
    <h1>Gemilang Astara</h1>
  </div>

  <!-- Konten utama -->
  <div class="container">
    <h2>KPOML 2025</h2>
    <div class="options">
      <a href="login.php" class="card">
        <h3>GTK</h3>
        <p>Masuk sebagai guru/petugas</p>
      </a>
      <a href="login.php" class="card">
        <h3>SISWA</h3>
        <p>Masuk sebagai siswa</p>
      </a>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    &copy; KPOML 2025
  </footer>
</body>
</html>