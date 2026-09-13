# website kpom

## direktori

```plaintext
kpom2/
│
├── csv/                       # berisi file csv untuk menyimpan dan memproses data terkait progress pemilihan
│   ├── progress-ldp-bar.csv    # berisi data voting kategori ldp dalam format untuk visualisasi bar
│   ├── progress-ldp.csv        # berisi data voting kategori ldp dalam format mentah (nilai per kandidat)
│   ├── progress-mps-bar.csv    # berisi data voting kategori mps dalam format untuk visualisasi bar
│   ├── progress-mps.csv        # berisi data voting kategori mps dalam format mentah (nilai per kandidat)
│   ├── progress-osis-bar.csv   # berisi data voting kategori osis dalam format untuk visualisasi bar
│   ├── progress-osis.csv       # berisi data voting kategori osis dalam format mentah (nilai per kandidat)
│   ├── progress.py             # script python untuk memproses dan mengupdate file progress voting.
│   │                           # script ini otomatis berjalan setiap 2 menit, tapi kalian bisa ubah waktu otomatisasi jika diperlukan.
│   │                           # script ini memperbarui file progress-*.csv untuk setiap kategori voting.
│   ├── run_progress.bat        # batch file untuk menjalankan script progress.py dengan sekali klik
│   └── voted.csv               # berisi daftar pemilih yang sudah melakukan voting
│
├── csv blank/                  # berisi template kosong dari file voted.csv
│   └── voted.csv               # template kosong untuk voted.csv, siap digunakan untuk reset data
│
├── foto-paslon/                # berisi foto dari para paslon, tinggal kalian ganti dengan foto terbaru paslon
│
├── visi-misi/                  # berisi file php untuk menampilkan visi dan misi tiap paslon
│   ├── aan-sayyid.php          # visi misi paslon aan-sayyid, tinggal disesuaikan
│   └── styles.css              # stylesheet untuk halaman visi dan misi
│
├── data.csv                    # berisi data pemilih yang digunakan oleh sistem, termasuk validasi login
├── index.php                   # halaman utama yang mengarahkan ke login atau ke halaman lain
├── log.txt                     # berisi log sistem, mencatat error atau aktivitas sistem selama proses pemilihan
├── login.php                   # halaman login untuk pengguna, mengarahkan ke halaman voting setelah berhasil
├── login_process.php           # menangani proses autentikasi setelah login
├── monitor.php                 # halaman untuk memonitor jalannya pemilihan secara real-time, menampilkan progress voting
├── not-voted.py                # script python untuk menampilkan daftar pemilih yang belum melakukan voting
├── redirect.php                # script untuk mengarahkan pengguna setelah selesai voting
└── voting.php                  # halaman untuk melakukan voting oleh pemilih terdaftar
```

## visualisasi

visualisasi progress pemilihan bisa pake platform **[app.flourish.studio](flourish)**. di sini kita bisa buat dan visualisasikan bar chart race **progress-ldp-bar.csv**, **progress-mps-bar.csv**, dan **progress-osis-bar.csv**. format data yang digunakan dalam file csv tadi udah siap buat dimasukkin ke dalam platform untuk divisualisasikan.

contoh visualisasi dapat dilihat [di sini](https://app.flourish.studio/visualisation/19895848/edit).

pastikan buat ngupload data sesuai dengan format yang ada di **progress-*-bar.csv**, yang sebenarnya cuma transpose dari progress-*, kami kemarin transposenya manual pakai excel, ada deh intinya caranya, cari aja. kalo memungkinkan, kalian juga bisa buat biar website secara otomatis menyimpan data dalam format tersebut, terus disimpen ke progress- (kemarin kami ga sempat bikin karena buru-buru), jadi kalian bisa langsung upload file progress- di flourish, yang progress--barnya tinggal dihapus deh

sebenernya mereka cuma butuh data transpose dari progress-*, kalian bisa liat sendiri

## cara menjalankan

untuk menjalankan **kpom** tahun 2023/2024, kami pakai **xampp** sebagai server lokal. berikut langkah-langkahnya:

1. **install xampp** di laptop yang bakal kalian gunain sebagai server.
2. Letakkan direktori **kpom/** di dalam folder `htdocs` milik XAMPP.
3. jalankan **XAMPP**, kemudian aktifkan **apache**.
4. hubungkan laptop klien ke hotspot lokal yang dibuat dari laptop host (server). laptop lain, atau client, harus terhubung ke hotspot ini.
5. setelah terhubung, buka **cmd** di laptop host dan ketik `ipconfig` untuk mengetahui **alamat IP**.
6. Laptop client bisa mengakses aplikasi dengan membuka browser dan memasukkan alamat IP laptop host, contoh: `http://192.168.x.x/kpom2`.

sampe kpom kemarin, kebanyakan hotspot laptop cuma bisa dihubungkan **maksimum 8 perangkat**. 

## persyaratan sistem

- **xampp** versi 3.3 atau lebih tinggi | [download](https://www.apachefriends.org/download.html)
- **python** 3.11 untuk menjalankan script python | [download]([https://app.flourish.studio/visualisation/19895848/edit](https://www.python.org/))

### catatan tentang windows firewall

pastikan buat ngatur biar **windows firewall** bolehin akses ke xampp. kalo enggak, websitenya mungkin gabisa diakses perangkat lain yang terhubung ke hotspot. caranya gini:

1. buka **control panel**.
2. pilih **system and security**.
3. klik **windows defender firewall**.
4. di sisi kiri, klik **allow an app or feature through windows defender firewall**.
5. cari **xampp** dalam daftar aplikasi, dan pastikan kedua opsi **private** dan **public** dicentang.
6. jika **xampp** tidak ada dalam daftar, klik **change settings** dan kemudian **allow another app**. cari direktori instalasi xampp, pilih **apache** dan tambahkan.
7. setelah selesai, klik **ok** untuk menyimpan pengaturan.

### catatan lain
- buat catat progress otomatis, HARUS BANGET buka progress.py di laptop server dari awal sampai habis, di sana kami bikin interval updatenya 2 menit sekali

## Log Perubahan

**Gadhraziel16**
- Membuat Sistem `KPOM`

**Giorzaviet17**
- Menghapus `kpom3.mp4`
- Memindahkan file style `style-login.css`, `style-monitor.css`, `style-voting.css` ke dalam file `.php`
- Mengubah isi file sesuai tema KPOM

---
**gadhraziel16**

👤 | hasbi | mhasbishidiq03@gmail.com | hasbio._ 

👤 | pawas | anugerahmuhazzib6@gmail.com | anugrh_fawwaz

👤 | faris | fariszikra90@gmail.com | fariszikraa 

* kalo ada yang mau ditanyain jangan sungkan
* terus kalo bisa lanjutin ya ke angkatan selanjutnya, diimprove juga ;)