<?php
if (isset($_GET['data'])) {
  header('Content-Type: application/json');

  $osis = [0,0,0]; // 3 paslon OSIS
  $mps  = [0,0,0]; // 3 paslon MPS
  $ldp  = [0,0];   // 2 paslon LDP

  if(file_exists("csv/voted.csv")){
      if(($handle = fopen("csv/voted.csv", "r")) !== FALSE){
          $header = fgetcsv($handle); // buang header
          while(($row = fgetcsv($handle)) !== FALSE){
              if(count($row) < 4) continue;

              $osis_idx = intval($row[1]) - 1;
              $mps_idx  = intval($row[2]) - 1;
              $ldp_idx  = intval($row[3]) - 1;

              if($osis_idx >= 0 && $osis_idx < count($osis)) $osis[$osis_idx]++;
              if($mps_idx  >= 0 && $mps_idx  < count($mps))  $mps[$mps_idx]++;
              if($ldp_idx  >= 0 && $ldp_idx  < count($ldp))  $ldp[$ldp_idx]++;
          }
          fclose($handle);
      }
  }

  echo json_encode([
      "osis" => $osis,
      "mps"  => $mps,
      "ldp"  => $ldp
  ]);
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Monitor Voting</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    *{box-sizing:border-box}
    body{font-family:Segoe UI,Arial,Helvetica,sans-serif;background:#eef2f7;margin:0;color:#222}
    header{background:#fff;padding:20px 30px;box-shadow:0 2px 10px rgba(0,0,0,.08);position:sticky;top:0;z-index:99}
    header h1{margin:0;font-size:26px;font-weight:700;display:flex;align-items:center;gap:10px;justify-content:center}
    main{padding:32px;max-width:1300px;margin:0 auto}
    .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(340px,1fr));gap:28px}
    .card{background:#fff;border-radius:20px;box-shadow:0 6px 25px rgba(0,0,0,.08);padding:28px;display:flex;flex-direction:column;align-items:center;transition:.3s}
    .card:hover{transform:translateY(-3px);box-shadow:0 10px 30px rgba(0,0,0,.12)}
    .card h2{margin:0 0 18px;font-size:20px;font-weight:700;color:#333}
    .wrap{position:relative;width:100%;aspect-ratio:1/1;max-width:300px}
    canvas{position:absolute;inset:0;width:100%!important;height:100%!important}
    .footer{margin-top:16px;font-size:14px;color:#555;font-weight:500}
    .last-update{text-align:center;margin-top:28px;font-size:13px;color:#777}
  </style>
</head>
<body>
  <header>
    <h1>Monitor Hasil Voting Real-Time</h1>
  </header>

  <main>
    <div class="grid">
      <div class="card">
        <h2>OSIS</h2>
        <div class="wrap"><canvas id="osisChart"></canvas></div>
        <div class="footer" id="osisSum"></div>
      </div>
      <div class="card">
        <h2>MPS</h2>
        <div class="wrap"><canvas id="mpsChart"></canvas></div>
        <div class="footer" id="mpsSum"></div>
      </div>
      <div class="card">
        <h2>LDP</h2>
        <div class="wrap"><canvas id="ldpChart"></canvas></div>
        <div class="footer" id="ldpSum"></div>
      </div>
    </div>
    <div class="last-update" id="lastUpdate">⏳ Memuat data...</div>
  </main>

  <script>
    const osisChart = new Chart(document.getElementById('osisChart'), {
      type: 'pie',
      data: { labels: ['Aleric & Kautsar','Firza & Atha','Irsyad & Nadhif'],
        datasets: [{ data: [0,0,0],
          backgroundColor: ['#007AFF99','#34C75999','#FF950099'],
          hoverBackgroundColor: ['#007AFFCC','#34C759CC','#FF9500CC'],
          borderColor:'#fff', borderWidth:2 }]},
      options: { plugins:{ legend:{ position:'bottom' }}, animation:{ duration:600 } }
    });

    const mpsChart = new Chart(document.getElementById('mpsChart'), {
      type: 'pie',
      data: { labels: ['Rafie & Adly','Hani & Zahwa','Zola & Assyarof'],
        datasets: [{ data: [0,0,0],
          backgroundColor: ['#4BC0C099','#9966FF99','#FF9F4099'],
          hoverBackgroundColor: ['#4BC0C0CC','#9966FFCC','#FF9F40CC'],
          borderColor:'#fff', borderWidth:2 }]},
      options: { plugins:{ legend:{ position:'bottom' }}, animation:{ duration:600 } }
    });

    const ldpChart = new Chart(document.getElementById('ldpChart'), {
      type: 'pie',
      data: { labels: ['Aisha & Auda','Dafi & Taufik'],
        datasets: [{ data: [0,0],
          backgroundColor: ['#36A2EB99','#FF638499'],
          hoverBackgroundColor: ['#36A2EBCC','#FF6384CC'],
          borderColor:'#fff', borderWidth:2 }]},
      options: { plugins:{ legend:{ position:'bottom' }}, animation:{ duration:600 } }
    });

    function setFooter(id, arr){
      const sum = arr.reduce((a,b)=>a+b,0);
      document.getElementById(id).textContent = `Total suara: ${sum.toLocaleString('id-ID')}`;
    }

    async function loadAndUpdate(){
      try{
        const res = await fetch('monitor.php?data=1', {cache: 'no-store'});
        const json = await res.json();

        osisChart.data.datasets[0].data = json.osis;
        osisChart.update();
        setFooter('osisSum', json.osis);

        mpsChart.data.datasets[0].data = json.mps;
        mpsChart.update();
        setFooter('mpsSum', json.mps);

        ldpChart.data.datasets[0].data = json.ldp;
        ldpChart.update();
        setFooter('ldpSum', json.ldp);

        document.getElementById('lastUpdate').textContent =
          `🔄 Update terakhir: ${new Date().toLocaleTimeString('id-ID')}`;
      }catch(e){
        console.error('Gagal ambil data:', e);
        document.getElementById('lastUpdate').textContent = "⚠️ Gagal memuat data";
      }
    }

    loadAndUpdate();
    setInterval(loadAndUpdate, 100); // update tiap 5 detik
  </script>
</body>
</html>
