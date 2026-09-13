<?php
session_start();
$nama = $_SESSION['nama'] ?? null;

$votedFile = 'csv/voted.csv';
$sudahVote = false;

// === CEK apakah user sudah pernah voting ===
if ($nama && file_exists($votedFile)) {
    $fp = fopen($votedFile, 'r');
    while (($row = fgetcsv($fp)) !== false) {
        if ($row[0] === $nama) { // kolom 0 = nama
            $sudahVote = true;
            break;
        }
    }
    fclose($fp);
}

// === Kalau user submit dan BELUM vote ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$sudahVote) {
    $selectedChoices = json_decode($_POST['selectedChoices'], true);
    $dataToSave = [$nama, $selectedChoices['osis'], $selectedChoices['mps'], $selectedChoices['ldp']];

    $fp = fopen($votedFile, 'a');
    fputcsv($fp, $dataToSave);
    fclose($fp);

    header('Location: redirect.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KPOM 2025 - Voting</title>
  <!-- Font Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
  <!-- Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    /* ===== CSS dari style-voting.css digabung di sini ===== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f5f7;
        color: #333;
        min-height: 100vh;
        overflow-x: hidden;
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
      0% { transform: translate(0,0); opacity: 1; }
      80% { opacity: 1; }
      100% { transform: translate(-250px, 250px); opacity: 0; }
    }
    .voting-container {
        scroll-snap-type: y mandatory;
        overflow-y: scroll;
        height: 100vh;
        position: relative;
        background: radial-gradient(circle at bottom, #1e1e2f, #0a0a0f);
    }
    .user-info {
        position: absolute;
        top: 20px;
        left: 20px;
        color: #ffffffff;
    }
    .user-info p { margin-bottom: 5px; }
    .user-info i { letter-spacing: 10px; }
    .not-you a {
        color: #6cb2feff;
        text-decoration: none;
    }
    .not-you a:hover { text-decoration: underline; }
    .voting-section {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px;
        scroll-snap-align: start;
        border-bottom: 1px solid #eeeeee00;
    }
    h1 {
        font-size: 2.5rem;
        margin-bottom: 30px;
        font-weight: 600;
        text-align: center;
        color: #fff;
    }
    .card-container {
        display: flex;
        gap: 30px;
    }
    .card {
        background-color: #fff;
        border: 2px solid transparent;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 122, 255, 0.3);
        flex: 1;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
        padding: 20px;
        width: 250px;
    }
    .card.selected {
        border-color: #007aff;
        box-shadow: 0 0 20px rgba(0, 122, 255, 0.3);
    }
    .card:hover {
        transform: scale(1.01);
        box-shadow: 0 0 50px rgba(0, 122, 255, 0.3);
    }
    .card-image {
        width: 100%;
        height: 150px;
        border-radius: 15px;
        background-color: #eee;
        margin-bottom: 20px;
        background-size: cover;
        background-position: center;
    }
    .card-content h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
    .card-content a {
        font-size: 1rem;
        color: #007aff;
        text-decoration: none;
    }
    .card-content a:hover { text-decoration: underline; }
    .selected-choices-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 30px;
        padding: 15px 20px;
        width: 100%;
    }
    .choices-display {
        display: flex;
        gap: 20px;
        font-size: 1.5rem;
        font-weight: 500;
        color: #333;
    }
    .choices-display span, .choices-display button {
        background-color: #eaf0f7;
        padding: 10px 15px;
        border-radius: 15px;
        color: #007aff;
        font-weight: 600;
    }
    .choices-display button {
        background-color: #007aff;
        color: #eaf0f7;
    }
    .submit-btn {
        padding: 12px 20px;
        font-size: 1.2rem;
        color: white;
        background-color: #007aff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .submit-btn i {
        font-size: 1.5rem;
        transition: transform 0.3s;
    }
    .submit-btn:hover i {
        transform: translateX(5px);
    }
    .scroll-down {
        position: fixed;   /* biar nempel terus di layar */
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 5rem;
        color: #fff;
        animation: bounce 1.5s infinite;
        cursor: pointer;
        opacity: 0.9;
        text-align: center;
        z-index: 1000;
    }
    .scroll-down span {
        display: block;
        font-size: 1rem;
        margin-top: 5px;
        letter-spacing: 1px;
        }
    .scroll-indicator {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 28px;
        color: #333;
        cursor: pointer;
        animation: bounce 1.5s infinite;
        z-index: 9999;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translate(-50%, 0);}
        40% {transform: translate(-50%, -10px);}
        60% {transform: translate(-50%, -5px);}
    }

    .hidden {
        display: none;
    }
  </style>
