import csv
import time
from datetime import datetime
import pandas as pd
import os

def hitung_suara():
    try:
        with open('voted.csv', newline='', encoding="utf-8") as csvfile:
            reader = csv.DictReader(csvfile)

            jumlah_osis = [0, 0, 0]   # 3 paslon OSIS
            jumlah_mps  = [0, 0, 0]   # 3 paslon MPS 
            jumlah_ldp  = [0, 0]      # 2 paslon LDP

            for row in reader:
                jumlah_osis[int(row['osis']) - 1] += 1
                jumlah_mps[int(row['mps']) - 1] += 1
                jumlah_ldp[int(row['ldp']) - 1] += 1

        return jumlah_osis, jumlah_mps, jumlah_ldp
    except Exception as e:
        print(f"Terjadi kesalahan saat membaca voted.csv: {e}")
        return [0, 0, 0], [0, 0, 0], [0, 0]

def simpan_progress(nama_file, waktu, data, labels=None):
    try:
        file_baru = not os.path.exists(nama_file)

        with open(nama_file, 'a', newline='', encoding="utf-8") as csvfile:
            writer = csv.writer(csvfile)

            if file_baru:
                if labels:
                    writer.writerow(['waktu'] + labels)
                else:
                    writer.writerow(['waktu'] + [f'paslon {i+1}' for i in range(len(data))])

            writer.writerow([waktu] + data)
            print(f"Progress disimpan ke {nama_file} pada {waktu}")
    except Exception as e:
        print(f"Terjadi kesalahan saat menyimpan ke {nama_file}: {e}")

def update_progress_bar(input_file, output_file):
    """Bikin file -bar.csv dari file progress biasa"""
    try:
        df = pd.read_csv(input_file)

        # Kalau file kosong (cuma header), skip
        if df.shape[0] == 0:
            print(f"{output_file} dilewati (belum ada data)")
            return

        # Ambil semua kolom kandidat (selain waktu)
        kolom = [c for c in df.columns if c != "waktu"]

        # Ubah ke format bar
        df_bar = df.melt(id_vars=["waktu"], value_vars=kolom,
                         var_name="paslon", value_name="suara")
        df_bar = df_bar.pivot(index="paslon", columns="waktu", values="suara").reset_index()

        df_bar.to_csv(output_file, index=False, encoding="utf-8")
        print(f"{output_file} berhasil diperbarui")
    except Exception as e:
        print(f"Gagal update {output_file}: {e}")

def catat_progress():
    print("Current working dir:", os.getcwd())
    try:
        while True:
            sekarang = datetime.now().strftime('%H:%M:%S')

            jumlah_osis, jumlah_mps, jumlah_ldp = hitung_suara()

            # Simpan OSIS
            simpan_progress('progress-osis.csv', sekarang, jumlah_osis,
                            labels=['Aleric & Kautsar', 'Firza & Atha', 'Irsyad & Nadhif'])
            update_progress_bar("progress-osis.csv", "progress-osis-bar.csv")

            # Simpan MPS
            simpan_progress('progress-mps.csv', sekarang, jumlah_mps,
                            labels=['Rafie & Adly', 'Hani & Zahwa', 'Zola & Assyarof'])
            update_progress_bar("progress-mps.csv", "progress-mps-bar.csv")

            # Simpan LDP
            simpan_progress('progress-ldp.csv', sekarang, jumlah_ldp,
                            labels=['Aisha & Auda', 'Dafi & Taufik'])
            update_progress_bar("progress-ldp.csv", "progress-ldp-bar.csv")

            print(f"\nProgress dicatat pada {sekarang}")
            print(f"OSIS: {jumlah_osis}")
            print(f"MPS: {jumlah_mps}")
            print(f"LDP: {jumlah_ldp}")
            
            time.sleep(30)

    except KeyboardInterrupt:
        print("\nProses dihentikan oleh pengguna. Keluar dari program.")
    except Exception as e:
        print(f"Terjadi kesalahan: {e}")

if __name__ == '__main__':
    catat_progress()