</head>
<body>
    <div class="scroll-down" onclick="scrollNextSection()">
        <span>Gulir ke bawah</span>
        <i class="fa-solid fa-chevron-down"></i>
    </div>

    <div class="voting-container">
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

        <div class="user-info">
            <!-- Nama user ditampilkan dari session -->
            <p><?php echo $_SESSION['nama']; ?></p>
            <!-- Link logout / ganti akun -->
            <p class="not-you"><a href="login.php">Bukan kamu?</a></p>
        </div>

        <form id="voting-form" method="POST">
            <!-- Pemilihan OSIS -->
            <section class="voting-section" id="osis-section">
                <h1>Pemilihan Calon Ketua OSIS</h1>
                <div class="card-container">
                    <!-- Setiap kandidat OSIS dibuat card -->
                    <div class="card" data-category="osis" data-id="osis-1">
                        <div class="card-image" style="background-image: url('foto-paslon/Bintang-Kautsar.JPG');"></div>
                        <div class="card-content">
                            <h3>Bintang & Kautsar</h3>
                            <a href="visi-misi/Bintang-Kautsar.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                    <div class="card" data-category="osis" data-id="osis-2">
                        <div class="card-image" style="background-image: url('foto-paslon/Firza-Zaidul2.JPG');"></div>
                        <div class="card-content">
                            <h3>Firza & Zaidul </h3>
                            <a href="visi-misi/Firza-Zaidul.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                    <div class="card" data-category="osis" data-id="osis-3">
                        <div class="card-image" style="background-image: url('foto-paslon/Irsyad-Nadhif (2).JPG');"></div>
                        <div class="card-content">
                            <h3>Irsyad & Nadhif</h3>
                            <a href="visi-misi/Irsyad-Nadhif.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
            </section>

            <!-- Pemilihan MPS -->
            <section class="voting-section" id="mps-section">
                <h1>Pemilihan Calon ketua MPS</h1>
                <div class="card-container">
                    <div class="card" data-category="mps" data-id="mps-1">
                        <div class="card-image" style="background-image: url('foto-paslon/Rafie-Adly.JPG');"></div>
                        <div class="card-content">
                            <h3>Rafie & Adly</h3>
                            <a href="visi-misi/Rafie-Adly.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                    <div class="card" data-category="mps" data-id="mps-2">
                        <div class="card-image" style="background-image: url('foto-paslon/Firyal-Zaya.JPG');"></div>
                        <div class="card-content">
                            <h3>Firyal & Zahwa</h3>
                            <a href="visi-misi/Firyal-Zaya.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                    <div class="card" data-category="mps" data-id="mps-3">
                        <div class="card-image" style="background-image: url('foto-paslon/Zola-Assyarof.JPG');"></div>
                        <div class="card-content">
                            <h3>Zola & Rafa</h3>
                            <a href="visi-misi/Zola-Assyarof.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Pemilihan LDP -->
            <section class="voting-section" id="ldp-section">
                <h1>Pemilihan Calon Ketua   LDP</h1>
                <div class="card-container">
                    <div class="card" data-category="ldp" data-id="ldp-1">
                        <div class="card-image" style="background-image: url('foto-paslon/Aisha-Auda1.JPG');"></div>
                        <div class="card-content">
                            <h3>Aisha & Auda</h3>
                            <a href="visi-misi/Aisyah-Auda.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                    <div class="card" data-category="ldp" data-id="ldp-2">
                        <div class="card-image" style="background-image: url('foto-paslon/dafi-taufik.JPG');"></div>
                        <div class="card-content">
                            <h3>Dafi & Taufiq</h3>
                            <a href="visi-misi/Dafi-Taufiq.php">Lihat Visi & Misi</a>
                        </div>
                    </div>
                </div>

                 <!-- Menampilkan ringkasan pilihan user -->
                <div class="selected-choices-container">
                    <div class="choices-display">
                        <span>OSIS: <span id="choice-osis">_</span></span>
                        <span>MPS: <span id="choice-mps">_</span></span>
                        <span>LDP: <span id="choice-ldp">_</span></span>
                        <!-- Tombol submit -->
                        <button type="submit" class="submit-btn">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Hidden input untuk simpan pilihan ke JSON -->
                <input type="hidden" name="selectedChoices" id="selectedChoices">
            </section>
            </form>

    <script>
          // Ambil semua section
        const sections = document.querySelectorAll("section");
        let currentSection = 0;

        function scrollNextSection() {
            currentSection++;
            sections[currentSection].scrollIntoView({ behavior: "smooth" });
        }
        

        // Object untuk simpan pilihan user
        const selectedChoices = {
            osis: null,
            mps: null,
            ldp: null
        };

        // Event klik pada setiap card
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', function() {
                const category = this.getAttribute('data-category');        // osis/mps/ldp
                const id = this.getAttribute('data-id');                    // misalnya "osis-1"
                const choiceNumber = id.split('-')[1];                      // Ambil nomor pilihan

                 // Hilangkan highlight di semua card kategori itu
                document.querySelectorAll(`.card[data-category="${category}"]`).forEach(otherCard => {
                    otherCard.classList.remove('selected');
                });

                // Tambahkan highlight ke card yang diklik
                this.classList.add('selected');
                // this.style.boxShadow = '0 0 10px rgba(0, 122, 255, 0.3)';

                // Simpan pilihan ke object
                selectedChoices[category] = choiceNumber;

                // Tampilkan ke ringkasan
                document.getElementById(`choice-${category}`).innerText = choiceNumber;
            });
        });

        // Saat tombol submit diklik
        document.querySelector('.submit-btn').addEventListener('click', function(event) {
            event.preventDefault(); // cegah submit default

            // Cek apakah semua kategori sudah dipilih
            if (selectedChoices.osis && selectedChoices.mps && selectedChoices.ldp) {

                // Simpan pilihan ke hidden input dalam format JSON
                document.getElementById('selectedChoices').value = JSON.stringify(selectedChoices);

                // Kirim form
                document.getElementById('voting-form').submit();
            } else {
                alert('Silakan pilih semua kategori sebelum submit.');
            }
        });
        window.addEventListener("scroll", () => {
            const sections = document.querySelectorAll("section");
            const lastSection = sections[sections.length - 1];
            const btn = document.getElementById("scroll-btn");

            if (window.scrollY + window.innerHeight >= lastSection.offsetTop + 50) {
                btn.style.display = "none"; // ilangin
            } else {
                btn.style.display = "flex"; // munculin lagi
            }
        });
    </script>
</body>
</html>
