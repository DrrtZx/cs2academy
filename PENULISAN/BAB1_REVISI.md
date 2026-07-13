UNIVERSITAS GUNADARMA
FAKULTAS ILMU KOMPUTER & TEKNOLOGI INFORMASI

/

PENULISAN ILMIAH

Perancangan dan Implementasi Website Platform Pembelajaran E-Sports Counter Strike 2 Berbasis Laravel (Studi Kasus: CS2Academy)

Nama		: Darrell Dzaky Ahnaf
NPM		: 10123296
Jurusan	: Sistem Informasi
Pembimbing 	: Indah Wahyuni, ST., MMSI., MSc.





JAKARTA
2026
# BAB 1 — PENDAHULUAN

## 1.1 	Latar Belakang
Perkembangan industri video game secara global dalam satu dekade terakhir mengalami transformasi yang sangat signifikan. Dari yang semula hanya dianggap sebagai hiburan semata, permainan video telah berkembang menjadi bagian dari ekosistem industri mencakup aspek hiburan, pendidikan, bisnis, hingga olahraga profesional yang dikenal luas dengan istilah Electronic Sports atau E-Sports. Berdasarkan laporan tahunan Newzoo berjudul Global Esports & Live Streaming Market Report, pada tahun 2022 pasar E-Sports global diproyeksikan melampaui pendapatan sebesar 1,38 miliar dolar Amerika Serikat, dengan total audiens global yang diperkirakan tumbuh hingga melampaui 640 juta orang pada tahun 2025 (Newzoo, 2022). Pertumbuhan ini ditopang oleh meningkatnya aksesibilitas internet, perkembangan infrastruktur digital, serta semakin luasnya penerimaan masyarakat terhadap E-Sports sebagai bentuk olahraga kompetitif yang legitimate.
Di antara berbagai judul permainan yang mendominasi lanskap E-Sports global, Counter-Strike 2 (CS2) yang dikembangkan oleh Valve Corporation menempatkan diri sebagai salah satu first-person shooter (FPS) yang paling berpengaruh dan memiliki basis pemain terbesar di dunia. CS2 dirilis secara resmi pada bulan September 2023 dan seketika mencatat rekor pemain aktif harian di platform distribusi digital Steam (Valve Corporation, 2023) .Popularitas CS2 tidak hanya bertumpu pada aspek kompetitif, melainkan juga pada kedalaman mekanik permainan yang menuntut penguasaan keterampilan teknis tinggi, meliputi pengendalian senjata, penempatan karakter, penguasaan peta, penggunaan perlengkapan taktis, serta pemahaman sistem ekonomi dalam permainan.
Di Indonesia, komunitas pemain CS2 mengalami pertumbuhan pesat seiring dengan meningkatnya penetrasi internet dan bertambahnya pusat gaming berstandar tinggi di berbagai kota besar. Turnamen CS2 lokal pun bermunculan, menandakan besarnya antusiasme komunitas. Namun demikian, pertumbuhan kuantitas pemain tersebut belum sepenuhnya diimbangi dengan ketersediaan sumber daya pembelajaran yang memadai, terstruktur, dan mudah diakses oleh para pemain Indonesia. Permasalahan utama yang dihadapi oleh pemain pemula hingga menengah adalah minimnya platform edukatif yang menyajikan konten pembelajaran CS2 secara sistematis dalam bahasa Indonesia. Sebagian besar sumber daya yang tersedia berasal dari platform luar negeri berbahasa Inggris yang kurang ramah bagi pengguna awam, Kondisi tersebut dapat menyulitkan pemain pemula hingga menengah dalam menentukan urutan materi yang perlu dipelajari dan mengevaluasi perkembangan pemahaman mereka (Hamari & Sjöblom, 2017).
Merespons kesenjangan tersebut, penulis terdorong untuk merancang dan mengimplementasikan sebuah platform pembelajaran E-Sports berbasis web yang diberi nama CS2Academy. Platform ini dikonseptualisasikan sebagai sebuah Learning Management System (LMS) yang secara spesifik ditujukan bagi komunitas pemain CS2 di Indonesia. Learning Management System merupakan aplikasi perangkat lunak yang digunakan untuk membuat, mengelola, menyampaikan, dan melacak proses pembelajaran atau pelatihan secara terstruktur. Melalui konsep tersebut, CS2Academy hadir dengan fitur kursus interaktif, kuis evaluasi, layanan coaching dalam tiga format, serta sistem sesi coaching dan percakapan melalui menu Tugas Saya yang memungkinkan interaksi langsung antara pengguna dan pelatih (SAP, 2026).
Dari sisi teknologi, pengembangan CS2Academy menggunakan framework Laravel, yaitu kerangka kerja berbasis PHP yang digunakan untuk membangun aplikasi web secara terstruktur. Laravel mendukung pola arsitektur Model-View-Controller (MVC), sehingga pengelolaan data, tampilan antarmuka, dan alur sistem dapat dipisahkan dengan lebih rapi. Dalam arsitektur tersebut, komponen Model digunakan untuk berinteraksi dengan basis data, sedangkan Controller berperan dalam mengatur proses permintaan pengguna dan menghubungkan data dengan tampilan sistem. Selain itu, Laravel juga menyediakan fitur database migration yang digunakan untuk mengelola perubahan struktur basis data selama proses pengembangan aplikasi (Bilal Haidar, 2025).
Untuk mengatasi permasalahan tersebut, penelitian ini merancang dan mengimplementasikan website pembelajaran E-Sports Counter-Strike 2 berbasis Laravel yang diberi nama CS2Academy. Website ini dirancang sebagai media pembelajaran digital yang dapat membantu pemain pemula hingga menengah dalam mempelajari dasar-dasar permainan CS2 secara lebih terarah dan terstruktur. CS2Academy menyediakan beberapa fitur utama, yaitu materi pembelajaran, kuis evaluasi, pelacakan progres belajar, layanan coaching, simulasi pembayaran, serta fitur percakapan dalam sesi coaching. Untuk mengatasi permasalahan tersebut, penelitian ini merancang dan mengimplementasikan website pembelajaran E-Sports Counter-Strike 2 berbasis Laravel yang diberi nama CS2Academy. Website ini dirancang sebagai media pembelajaran digital bagi pemain pemula hingga menengah dalam mempelajari dasar-dasar permainan CS2 secara lebih terarah dan terstruktur. CS2Academy menyediakan kursus berbasis modul, materi pembelajaran, video YouTube, kuis evaluasi, pelacakan progres belajar, layanan coaching, simulasi pembayaran, serta percakapan dalam sesi coaching.
Dengan adanya website CS2Academy, proses pembelajaran CS2 yang sebelumnya tersebar pada berbagai sumber dapat disajikan dalam satu platform berbasis web yang lebih sistematis, informatif, dan mudah diakses. Website ini diharapkan mampu menjadi media pembelajaran alternatif bagi komunitas pemain CS2 di Indonesia, khususnya bagi pemain pemula hingga menengah yang membutuhkan materi pembelajaran berbahasa Indonesia, evaluasi pembelajaran, serta layanan pendukung untuk meningkatkan kemampuan bermain secara lebih efektif.

## 1.2 	Ruang Lingkup
Ruang lingkup Penulisan Ilmiah ini berfokus pada perancangan dan implementasi website CS2Academy sebagai platform pembelajaran E-Sports Counter-Strike 2 berbasis Laravel. Website ini ditujukan bagi pemain tingkat pemula hingga menengah dengan menyediakan materi Aim and Movement, Map Control, Economy System, Utility Usage, dan Game Sense. Materi pembelajaran disusun dalam bentuk kursus yang terdiri atas beberapa modul. Setiap modul memuat materi, video YouTube apabila tersedia, dan kuis evaluasi. Progres pembelajaran dicatat berdasarkan modul yang telah diselesaikan, sedangkan modul berikutnya dapat diakses setelah modul sebelumnya berhasil diselesaikan.
Sistem melibatkan tiga jenis aktor, yaitu Guest, User, dan Admin. Guest dapat melihat halaman Beranda, katalog Kursus, dan halaman Coaching, tetapi autentikasi diperlukan untuk mengakses materi dan fitur lainnya. User dapat mengikuti kursus, mengerjakan kuis, memantau progres pembelajaran, memilih paket coaching, melakukan simulasi pembayaran, serta berkomunikasi dengan coach melalui menu Tugas Saya. Admin memiliki kewenangan untuk mengelola User, kursus, modul, kuis, pembayaran, dan sesi coaching. 
Layanan coaching dibatasi menjadi tiga paket, yaitu Textual Review berupa peninjauan permainan dan pemberian catatan tertulis dengan waktu penyelesaian maksimal 4 jam, Panggil Pelatih berupa pelatihan langsung melalui Discord selama 1 sesi game, serta Demo Review berupa analisis rekaman pertandingan dengan waktu penyelesaian maksimal 5 jam. Pemesanan dilakukan melalui simulasi pembayaran menggunakan BCA Virtual Account tanpa integrasi dengan payment gateway nyata. Pembayaran harus diverifikasi oleh Admin sebelum sesi coaching dapat diakses melalui menu Tugas Saya. Sesi yang telah diselesaikan akan dipindahkan ke bagian arsip dan hanya dapat dibaca.
Pengujian sistem dibatasi menggunakan metode Black Box Testing dan User Acceptance Testing (UAT). Black Box Testing digunakan untuk menguji kesesuaian fungsi sistem terhadap kebutuhan fungsional, sedangkan UAT digunakan untuk menilai kesesuaian sistem dengan kebutuhan pengguna dan penerimaan pengguna terhadap website yang dikembangkan.


## 1.3 	Tujuan Penelitian
Tujuan dari penelitian ini adalah untuk merancang dan mengimplementasikan website CS2Academy sebagai platform pembelajaran E-Sports Counter-Strike 2 berbasis Laravel yang digunakan sebagai media pembelajaran. Dengan adanya website ini, pemain pemula hingga menengah diharapkan dapat mempelajari dasar-dasar permainan CS2 dengan lebih terarah, sistematis, dan mempermudah pehamahan permainan.

## 1.4 	Metode Penelitian
	Metode penelitian yang digunakan dalam pengembangan website CS2Academy adalah metode Software Development Life Cycle (SDLC) dengan model Waterfall. Model Waterfall digunakan karena proses pengembangan sistem dilakukan secara sistematis dan berurutan, mulai dari tahap analisis kebutuhan, perancangan sistem, implementasi, hingga pengujian sistem(Wahid, 2020).Tahapan metode penelitian yang digunakan adalah sebagai berikut:
Analisis Kebutuhan
Pada tahap ini dilakukan identifikasi kebutuhan sistem berdasarkan permasalahan yang telah ditemukan. Kebutuhan yang dianalisis meliputi fitur materi pembelajaran, kuis evaluasi, pelacakan progres belajar, layanan coaching, simulasi pembayaran, percakapan dalam sesi coaching, serta hak akses Admin dan User.
Perancangan Sistem
Pada tahap ini dilakukan perancangan sistem untuk menggambarkan alur kerja dan struktur website CS2Academy sebelum diimplementasikan. Perancangan sistem meliputi pembuatan Use Case Diagram, Activity Diagram, Class Diagram, perancangan basis data, struktur navigasi, serta rancangan antarmuka pengguna.
Implementasi Sistem
Pada tahap ini hasil perancangan diterapkan ke dalam bentuk website menggunakan framework Laravel, bahasa pemrograman PHP, basis data MySQL, dan Blade sebagai template engine. Implementasi dilakukan dengan membangun fitur-fitur utama sesuai dengan kebutuhan Admin dan User.
Pengujian Sistem
Pada tahap ini dilakukan pengujian terhadap fitur-fitur utama website CS2Academy menggunakan metode Black Box Testing dan User Acceptance Testing (UAT). Black Box Testing digunakan untuk memastikan setiap fungsi sistem berjalan sesuai kebutuhan fungsional, sedangkan UAT digunakan untuk mengetahui apakah sistem yang dikembangkan telah sesuai dengan kebutuhan pengguna dan layak digunakan.
## 1.5	Sistematika Tulisan Ilmiah
Penulisan Ilmiah ini disusun ke dalam empat bab utama guna memberikan pemahaman yang komprehensif mengenai sistem informasi yang dikembangkan. Adapun sistematika penulisan tersebut diuraikan sebagai berikut:
Bab pertama adalah Pendahuluan, yang menguraikan latar belakang, ruang lingkup, tujuan penelitian, metode penelitian, serta sistematika penulisan. Bagian ini memberikan gambaran umum mengenai topik bahasan dan pendekatan yang diterapkan dalam penelitian.
Bab kedua adalah Tinjauan Pustaka, yang memaparkan berbagai landasan teori yang relevan dengan pengembangan aplikasi pengelolaan data berbasis website. Dalam bab ini, teori-teori pendukung dijabarkan secara sistematis untuk membangun kerangka pemahaman yang kuat.
Bab ketiga adalah Pembahasan, yang memuat uraian rinci mengenai proses perancangan aplikasi berbasis website. Bagian ini mencakup desain antarmuka, perancangan basis data, serta implementasi dan hasil uji coba sistem informasi yang telah dikembangkan.
Bab keempat adalah Penutup, yang berisi kesimpulan dari hasil perancangan sistem yang telah dilakukan serta saran yang dapat menjadi acuan bagi pengembangan aplikasi website di masa mendatang. Bagian ini memberikan ringkasan akhir terkait efektivitas sistem yang telah dibangun.







# BAB 2 — TINJAUAN PUSTAKA

### 2.1 E-Sports 
Electronic sports atau yang lebih dikenal dengan istilah e-sports merupakan bentuk kompetisi permainan video yang dilakukan secara terorganisasi antara pemain atau tim pemain dengan tujuan untuk meraih kemenangan dan pengakuan, baik dalam skala daring maupun pada ajang turnamen langsung. E-sports menggabungkan unsur olahraga kompetitif konvensional dengan teknologi permainan digital, sehingga melahirkan ekosistem industri tersendiri yang meliputi pemain profesional, penyelenggara turnamen, sponsor, serta penonton (Hamari & Sjöblom, 2017). Pertumbuhan industri e-sports turut didorong oleh meningkatnya jumlah penonton dan nilai pasar siaran langsung permainan video secara global (Newzoo, 2022).
Pemain e-sports dituntut memiliki keterampilan teknis yang setara dengan atlet pada olahraga konvensional, antara lain koordinasi tangan dan mata, kecepatan reaksi, kemampuan analisis taktis, serta kerja sama tim. Pertumbuhan komunitas e-sports juga mendorong munculnya kebutuhan akan media pembelajaran yang dapat membantu pemain baru memahami mekanisme permainan secara terstruktur, sehingga proses peningkatan keterampilan tidak hanya bergantung pada pengalaman bermain semata.

### 2.2 Counter-Strike 2 
Counter-Strike 2 (CS2) adalah permainan video bergenre first-person shooter (FPS) taktis yang dikembangkan dan diterbitkan oleh Valve Corporation sebagai penerus dari seri Counter-Strike: Global Offensive. Permainan ini mempertemukan dua tim yang masing-masing beranggotakan lima pemain dengan peran berlawanan, yaitu sebagai pihak penyerang (Terrorist) dan pihak bertahan (Counter-Terrorist), dengan tujuan utama menyelesaikan misi atau mengeliminasi seluruh anggota tim lawan dalam batas waktu tertentu (Valve Corporation, t.t.).
Sebagai salah satu cabang e-sports yang paling populer, CS2 menuntut tingkat pemahaman taktis yang tinggi, mulai dari penguasaan ekonomi dalam permainan (in-game economy), strategi penempatan posisi (positioning), pengelolaan lemparan granat (utility usage), hingga komunikasi tim secara real-time. Tingginya kompleksitas mekanisme permainan menjadikan kurva pembelajaran (learning curve) bagi pemain baru relatif tinggi, sehingga dibutuhkan media pembelajaran yang sistematis untuk mempercepat proses pemahaman strategi dan teknik dasar permainan.

### 2.3 Website
Website adalah kumpulan halaman yang saling terhubung dan dapat diakses melalui jaringan internet menggunakan peramban (browser), yang umumnya berisi informasi dalam bentuk teks, gambar, video, maupun elemen interaktif lainnya. Dalam konteks pembelajaran, website dapat dikembangkan menjadi sebuah platform pembelajaran daring (e-learning) yang memungkinkan penyampaian materi, latihan, dan evaluasi dilakukan secara mandiri oleh pengguna tanpa batasan waktu dan tempat (Yudhi Handika dkk., 2025).
Platform pembelajaran berbasis website pada umumnya menyediakan fitur penyampaian materi terstruktur, forum diskusi, serta sistem evaluasi yang dapat memantau perkembangan penggunanya. Penerapan konsep ini pada bidang e-sports memungkinkan komunitas pemain untuk memperoleh materi pembelajaran mengenai strategi dan teknik permainan secara terorganisasi, sehingga proses peningkatan keterampilan dapat dilakukan secara mandiri dan berkelanjutan.

2.4	Framework Laravel
Laravel adalah kerangka kerja (framework) sumber terbuka berbasis bahasa pemrograman PHP yang dirancang untuk mempermudah proses pengembangan aplikasi web melalui penerapan pola desain Model-View-Controller (MVC). Laravel menyediakan berbagai fitur bawaan, antara lain sistem routing, Object-Relational Mapping (ORM) bernama Eloquent untuk pengelolaan basis data, mesin templat Blade untuk tampilan antarmuka, serta sistem migrasi basis data yang memudahkan pengelolaan struktur tabel secara terversi (Installation | Laravel 13.x, t.t.).
Penggunaan Laravel dalam pengembangan platform pembelajaran memberikan beberapa keuntungan, di antaranya struktur kode yang terorganisasi, dukungan komunitas yang luas, serta ketersediaan dokumentasi resmi yang lengkap. Selain itu, Laravel juga dilengkapi dengan sistem autentikasi bawaan yang dapat dimanfaatkan untuk mengelola hak akses pengguna, seperti administrator dan member, sehingga sesuai dengan kebutuhan pengembangan platform pembelajaran e-sports yang melibatkan beberapa peran pengguna.

2.5	Laravel Breeze	
Laravel Breeze merupakan sebuah paket perangkat lunak pendukung (starter kit) resmi dari ekosistem Laravel yang dirancang untuk menyediakan fondasi sistem autentikasi aplikasi secara efisien dan terstandarisasi. Paket ini memfasilitasi pengembang dengan konfigurasi dasar yang komprehensif guna mengelola sesi pengguna (session-based authentication). Secara teknis, Laravel Breeze secara otomatis membangun fungsionalitas esensial yang siap pakai, seperti proses pendaftaran akun (registration), akses masuk (login), keluar sistem (logout), hingga mekanisme verifikasi alamat surel dan pengaturan ulang kata sandi. Seluruh implementasi tersebut dibangun menggunakan arsitektur Model-View-Controller (MVC) yang terintegrasi langsung dengan mesin templat Blade, sehingga menjamin keselarasan dengan standar pengembangan utama pada framework Laravel.
Implementasi Laravel Breeze dalam pengembangan sistem dinilai sangat optimal karena karakteristiknya yang ringan (lightweight) dan tidak membebani performa aplikasi secara keseluruhan. Berbeda dengan paket autentikasi lain yang menyembunyikan logika sistem di balik kerumitan fitur, Breeze mengedepankan transparansi dengan memublikasikan seluruh komponen pengendali (controllers) dan antarmuka (views) langsung ke dalam direktori utama aplikasi. Pendekatan ini memberikan tingkat fleksibilitas yang tinggi, sehingga memungkinkan pengembang untuk melakukan modifikasi serta penyesuaian logika sistem dan tata letak antarmuka secara mandiri agar secara presisi sesuai dengan analisis kebutuhan perancangan aplikasi
2.6	Metode Pengembangan SDLC
Metode Software Development Life Cycle (SDLC) merupakan pendekatan sistematis yang diaplikasikan untuk mendesain, membangun, serta memelihara suatu sistem informasi. Sejalan dengan perkembangan riset di ranah rekayasa perangkat lunak, para pakar telah merumuskan beragam model SDLC dengan spesifikasi yang bervariasi. Setiap model tersebut membawa keunggulan dan batasannya tersendiri, sehingga penerapannya dapat diselaraskan dengan kebutuhan spesifik dari suatu proyek. Pada praktiknya, masing-masing model menawarkan prosedur penyelesaian yang berbeda dalam proses pengembangan perangkat lunak. Salah satu pendekatan yang lazim digunakan adalah metode Waterfall, yaitu model SDLC beralur linier yang mensyaratkan kelima fasenya untuk dieksekusi secara berurutan.
Secara operasional, setiap model memiliki pendekatan yang berbeda dalam menyelesaikan pembangunan perangkat lunak. Salah satu model SDLC yang sering digunakan, yaitu Software Development Life Cycle (SDLC) metode Waterfall yang menerapkan pendekatan linier yang mengharuskan penyelesaian lima tahapan secara berurutan. (Wahid, 2020)
Penelitian terdahulu yang menerapkan model Waterfall dalam pengembangan aplikasi berbasis website menunjukkan bahwa tahapan yang berurutan memudahkan proses dokumentasi serta memberikan kejelasan target pada setiap fase pengembangan (Ridwan & Fitri, 2021). Tahapan model Waterfall yang diterapkan dalam pengembangan platform pembelajaran e-sports Counter-Strike 2 pada penulisan ini meliputi analisis kebutuhan sistem, desain basis data dan antarmuka, implementasi menggunakan framework Laravel, pengujian fungsionalitas sistem, serta evaluasi hasil sebagaimana akan diuraikan pada bagian Pembahasan.

2.7	HTML
	HyperText Markup Language (HTML) merupakan bahasa markah (markup language) standar yang menjadi fondasi utama dalam merancang dan menyusun kerangka sebuah situs web. Secara konseptual, HTML bukanlah sebuah bahasa pemrograman yang memiliki logika dinamis, melainkan kumpulan kode tak-terlihat atau tag terstruktur yang berfungsi untuk menginstruksikan peramban (web browser) tentang bagaimana teks, gambar, tautan, dan elemen multimedia lainnya harus ditampilkan di layar pengguna. Dalam konteks pengembangan Learning Management System (LMS) coaching e-sports, peran HTML sangat krusial sebagai fondasi struktural (layout) antarmuka sistem. HTML digunakan untuk membangun elemen-elemen kerangka dasar halaman, menyusun formulir pendaftaran pengguna, hingga mengelompokkan informasi modul kursus dan layanan pelatihan Counter-Strike 2 secara hierarkis. 
Dengan menggunakan markah dasar ini, informasi terkait CS2Academy dapat direpresentasikan dengan rapi ke dalam dokumen digital sebelum nantinya dimodifikasi secara visual menggunakan CSS maupun diintegrasikan dengan kerangka kerja Laravel. Penggunaan HTML menjamin bahwa struktur data yang direpresentasikan pada antarmuka pengguna dapat diakses secara konsisten melintasi berbagai jenis perangkat yang digunakan oleh para pemain pemula (Firman et al., 2016) Bentuk umum HTML adalah seperti berikut ini:
<!DOCTYPE html>
<html>
<head>
    <title>Sistem Informasi CS2Academy</title>
</head>
<body>
    <h1>Selamat Datang di Layanan Pelatihan Counter-Strike 2</h1>
    <p>Ini adalah halaman utama sistem pelatihan kami.</p>
</body>
</html>

2.8	PHP
	PHP atau Hypertext Preprocessor merupakan bahasa pemrograman server-side scripting yang bersifat sumber terbuka (Open Source) dan dirancang secara khusus untuk keperluan pengembangan perangkat lunak berbasis web. Berbeda dengan HTML yang hanya bertugas menampilkan struktur antarmuka secara statis, instruksi yang ditulis menggunakan sintaks PHP diproses sepenuhnya di dalam peladen (server) sebelum hasilnya dikirimkan ke peramban (browser) pengguna. Dalam pengembangan platform Learning Management System (LMS) coaching CS2Academy, kemampuan pemrosesan di sisi peladen ini sangat krusial untuk mengelola interaksi sistem yang dinamis. PHP digunakan untuk memvalidasi kredensial saat pengguna melakukan autentikasi (login), memproses dan memperbarui status transaksi pada fitur simulasi pembelian layanan coaching, mengevaluasi skor jawaban kuis secara real-time, hingga mengelola operasi penyimpanan dan pengambilan riwayat percakapan sesi coaching dari basis data relasional (Nursyaida et al., 2022)
	Dalam pengembangan platform Learning Management System (LMS) CS2Academy, PHP memegang peranan sebagai bahasa pemrograman fundamental. Namun, alih-alih menulis keseluruhan baris kode PHP secara murni (native) dari awal, sistem ini mengimplementasikan kerangka kerja (framework) Laravel. Laravel pada dasarnya dibangun sepenuhnya menggunakan bahasa pemrograman PHP tingkat lanjut yang telah diorganisasikan ke dalam arsitektur Model-View-Controller (MVC). Pendekatan ini tidak hanya mempercepat proses penulisan kode dibandingkan menggunakan PHP native, tetapi juga meningkatkan keamanan alur data saat sistem memproses autentikasi pengguna, mengevaluasi hasil kuis secara interaktif, dan mengelola transaksi pemesanan layanan coaching. Implementasi arsitektur MVC pada Laravel memisahkan logika bisnis, manipulasi data, dan antarmuka pengguna secara terstruktur, sehingga pengembangan sistem menjadi jauh lebih cepat, fleksibel, serta mempermudah pemeliharaan sistem di masa mendatang (Surono et al., 2022). Salah satu contoh script PHP yaitu :
<?php
echo "Selamat datang di CS2Academy";
?>

2.9	CSS
	Cascading Style Sheets (CSS) adalah bahasa penata gaya (style sheet language) yang difungsikan secara khusus untuk mengelola presentasi visual dan tata rupa dari dokumen HTML. Dalam pengembangan antarmuka platform Learning Management System (LMS) CS2Academy, jika HTML bertindak sebagai kerangka struktural yang menopang elemen-elemen kursus, maka CSS memegang peranan krusial sebagai penentu nilai estetika sistem. Bahasa ini mengendalikan tata letak (layout), implementasi skema warna gelap (dark-theme) yang menjadi identitas visual platform e-sports, penyesuaian tipografi, hingga efek interaktif pada komponen tombol pemesanan layanan coaching. Secara teknis, penerapan CSS memberikan keunggulan yang signifikan melalui prinsip pemisahan tanggung jawab (separation of concerns) antara dokumen konten utama dengan desain representasinya. Pendekatan ini memastikan tata kelola antarmuka menjadi lebih terpusat, konsisten, dan sangat memudahkan proses pemeliharaan kode sumber (source code) pada saat tata letak tersebut diintegrasikan ke dalam framework Laravel (Itba & Pksdu, 2024).
	Sebagai salah satu bentuk evolusi dari CSS konvensional, perancangan antarmuka situs web modern saat ini kerap memanfaatkan kerangka kerja (framework) Tailwind CSS. Tailwind merupakan framework CSS tingkat rendah (low-level) yang beroperasi secara fundamental menggunakan pendekatan utility-first. Berbeda dengan kerangka kerja tradisional yang menyediakan komponen visual baku dan kaku untuk dimodifikasi, Tailwind lebih menitikberatkan pada penggunaan kelas utilitas (utility classes). Aturan gaya seperti konfigurasi jarak (margin dan padding), palet warna, hingga tipografi dapat dieksekusi secara langsung dengan menyematkan nama kelas ke dalam tag HTML. Pendekatan utility-first ini memberikan keleluasaan penuh bagi pengembang untuk menyusun antarmuka yang sangat efisien dan dapat disesuaikan (customizable). Selain itu, struktur kode sumber (source code) menjadi jauh lebih bersih dan ringkas karena pengembang tidak perlu lagi bergantung pada penulisan sintaks gaya berulang pada dokumen CSS yang terpisah (Azhariyah & Muhammad Mukhlis, 2024).

### 2.10 Java Script
	JavaScript adalah bahasa pemrograman dinamis berjenis interpreted language yang mendukung pendekatan pemrograman berorientasi objek maupun fungsional. Bahasa ini dapat diimplementasikan baik pada sisi klien (client-side) maupun peladen (server-side) guna merancang halaman web yang interaktif. Sebagai salah satu teknologi fundamental World Wide Web yang berdampingan dengan HTML dan CSS, JavaScript memainkan peran esensial dalam memfasilitasi interaktivitas serta membangun aplikasi web yang dinamis (Kosanke, 2019). Adapun contoh dasar penulisan sintaks (syntax) JavaScript adalah sebagai berikut:
<script>
    console.log("Hello World");
</script>

### 2.10 Basis Data
	Basis data (database) merupakan kumpulan data yang tersentralisasi, terstruktur, dan memiliki hubungan logis yang tersimpan dalam media penyimpanan elektronik. Tidak seperti metode pencatatan manual yang rentan terhadap duplikasi data (redudansi), sistem basis data dirancang untuk menyatukan berbagai dokumen agar setiap data dapat dikelola, diperbarui, dan diambil kembali dengan lebih praktis. Di bidang rekayasa perangkat lunak, tata kelola basis data ini ditangani oleh sebuah program spesifik yang dikenal sebagai Sistem Manajemen Basis Data (DBMS). Lewat DBMS dan penggunaan bahasa kueri, pengembang memiliki keleluasaan untuk merancang struktur tabel, menentukan keterikatan antar-entitas, hingga mengolah informasi seperti menambah dan menghapus data secara fleksibel (Dr. Ruliah, M.Kom. Andri Suryadi, S.Kom., 2016).
Konsep Utama dalam basis data, meliputi:
Primary Key (Kunci Utama): Merupakan sebuah atribut (atau gabungan beberapa kolom) yang dipilih dari sekumpulan candidate key untuk bertindak sebagai pengenal (identitas) unik bagi setiap rekam (record) data di dalam sebuah tabel. Penggunaan kunci utama ini menjamin bahwa tidak ada baris data yang bersifat duplikat.
Foreign Key (Kunci Tamu): Merupakan sebuah atribut di dalam suatu tabel yang memiliki nilai yang merujuk langsung pada Primary Key milik tabel lain. Kunci tamu ini memiliki peran krusial sebagai jembatan penghubung referensial antar-tabel, sekaligus memastikan bahwa konsistensi dan integritas data tetap terjaga dengan baik.
Selain pendefinisian atribut kecil, arsitektur basis data juga ditentukan oleh
kardinalitas. Kardinalitas merupakan aturan pemetaan yang menunjukkan jumlah maksimal entitas yang dapat berelasi dengan entitas pada himpunan lainnya. Secara umum, kardinalitas relasi diklasifikasikan ke dalam empat jenis, yaitu :
One-to-One (Satu-ke-Satu): Merupakan bentuk pemetaan di mana satu rekam data pada himpunan entitas A hanya berkorespondensi tepat dengan satu rekam data pada himpunan entitas B, dan kondisi tersebut berlaku secara timbal balik.
One-to-Many (Satu-ke-Banyak): Merupakan bentuk pemetaan di mana satu rekam data pada himpunan entitas A dapat berelasi dengan banyak rekam data pada himpunan entitas B, namun tidak sebaliknya.
Many-to-One (Banyak-ke-Satu): Merupakan kebalikan dari One-to-Many, di mana banyak rekam data pada himpunan entitas A hanya dapat berelasi dengan satu entitas pada himpunan B
Many-to-Many (Banyak-ke-Banyak): Merupakan bentuk pemetaan kompleks di mana setiap rekam data pada himpunan entitas  dapat berelasi dengan banyak data pada himpunan B, dan hal ini juga berlaku sebaliknya.

### 2.11 Visual Studio Code
	Visual Studio Code (VS Code) merupakan perangkat lunak penyunting teks open-source besutan Microsoft yang kini telah berkembang menjadi alat bantu yang krusial bagi akademisi dan peneliti dalam proses penyusunan karya ilmiah. Aplikasi ini menyediakan lingkungan kerja yang efisien dan responsif, didukung oleh ekosistem ekstensi yang komprehensif. Melalui fleksibilitas tersebut, pengguna dapat mengintegrasikan berbagai perangkat pendukung mulai dari manajemen referensi hingga sistem kontrol versi ke dalam satu antarmuka yang terpadu guna menyederhanakan alur kerja penulisan.
Dalam lingkup penulisan karya ilmiah, keunggulan utama VS Code terletak pada dukungan format dokumen berbasis markup, seperti Markdown dan LaTeX. Dengan memanfaatkan ekstensi khusus seperti LaTeX Workshop, penulis dapat mengolah naskah ilmiah yang kompleks termasuk penulisan rumus matematika yang rumit serta pengelolaan sitasi secara otomatis dengan fitur pratinjau yang tersedia secara real-time. Kemampuan ini meminimalkan hambatan teknis dalam pengaturan format dokumen, sehingga penulis dapat memberikan fokus penuh pada substansi dan kualitas materi penelitian.
Selain efisiensi teknis, VS Code menawarkan manajemen proyek yang andal melalui integrasi sistem kontrol versi Git. Fitur ini sangat esensial karena memungkinkan pelacakan perubahan naskah secara sistematis, sehingga memberikan kepastian keamanan data serta kemudahan dalam mengembalikan draf ke versi sebelumnya jika diperlukan. Kombinasi antara antarmuka yang intuitif, fitur IntelliSense, dan terminal terintegrasi menjadikan VS Code sebagai instrumen produktivitas yang mumpuni, yang mampu mendukung kebutuhan penulisan ilmiah secara terstruktur, rapi, dan profesional (Murani et al., 2025).

### 2.12 UML
	Unified Modeling Language (UML) merupakan standar bahasa pemodelan visual yang bersifat universal dan terstruktur, yang dirancang untuk memvisualisasikan, merancang, serta mendokumentasikan sistem perangkat lunak secara komprehensif. Sebagai instrumen komunikasi dalam rekayasa perangkat lunak, UML menyediakan kumpulan diagram yang memungkinkan pengembang untuk memetakan arsitektur sistem, alur proses bisnis, serta interaksi antar-objek sebelum tahap implementasi kode dimulai. Dengan penggunaan notasi yang terstandarisasi, UML berperan krusial dalam menjembatani kesenjangan pemahaman antara pemangku kepentingan (stakeholders) dan tim pengembang, sehingga kompleksitas sebuah sistem dapat disederhanakan menjadi representasi grafis yang logis dan mudah dipahami. 
Penggunaan UML dalam pengembangan perangkat lunak mencakup berbagai aspek perancangan, baik yang bersifat struktural maupun perilaku. Diagram struktural, seperti Class Diagram, digunakan untuk menggambarkan komponen statis dalam sistem, sementara diagram perilaku, seperti Use Case Diagram atau Sequence Diagram, berfungsi untuk memetakan alur kerja sistem serta interaksi fungsional yang terjadi. Dengan menggunakan UML, proses pengembangan sistem menjadi lebih terukur, terdokumentasi dengan baik, dan memudahkan dalam pemeliharaan maupun pengembangan sistem di masa depan karena spesifikasi teknis telah terdefinisikan secara jelas dan sistematis melalui model visual (Prihandoyo, 2018). Terdapat delapan diagram dalam Unified Modeling Language , di antaranya adalah Use Case Diagram, Class Diagram, Statechart Diagram, Sequence Diagram, Collaboration Diagram, Activity Diagram, Component Diagram dan Deployment Diagram.

2.12.1	Use Case Diagram
	Use Case Diagram merupakan suatu model visual yang merepresentasikan perilaku (behavior) dari sistem informasi yang akan dikembangkan. Diagram ini secara spesifik menguraikan bentuk interaksi yang terjadi antara satu atau beberapa aktor dengan sistem tersebut. Tujuan utama dari penggunaan Use Case adalah untuk mengidentifikasi berbagai fungsionalitas yang tersedia di dalam sistem, sekaligus memetakan siapa saja entitas yang memiliki otoritas atau hak akses untuk mengoperasikan fungsi-fungsi tersebut. Adapun rincian penjelasan mengenai simbol-simbol dalam Use Case Diagram dapat ditinjau lebih lanjut pada Tabel 2.1.
Tabel 2.1 Simbol Use Case Diagram
/
2.12.2	Activity Diagram
	Activity Diagram adalah bentuk pemodelan grafis yang memvisualisasikan alur kerja (workflow) dari suatu sistem maupun proses bisnis. Diagram ini secara spesifik menguraikan urutan aktivitas yang dieksekusi oleh aktor maupun sistem, lengkap dengan alur kontrol yang mengoordinasikan transisi perpindahan dari satu tahapan ke tahapan lainnya. Adapun penjabaran lebih rinci mengenai simbol-simbol yang digunakan di dalam Activity Diagram dapat ditinjau pada Tabel 2.2.
Tabel 2.2 Simbol Activity Diagram
/
2.12.3	Class Diagram
Diagram Kelas (Class Diagram) merupakan representasi statis yang menggambarkan struktur suatu sistem. Diagram ini menunjukkan susunan sistem berdasarkan definisi kelas-kelas yang akan digunakan dalam proses pembangunan sistem. Penjelasan mengenai simbol-simbol yang terdapat pada Class Diagram dapat dilihat pada Tabel 2.12.
Tabel 2.3 Simbol Class Diagram
/

### 2.13 Figma
Figma merupakan platform desain berbasis komputasi awan (cloud-based) yang dikembangkan secara spesifik untuk mendukung proses pembuatan purwarupa (prototyping) antarmuka pengguna (User Interface) dan pengalaman pengguna (User Experience). Arsitektur sistem yang diusung oleh Figma memungkinkan kolaborasi desain dilakukan secara sinkron dan real-time melalui antarmuka peramban web. Penggunaan platform ini memberikan fleksibilitas bagi pengembang dalam merancang hierarki informasi, tipografi, skema warna, serta tata letak (layout) dengan akurasi tinggi sebelum sistem tersebut diimplementasikan ke dalam bahasa pemrograman. Melalui kemampuan iterasi desain yang interaktif, Figma telah menjadi instrumen standar yang efektif dalam menyelaraskan gagasan konseptual menjadi produk perangkat lunak yang fungsional (Al-Faruq et al., 2022).
### 2.14 Draw.io
	Perancangan sistem informasi merupakan tahapan krusial dalam siklus pengembangan perangkat lunak yang bertujuan untuk merumuskan cetak biru alur kerja sistem secara terstruktur. Guna mendukung pemodelan visual tersebut, perangkat lunak Draw.io diimplementasikan sebagai instrumen utama dalam mendokumentasikan proses bisnis. Pemilihan ini didasarkan pada kapabilitas Draw.io dalam menghasilkan diagram yang selaras dengan standar dokumentasi teknis, serta menawarkan efisiensi operasional melalui antarmuka drag-and-drop yang intuitif. Di samping itu, kerangka kerja (framework) Laravel diaplikasikan dalam tahapan pengembangan sistem mengingat keunggulannya dalam mengelola struktur navigasi secara dinamis dan menyediakan fitur keamanan yang terintegrasi. Karakteristik tersebut merupakan aspek fundamental yang dibutuhkan guna membangun sistem informasi berbasis web yang terukur (scalable) (Studi et al., 2025).
### 2.15 Struktur Navigasi
Struktur navigasi merupakan rancangan alur hubungan antarhalaman dalam sebuah aplikasi atau website yang digunakan untuk memudahkan pengguna dalam mengakses setiap fitur yang tersedia. Dalam pengembangan website, struktur navigasi berperan penting karena dapat menentukan kemudahan pengguna dalam berpindah dari satu halaman ke halaman lainnya secara terarah. Website yang baik perlu memiliki struktur navigasi yang jelas, responsif, dan mudah dipahami agar informasi dapat diakses secara efektif oleh pengguna melalui berbagai perangkat (Azhariyah & Muhammad Mukhlis, 2024).
Pada pengembangan platform CS2Academy, struktur navigasi digunakan untuk menggambarkan alur perpindahan halaman pada sistem, mulai dari halaman utama, halaman autentikasi, dashboard pengguna, halaman kursus, kuis, layanan coaching, hingga halaman administrasi. Perancangan struktur navigasi ini bertujuan agar pengguna, baik Admin maupun User, dapat mengakses fitur sesuai dengan hak akses dan kebutuhannya masing-masing. Perancangan alur sistem yang jelas juga mendukung proses implementasi aplikasi berbasis web agar lebih terstruktur dan mudah dikembangkan (Surono et al., 2022).
2.15.1.	Struktur Navigasi Linear
Struktur navigasi linear merupakan struktur navigasi yang memiliki alur perpindahan halaman secara berurutan dari satu halaman ke halaman berikutnya. Pada struktur ini, pengguna mengikuti tahapan yang telah ditentukan oleh sistem sehingga proses akses berjalan secara sistematis. Struktur linear umumnya digunakan pada proses yang memiliki urutan tetap, seperti proses registrasi, login, pengerjaan kuis, atau penyelesaian materi pembelajaran secara bertahap (Surono et al., 2022).
/
Gambar 2.1 Struktur Navigasi Linier

2.15.2.	Struktur Navigasi Hirarki
Struktur navigasi hirarki merupakan struktur navigasi yang memiliki susunan bertingkat dari halaman utama menuju beberapa halaman turunan. Struktur ini sering digunakan pada website yang memiliki banyak menu dan sub-menu karena mampu mengelompokkan informasi berdasarkan kategori tertentu. Dengan struktur hirarki, pengguna dapat memulai akses dari halaman utama, kemudian memilih menu sesuai kebutuhan untuk menuju halaman yang lebih spesifik (Azhariyah & Muhammad Mukhlis, 2024).	
/
Gambar 2.2 Struktur Navigasi Hirarki

2.15.3.	Struktur Navigasi Non-Linear
Struktur navigasi non-linear merupakan bentuk struktur navigasi yang memungkinkan pengguna berpindah dari satu halaman ke halaman lain secara bebas tanpa harus mengikuti urutan tertentu. Struktur ini memberikan fleksibilitas kepada pengguna dalam memilih menu atau fitur yang ingin diakses sesuai kebutuhannya. Navigasi non-linear umumnya digunakan pada website yang memiliki banyak pilihan halaman dan tidak seluruh prosesnya harus dilakukan secara berurutan (Azhariyah & Muhammad Mukhlis, 2024).
/
Gambar 2.3 Struktur Navigasi Non-Linear
2.15.4.	Struktur Navigasi Campuran
Struktur navigasi campuran merupakan struktur navigasi yang menggabungkan beberapa bentuk navigasi, seperti struktur navigasi linear, hirarki, dan non-linear dalam satu rancangan sistem. Struktur ini digunakan pada website yang memiliki alur akses beragam, sehingga pengguna dapat mengikuti proses tertentu secara berurutan, namun tetap memiliki kebebasan untuk berpindah ke halaman lain sesuai dengan kebutuhan. Dengan adanya struktur navigasi campuran, sistem dapat menyajikan alur yang terarah sekaligus fleksibel bagi pengguna (Azhariyah & Muhammad Mukhlis, 2024).
/
Gambar 2.4 Struktur Navigasi Campuran

### 2.16 Black Box Testing
Black Box Testing atau pengujian kotak hitam merupakan metode pengujian perangkat lunak yang berfokus pada pengujian fungsi-fungsi sistem berdasarkan kebutuhan dan spesifikasi yang telah ditentukan tanpa memperhatikan struktur kode program atau proses internal sistem. Metode ini digunakan untuk memastikan bahwa setiap fitur yang tersedia pada aplikasi dapat berjalan sesuai dengan tujuan yang telah dirancang serta menghasilkan keluaran (output) yang sesuai dengan masukan (input) yang diberikan pengguna. Dalam pengujian ini, penguji bertindak sebagai pengguna akhir yang berinteraksi langsung dengan sistem untuk memverifikasi kebenaran fungsi yang tersedia.
Pada pengembangan platform pembelajaran E-Sports Counter-Strike 2 berbasis web CS2Academy, metode Black Box Testing digunakan untuk mengevaluasi seluruh fitur utama yang tersedia pada sistem, seperti autentikasi pengguna, pengelolaan kursus, pengerjaan kuis, pemesanan layanan coaching, pengiriman tugas (sesi coaching dan percakapan melalui menu Tugas Saya), hingga simulasi proses pembayaran. Penggunaan metode ini bertujuan untuk memastikan bahwa setiap fungsi yang diakses oleh Admin maupun User dapat beroperasi sesuai dengan kebutuhan sistem yang telah didefinisikan pada tahap analisis dan perancangan. 
Pengujian Black Box tidak dimaksudkan untuk menggantikan metode pengujian lainnya, melainkan sebagai pendekatan yang berfokus pada validasi fungsionalitas sistem dari perspektif pengguna. Dengan demikian, berbagai kesalahan yang berkaitan dengan proses interaksi pengguna terhadap sistem dapat teridentifikasi secara lebih efektif sebelum aplikasi digunakan secara nyata.
Melalui penerapan Black Box Testing pada platform CS2Academy, pengujian dilakukan untuk meminimalkan kemungkinan terjadinya kesalahan pada aspek-aspek berikut:
Kesalahan atau ketidaksesuaian fungsi sistem (functional errors), yaitu memastikan seluruh fitur seperti registrasi, login, pengelolaan kursus, akses materi pembelajaran, pengerjaan kuis, layanan coaching, dan pengiriman tugas dapat berjalan sesuai dengan kebutuhan yang telah ditentukan. 
Kesalahan antarmuka pengguna (user interface errors), yaitu memastikan setiap menu, tombol, formulir, dan komponen antarmuka pada website dapat berfungsi dengan baik serta memberikan respons yang sesuai terhadap tindakan pengguna. 
Kesalahan pengelolaan data dan akses basis data (database errors), yaitu menguji ketepatan proses penyimpanan, pembaruan, penghapusan, dan pengambilan data yang berkaitan dengan akun pengguna, kursus, kuis, transaksi coaching, serta data tugas yang tersimpan pada basis data MySQL. 
Kesalahan proses dan alur sistem (workflow errors), yaitu memastikan seluruh proses bisnis dalam aplikasi, seperti penyelesaian kursus secara bertahap, validasi hasil kuis, proses pemesanan coaching, dan pemberian umpan balik (feedback) dapat berjalan sesuai alur yang telah dirancang. 
Kesalahan validasi data masukan (input validation errors), yaitu memastikan sistem mampu memberikan notifikasi atau pesan kesalahan ketika pengguna memasukkan data yang tidak lengkap, tidak valid, atau tidak sesuai dengan aturan yang telah ditetapkan.
Kesalahan autentikasi dan otorisasi pengguna (authentication and authorization errors), yaitu memastikan hak akses Admin dan User diterapkan dengan benar sehingga setiap pengguna hanya dapat mengakses fitur yang sesuai dengan perannya masing-masing. 
Kesalahan inisialisasi dan terminasi sistem, yaitu memastikan halaman aplikasi dapat dimuat dengan baik saat diakses pertama kali serta proses keluar (logout) dapat berjalan dengan benar untuk menjaga keamanan akun pengguna. 
Dengan dilaksanakannya pengujian menggunakan metode Black Box Testing, diharapkan seluruh fungsionalitas pada website CS2Academy dapat beroperasi secara optimal, memenuhi kebutuhan pengguna, serta memberikan pengalaman belajar dan layanan coaching yang efektif bagi komunitas pemain Counter-Strike 2 di Indonesia.







# BAB 3 — PEMBAHASAN

### 3.1 Gambaran Umum Aplikasi
CS2 Academy merupakan sebuah aplikasi berbasis web yang dirancang dan dikembangkan sebagai platform pembelajaran elektronik (e-learning) yang berfokus pada permainan Counter-Strike 2 (CS2). Aplikasi ini dibangun dengan tujuan utama menyediakan wadah pembelajaran yang terstruktur, interaktif, dan mudah diakses oleh para pemain CS2 di berbagai tingkatan kemampuan, mulai dari pemula hingga tingkat menengah.
Secara fungsional, CS2Academy menyediakan beberapa layanan utama, yaitu materi pembelajaran berbasis modul berbasis modul kursus yang dilengkapi dengan kuis interaktif, layanan coaching berbayar dalam berbagai format sesi (Textual Review, Panggil Pelatih, dan Demo Review), serta fitur pengumpulan tugas dan pemberian umpan balik (feedback) antara pengguna dan administrator. Setiap materi kursus dirancang secara berurutan dan berjenjang, sehingga pengguna diwajibkan menyelesaikan kuis pada satu modul sebelum dapat mengakses modul berikutnya.
Aplikasi ini dikembangkan menggunakan framework Laravel 11 yang berjalan di atas bahasa pemrograman PHP 8.4 dengan memanfaatkan arsitektur Model-View-Controller (MVC) sebagai pola perancangan sistemnya. Basis data yang digunakan adalah MySQL dipilih karena keandalan, stabilitas dalam mengelola data relasional, serta efisiensinya dalam menangani data pengguna berskala besar. Untuk pengelolaan autentikasi pengguna, digunakan paket Laravel Breeze yang mengimplementasikan sistem session-based authentication secara bawaan.
Proses pengembangan aplikasi CS2Academy mengacu pada metode Software Development Life Cycle (SDLC) model Waterfall. Model ini dipilih karena kebutuhan sistem telah terdefinisi dengan jelas sejak awal, sehingga pengembangan dapat dilakukan secara berurutan melalui tahapan analisis kebutuhan, perancangan sistem, implementasi kode program, dan pengujian aplikasi.
### 3.2 Analisis Sistem
Pada tahap ini dilakukan analisis kebutuhan terhadap website platform pembelajaran E-Sports Counter-Strike 2 (CS2Academy) yang akan dikembangkan. Analisis sistem bertujuan untuk mengidentifikasi kebutuhan pengguna serta menentukan fitur-fitur yang diperlukan agar proses pembelajaran dapat berjalan secara efektif, terstruktur, dan mudah diakses oleh pengguna. Berdasarkan hasil observasi dan perancangan yang telah dilakukan, terdapat beberapa kebutuhan utama yang harus dipenuhi oleh sistem.
Pengguna memerlukan media pembelajaran Counter-Strike 2 yang terstruktur dan mudah diakses secara daring.
Pengguna memerlukan sarana evaluasi berupa kuis untuk mengukur tingkat pemahaman terhadap materi yang telah dipelajari.
Pengguna memerlukan layanan coaching untuk membantu meningkatkan kemampuan bermain melalui bimbingan yang lebih terarah.
Pengguna memerlukan fitur pengiriman tugas (sesi coaching dan percakapan melalui menu Tugas Saya) sebagai sarana memperoleh umpan balik dari administrator atau pelatih.
Administrator memerlukan sistem yang mampu mengelola kursus, kuis, coaching, dan sesi coaching secara terpusat.
	Berdasarkan kebutuhan tersebut, solusi yang diusulkan adalah pembangunan website CS2Academy berbasis Laravel yang menyediakan fitur pembelajaran, evaluasi, coaching, serta pengelolaan tugas dalam satu platform yang terintegrasi.
3.2.1	Analisis Kebutuhan Fungsional
Analisis kebutuhan fungsional dilakukan untuk mengidentifikasi layanan dan fungsi yang harus disediakan oleh sistem agar dapat memenuhi kebutuhan pengguna. Pada website CS2Academy terdapat dua jenis pengguna, yaitu Admin dan User.

	Admin
Admin dapat melakukan login ke dalam sistem.
Admin dapat mengelola data kursus.
Admin dapat mengelola materi pembelajaran.
Admin dapat mengelola data kuis.
Admin dapat mengelola layanan coaching.
Admin dapat melihat dan mengelola data pengguna.
Admin dapat meninjau serta mengelola sesi coaching yang dikirim oleh pengguna.
	User
User dapat melakukan registrasi akun.
User dapat melakukan login dan logout.
User dapat mengakses materi kursus.
User dapat mengerjakan kuis.
User dapat melihat progres pembelajaran.
User dapat memesan layanan coaching.
User dapat melakukan simulasi pembayaran coaching.
User dapat mengirim pesan melalui sesi coaching kepada administrator.
3.2.2	Analisis Kebutuhan Non-Fungsional
Analisis kebutuhan non-fungsional dilakukan untuk menentukan kebutuhan pendukung yang diperlukan selama proses pengembangan dan implementasi sistem.
3.2.2.1 Perangkat Lunak (Software)
Sistem Operasi : Windows 11
Code Editor : Visual Studio Code
Framework : Laravel 11
Bahasa Pemrograman : PHP 8.4
Basis Data : MySQL
Local Server : XAMPP
Web Browser : Google Chrome
Diagram Tool : Draw.io
UI Design Tool : Figma
3.2.2.2 Perangkat Keras (Hardware)
Processor : Ryzen 5 5600 
Graphic Card : Radeon RX 6600
RAM : 32 GB
Storage : SSD 480 GB
Keyboard : Daxa 68SF
Mouse : ATK F1 Ultra Max

### 3.3 Perancangan Sistem
Perancangan sistem merupakan tahap yang dilakukan untuk menggambarkan alur kerja dan hubungan antarbagian dalam aplikasi web CS2Academy sebelum sistem diimplementasikan. Perancangan ini bertujuan agar proses pengembangan sistem dapat dilakukan secara lebih terstruktur, serta memudahkan dalam memahami interaksi antara pengguna dengan fitur-fitur yang tersedia pada aplikasi. Pada tahap ini digunakan beberapa diagram UML, yaitu Use Case Diagram, Activity Diagram, dan Class Diagram. Diagram tersebut digunakan untuk menggambarkan aktor yang terlibat, alur aktivitas sistem, serta hubungan antar kelas yang terdapat pada website CS2Academy.
Website CS2Academy memiliki dua aktor utama, yaitu Admin dan User. User merupakan pengguna yang dapat melakukan registrasi, login, mengakses materi kursus, mengerjakan kuis, memesan layanan coaching, melakukan simulasi pembayaran, serta mengirimkan pesan melalui sesi coaching. Admin memiliki hak akses untuk mengelola data kursus, kuis, layanan coaching, data pengguna, serta sesi coaching yang dikirimkan oleh User. Pembagian hak akses ini dibuat agar setiap pengguna hanya dapat mengakses fitur yang sesuai dengan perannya masing-masing.
3.3.1	Use Case Diagram
Use Case Diagram digunakan untuk menggambarkan hubungan antara aktor dengan fungsi-fungsi yang tersedia pada sistem. Pada Website CS2Academy terdapat dua aktor utama, yaitu Admin dan User. User dapat melakukan registrasi, login, melihat daftar kursus, mengakses materi, mengerjakan kuis, melihat progres pembelajaran, memesan layanan coaching, melakukan simulasi pembayaran, serta mengirimkan pesan melalui sesi coaching. Sementara itu, Admin dapat melakukan login, mengakses dashboard admin, mengelola data kursus, mengelola data kuis,mengelola layanan coaching, serta meninjau dan memperbarui pesan dalam sesi coaching yang dikirim oleh User.
Gambar 3.1 Use Case Diagram CS2Academy
Pada Gambar 3.1, digambarkan Use Case Diagram untuk sistem CS2Academy. Diagram ini menunjukkan interaksi antara aktor dengan fungsi-fungsi utama yang tersedia di dalam sistem. Terdapat dua aktor utama yang terlibat, yaitu Admin dan User. User berperan sebagai pengguna yang dapat melakukan registrasi, login, mengakses materi kursus, mengerjakan kuis, melihat progres pembelajaran, memesan layanan coaching, melakukan simulasi pembayaran, serta mengirimkan pesan melalui sesi coaching. Sementara itu, Admin berperan sebagai pengelola sistem yang memiliki hak akses untuk mengelola data kursus, data kuis, layanan coaching, data pengguna, serta sesi coaching yang dikirimkan oleh User. Pembagian peran tersebut disesuaikan dengan kebutuhan fungsional sistem CS2Academy yang terdiri dari fitur pembelajaran, evaluasi, layanan coaching, dan pengelolaan sesi coaching.
Dalam Use Case Diagram tersebut, User dapat menggunakan fitur pembelajaran dengan mengakses kursus yang tersedia, mempelajari materi, dan mengerjakan kuis sebagai bentuk evaluasi pemahaman. Setelah kuis dikerjakan, sistem dapat mencatat progres pembelajaran User apabila hasil kuis memenuhi ketentuan yang telah ditetapkan. Selain itu, User juga dapat memesan layanan coaching dengan memilih jenis layanan yang tersedia, kemudian melanjutkan proses ke halaman simulasi pembayaran. Fitur sesi coaching dan percakapan melalui menu Tugas Saya juga disediakan agar User dapat mengirimkan file atau tautan tugas untuk ditinjau oleh Admin.
Admin memiliki peran penting dalam proses pengelolaan data pada sistem CS2Academy. Melalui dashboard admin, pengelolaan kursus, kuis, layanan coaching, data pengguna, serta sesi coaching dapat dilakukan secara terpusat. Pada fitur pengelolaan sesi coaching, Admin dapat meninjau tugas yang dikirimkan oleh User, memperbarui status, memberikan umpan balik, atau menghapus data tugas apabila diperlukan. Dengan demikian, Use Case Diagram ini memberikan gambaran mengenai batasan hak akses, fungsi utama sistem, serta hubungan antara Admin dan User dalam penggunaan website CS2Academy.
3.3.2	Activity Diagram
Activity Diagram digunakan untuk menggambarkan alur aktivitas yang terjadi di dalam sistem CS2Academy. Diagram ini dibuat untuk memperjelas proses yang dilakukan oleh aktor dan sistem pada setiap fitur utama. Pada sistem CS2Academy, Activity Diagram dibagi ke dalam beberapa proses, yaitu proses login, pengerjaan kuis, pemesanan layanan coaching dan simulasi pembayaran, percakapan dalam sesi coaching, serta pengelolaan sesi coaching dan kuis oleh Admin.
Setiap Activity Diagram disusun menggunakan konsep swimlane agar pembagian aktivitas antara aktor dan sistem dapat terlihat dengan jelas. Dengan adanya diagram ini, alur kerja sistem dapat dipahami secara lebih terstruktur sebelum dilakukan proses implementasi ke dalam aplikasi web berbasis Laravel.
3.3.2.1	Activity Diagram Login
/ 
Gambar 3.2 Activity Diagram Login
Pada Gambar 3.2, digambarkan Activity Diagram Login pada sistem CS2Academy. Diagram ini menunjukkan alur proses masuk ke dalam sistem yang dilakukan oleh pengguna. Proses dimulai ketika pengguna membuka halaman login, kemudian memasukkan email dan kata sandi yang telah terdaftar. Setelah data dimasukkan, sistem akan melakukan validasi terhadap email dan kata sandi tersebut.
Apabila data yang dimasukkan sesuai, sistem akan mengarahkan pengguna ke halaman utama atau dashboard sesuai dengan hak akses yang dimiliki. Namun, apabila data tidak sesuai, sistem akan menampilkan pesan kesalahan dan pengguna diminta untuk memasukkan kembali data login yang benar. Proses ini digunakan untuk memastikan bahwa hanya pengguna yang memiliki akun terdaftar yang dapat mengakses fitur tertentu pada sistem CS2Academy.

3.3.2.2	Activity Diagram Mengerjakan Kuis
/ 
Gambar 3.3 Activity Diagram Mengerjakan Kuis
Pada Gambar 3.3, digambarkan Activity Diagram Mengerjakan Kuis pada sistem CS2Academy. Diagram ini menunjukkan alur aktivitas User dalam mengikuti proses pembelajaran dan evaluasi. Proses dimulai ketika User berhasil masuk ke dalam sistem, kemudian memilih menu kursus yang tersedia. Setelah daftar kursus ditampilkan oleh sistem, User dapat memilih salah satu kursus dan mempelajari materi yang disediakan.
Setelah materi dipelajari, User dapat mengerjakan kuis sebagai bentuk evaluasi pemahaman terhadap materi. Sistem kemudian akan memeriksa hasil kuis yang telah dikerjakan. Apabila nilai yang diperoleh memenuhi syarat, sistem akan mencatat progres pembelajaran dan menampilkan status bahwa kursus telah diselesaikan. Namun, apabila nilai belum memenuhi syarat, sistem akan menampilkan informasi bahwa kuis belum lulus dan User dapat mengulang pengerjaan kuis.
3.3.2.3 Activity Diagram Pemesanan Coaching dan Pembayaran
/Gambar 3.4 Activity Diagram Pemesanan Coaching dan Pembayaran
Pada Gambar 3.4, digambarkan Activity Diagram Pemesanan Coaching dan Pembayaran pada sistem CS2Academy. Diagram ini menunjukkan alur aktivitas User dalam melakukan pemesanan layanan coaching. Proses dimulai ketika User membuka menu coaching, kemudian sistem menampilkan daftar layanan coaching yang tersedia. Setelah itu, User memilih salah satu layanan yang ingin digunakan.
Setelah layanan dipilih, sistem akan memeriksa status login User. Apabila User belum login, sistem akan mengarahkan User ke halaman login terlebih dahulu. Apabila User telah login, sistem akan menampilkan halaman pembayaran. 
Pada halaman tersebut, User dapat memilih metode pembayaran dan melakukan konfirmasi pembayaran. Setelah konfirmasi dilakukan, sistem akan memproses simulasi pembayaran dan menampilkan halaman keberhasilan pembayaran. Proses pembayaran pada CS2Academy masih berupa simulasi dan belum terintegrasi dengan pembayaran gateway nyata.
3.3.2.4	Activity Diagram Percakapan dalam sesi coaching
/
Gambar 3.5 Activity Diagram Percakapan dalam sesi coaching
Pada Gambar 3.5, digambarkan Activity Diagram Percakapan dalam sesi coaching pada sistem CS2Academy. Diagram ini menunjukkan alur aktivitas User dalam mengirimkan pesan kepada Admin melalui sesi coaching yang aktif. Proses dimulai ketika User telah berhasil login ke dalam sistem, kemudian membuka menu Tugas Saya. Setelah halaman Tugas Saya ditampilkan, User dapat mengisi data tugas yang diperlukan, mengunggah file, atau memasukkan tautan sesuai dengan ketentuan tugas.
Setelah data sesi coaching dikirimkan, sistem akan melakukan validasi terhadap data yang telah dimasukkan. Apabila data yang dikirimkan valid, sistem akan menyimpan data sesi coaching dan menampilkan status bahwa tugas berhasil dikirim. Namun, apabila data tidak valid, sistem akan menampilkan pesan kesalahan sehingga User dapat memperbaiki data yang dimasukkan. Alur ini digunakan untuk memastikan bahwa setiap sesi coaching yang dikirimkan memiliki data yang lengkap dan sesuai dengan kebutuhan sistem.
3.3.2.5	Activity Diagram Admin mengelola sesi coaching dan Kuis
Gambar 3.5 Activity Diagram Admin mengelola sesi coaching dan Kuis
Pada Gambar 3.6, digambarkan Activity Diagram Admin mengelola sesi coaching dan Kuis pada sistem CS2Academy. Diagram ini menunjukkan alur aktivitas Admin dalam melakukan pengelolaan data setelah berhasil masuk ke dalam sistem. Proses dimulai ketika Admin melakukan login, kemudian sistem melakukan validasi terhadap akun dan hak akses Admin. Apabila hak akses valid, sistem akan menampilkan halaman dashboard Admin. Namun, apabila hak akses tidak valid, sistem akan menolak akses ke halaman Admin.
Pada dashboard, Admin dapat memilih menu pengelolaan sesi coaching atau menu pengelolaan kuis. Pada menu sesi coaching, Admin dapat melihat daftar tugas yang dikirimkan oleh User, memberikan umpan balik, memperbarui status, atau menghapus data sesi coaching. Pada menu kuis, Admin dapat menambahkan, mengubah, atau menghapus data kuis yang berkaitan dengan kursus. Dengan adanya alur ini, proses pengelolaan evaluasi pembelajaran dan tugas pada CS2Academy dapat dilakukan secara lebih terpusat dan terstruktur.
3.3.3	Class Diagram
Class Diagram digunakan untuk menggambarkan struktur kelas yang terdapat pada sistem CS2Academy. Diagram ini menunjukkan kelas-kelas utama, atribut, operasi, serta hubungan antar kelas yang digunakan dalam sistem. Pada sistem CS2Academy, kelas utama yang digunakan meliputi User, Kursus, Quiz, SesiCoaching, Coaching, dan Pembayaran. Setiap kelas memiliki peran masing-masing dalam mendukung proses pembelajaran, evaluasi, pemesanan layanan coaching, simulasi pembayaran, serta pengelolaan tugas pada sistem
Gambar 3.7 Class Diagram
Pada Gambar 3.7, ditampilkan Class Diagram sistem CS2Academy yang menggambarkan hubungan antar kelas utama di dalam sistem. Kelas User merepresentasikan pengguna sistem yang dapat memiliki peran sebagai Admin maupun User biasa. Kelas Kursus digunakan untuk merepresentasikan data kursus pembelajaran Counter-Strike 2 yang tersedia pada sistem. Sementara itu, kelas Quiz memiliki relasi 1 : M dengan kelas Kursus, karena satu kursus dapat memiliki lebih dari satu kuis sebagai media evaluasi pembelajaran.
Relasi antara kelas User dan kelas Kursus direpresentasikan melalui kelas KursusProgress. Kelas KursusProgress digunakan untuk mencatat progres pembelajaran setiap User terhadap kursus yang diikuti. Melalui kelas tersebut, sistem dapat menyimpan status penyelesaian kursus serta mencatat kursus yang telah diselesaikan oleh pengguna. Relasi ini menunjukkan bahwa satu User dapat memiliki banyak data progres kursus, sedangkan satu Kursus juga dapat memiliki banyak data progres dari beberapa User.
﻿### 3.4 Perancangan Basis Data

Pada tahap ini, dilakukan perancangan basis data yang digunakan untuk menyimpan dan mengelola data pada website CS2Academy. Basis data dirancang menggunakan MySQL sebagai sistem manajemen basis data relasional. Perancangan basis data ini bertujuan agar data pengguna, kursus, modul, kuis, sesi coaching, pesan chat, transaksi, serta progres pembelajaran dapat tersimpan secara terstruktur dan saling terhubung sesuai dengan kebutuhan sistem.

Basis data pada sistem CS2Academy terdiri dari sembilan tabel utama, yaitu tabel users, courses, modules, quizzes, assignments, coaching_messages, coaching_transactions, module_progress, dan course_progress.

#### 3.4.1 Users

**Tabel 3.1 Tabel Users**

| No | Nama Field | Tipe Data | Keterangan |
|----|-----------|-----------|------------|
| 1 | id | bigint | Auto increment, primary key |
| 2 | name | varchar(255) | Not null |
| 3 | email | varchar(255) | Not null, unique |
| 4 | email_verified_at | timestamp | Nullable |
| 5 | password | varchar(255) | Not null |
| 6 | role | enum('admin','user') | Not null, default 'user' |
| 7 | has_paid | boolean | Not null, default false |
| 8 | active_coaching_package | varchar(255) | Nullable |
| 9 | discord_id | varchar(100) | Nullable |
| 10 | avatar | varchar(255) | Nullable |
| 11 | remember_token | varchar(100) | Nullable |
| 12 | created_at | timestamp | Not null |
| 13 | updated_at | timestamp | Not null |

Pada Tabel 3.1, tabel users memiliki tiga belas field untuk menyimpan data pengguna. Field role membedakan hak akses Admin atau User. Field has_paid menyimpan status pembayaran. Field active_coaching_package menyimpan nama paket coaching yang sedang aktif. Field discord_id menyimpan identitas Discord untuk sesi Panggil Pelatih. Field avatar menyimpan path foto profil.

#### 3.4.2 Courses

**Tabel 3.2 Tabel Courses**

| No | Nama Field | Tipe Data | Keterangan |
|----|-----------|-----------|------------|
| 1 | id | bigint | Auto increment, primary key |
| 2 | icon | varchar(255) | Not null |
| 3 | title | varchar(255) | Not null |
| 4 | body | text | Not null |
| 5 | level | varchar(50) | Nullable |
| 6 | durasi | varchar(50) | Nullable |
| 7 | type | varchar(100) | Nullable |
| 8 | is_popular | boolean | Default false |
| 9 | urutan | int | Not null, default 0 |
| 10 | created_at | timestamp | Not null |
| 11 | updated_at | timestamp | Not null |

Pada Tabel 3.2, tabel courses menyimpan data kursus. Field icon menyimpan emoji card katalog. Field level menyimpan tingkat kesulitan (Pemula/Menengah/Lanjutan). Field durasi menyimpan estimasi waktu. Field type mengelompokkan kursus sebagai Kursus Wajib atau Kursus Lanjutan. Field is_popular menandai kursus populer. Field urutan menentukan posisi kursus di katalog.

#### 3.4.3 Modules

**Tabel 3.3 Tabel Modules**

| No | Nama Field | Tipe Data | Keterangan |
|----|-----------|-----------|------------|
| 1 | id | bigint | Auto increment, primary key |
| 2 | course_id | bigint | Not null, foreign key ke courses |
| 3 | title | varchar(255) | Not null |
| 4 | body | text | Nullable |
| 5 | youtube_url | varchar(255) | Nullable |
| 6 | urutan | int | Not null, default 0 |
| 7 | created_at | timestamp | Not null |
| 8 | updated_at | timestamp | Not null |

Pada Tabel 3.3, tabel modules menyimpan data modul dalam setiap kursus. Field course_id menghubungkan modul dengan kursus (relasi one-to-many). Field body menyimpan outline materi (newline-separated). Field youtube_url menyimpan link video YouTube. Field urutan menentukan urutan modul.

#### 3.4.4 Quizzes

**Tabel 3.4 Tabel Quizzes**

| No | Nama Field | Tipe Data | Keterangan |
|----|-----------|-----------|------------|
| 1 | id | bigint | Auto increment, primary key |
| 2 | course_id | bigint | Not null, foreign key ke courses |
| 3 | module_id | bigint | Nullable, foreign key ke modules |
| 4 | pertanyaan | text | Not null |
| 5 | opsi | json | Not null, array 4 pilihan |
| 6 | jawaban_benar | int | Not null, indeks 0-3 |
| 7 | penjelasan | text | Nullable |
| 8 | youtube_url | varchar(255) | Nullable (legacy) |
| 9 | created_at | timestamp | Not null |
| 10 | updated_at | timestamp | Not null |

Pada Tabel 3.4, tabel quizzes menyimpan data kuis per modul. Field module_id menghubungkan kuis dengan modul. Field opsi menyimpan 4 pilihan jawaban dalam JSON. Field jawaban_benar menyimpan indeks jawaban benar (0-3). Field penjelasan menyimpan teks yang ditampilkan setelah user menjawab.

#### 3.4.5 Assignments (Sesi Coaching)

**Tabel 3.5 Tabel Assignments**

| No | Nama Field | Tipe Data | Keterangan |
|----|-----------|-----------|------------|
| 1 | id | bigint | Auto increment, primary key |
| 2 | user_id | bigint | Not null, foreign key ke users |
| 3 | from_admin | boolean | Not null |
| 4 | judul | varchar(255) | Not null |
| 5 | tugas_teks | text | Not null |
| 6 | status | enum('menunggu','diproses','selesai') | Not null |
| 7 | completed_at | timestamp | Nullable |
| 8 | balasan_admin | text | Nullable (legacy) |
| 9 | created_at | timestamp | Not null |
| 10 | updated_at | timestamp | Not null |

Pada Tabel 3.5, tabel assignments menyimpan data sesi coaching. Field from_admin menandai sesi dibuat oleh Admin. Field status: menunggu, diproses, selesai. Field completed_at mencatat waktu penyelesaian. Field balasan_admin adalah legacy (digantikan coaching_messages).

#### 3.4.6 Coaching Messages

**Tabel 3.6 Tabel Coaching Messages**

| No | Nama Field | Tipe Data | Keterangan |
|----|-----------|-----------|------------|
| 1 | id | bigint | Auto increment, primary key |
| 2 | assignment_id | bigint | Not null, foreign key ke assignments |
| 3 | sender_id | bigint | Not null, foreign key ke users |
| 4 | message | text | Not null |
| 5 | read_at | timestamp | Nullable (null = unread) |
| 6 | created_at | timestamp | Not null |
| 7 | updated_at | timestamp | Not null |

Pada Tabel 3.6, tabel coaching_messages menyimpan pesan percakapan sesi coaching. Field read_at menandai status baca (null = unread). Satu sesi memiliki banyak pesan (one-to-many).

#### 3.4.7 Coaching Transactions

**Tabel 3.7 Tabel Coaching Transactions**

| No | Nama Field | Tipe Data | Keterangan |
|----|-----------|-----------|------------|
| 1 | id | bigint | Auto increment, primary key |
| 2 | user_id | bigint | Not null, foreign key ke users |
| 3 | package_name | varchar(255) | Not null |
| 4 | package_price | varchar(50) | Not null |
| 5 | va_code | varchar(255) | Nullable |
| 6 | status | enum('pending','approved','rejected') | Not null |
| 7 | created_at | timestamp | Not null |
| 8 | updated_at | timestamp | Not null |

Pada Tabel 3.7, tabel coaching_transactions menyimpan transaksi pembayaran. Field package_name: Textual Review, Panggil Pelatih, Demo Review. Field va_code: kode VA BCA dummy (format 8808 + user ID + transaction ID). Field status: pending, approved, rejected. Saat approved, sistem otomatis membuat sesi coaching + pesan pembuka.

#### 3.4.8 Module Progress

**Tabel 3.8 Tabel Module Progress**

| No | Nama Field | Tipe Data | Keterangan |
|----|-----------|-----------|------------|
| 1 | id | bigint | Auto increment, primary key |
| 2 | user_id | bigint | Not null, foreign key ke users |
| 3 | module_id | bigint | Not null, foreign key ke modules |
| 4 | score | int | Not null, default 0 |
| 5 | completed_at | timestamp | Nullable |
| 6 | created_at | timestamp | Not null |
| 7 | updated_at | timestamp | Not null |

Pada Tabel 3.8, tabel module_progress mencatat progres per modul. Unique constraint pada (user_id, module_id). Progres kursus = persentase modul selesai. Modul berikutnya unlock setelah modul sebelumnya completed.

#### 3.4.9 Course Progress

**Tabel 3.9 Tabel Course Progress**

| No | Nama Field | Tipe Data | Keterangan |
|----|-----------|-----------|------------|
| 1 | id | bigint | Auto increment, primary key |
| 2 | user_id | bigint | Not null, foreign key ke users |
| 3 | course_id | bigint | Not null, foreign key ke courses |
| 4 | score | int | Not null, default 0 |
| 5 | completed_at | timestamp | Nullable |
| 6 | created_at | timestamp | Not null |
| 7 | updated_at | timestamp | Not null |

Pada Tabel 3.9, tabel course_progress adalah legacy dari versi awal. Sekarang progres dicatat via module_progress (Tabel 3.8).

### 3.5 Struktur Navigasi
Struktur navigasi digunakan untuk menggambarkan alur perpindahan halaman pada website CS2Academy. Perancangan struktur navigasi bertujuan agar setiap halaman dan fitur pada sistem dapat diakses secara terarah sesuai dengan hak akses pengguna. Pada sistem CS2Academy, struktur navigasi dibagi menjadi dua, yaitu struktur navigasi untuk User dan struktur navigasi untuk Admin.
Struktur navigasi User digunakan untuk menggambarkan alur akses pengguna dalam menggunakan fitur pembelajaran, kuis, layanan coaching, simulasi pembayaran, serta percakapan dalam sesi coaching. Sementara itu, struktur navigasi Admin digunakan untuk menggambarkan alur akses administrator dalam mengelola data kursus, kuis, pengguna, dan sesi coaching. Pembagian struktur navigasi ini dilakukan karena sistem CS2Academy memiliki dua jenis pengguna dengan hak akses yang berbeda, yaitu Admin dan User.
3.5.1	Struktur Navigasi User
/
Gambar 3.8 Struktur Navigasi User

Pada Gambar 3.8, digambarkan struktur navigasi User pada sistem CS2Academy. Struktur navigasi ini menunjukkan alur akses halaman yang dapat digunakan oleh User setelah masuk ke dalam website. User dapat mengakses halaman utama, melakukan registrasi atau login, melihat daftar kursus, mempelajari materi, mengerjakan kuis, melihat progres pembelajaran, memesan layanan coaching, melakukan simulasi pembayaran, mengirimkan pesan melalui sesi coaching, serta mengelola profil pengguna.
Struktur navigasi User pada CS2Academy menggunakan bentuk navigasi campuran karena terdapat alur yang bersifat berurutan dan alur yang bersifat bebas. Alur berurutan terlihat pada proses pembelajaran, yaitu User mengakses kursus, mempelajari materi, mengerjakan kuis, kemudian progres pembelajaran dicatat oleh sistem. Sementara itu, alur bebas terlihat ketika User dapat berpindah ke halaman coaching, Tugas Saya, profil, atau halaman utama sesuai kebutuhan.
3.5.2	Struktur Navigasi Admin
/
Gambar 3.9 Struktur Navigasi Admin

Pada Gambar 3.9, digambarkan struktur navigasi Admin pada sistem CS2Academy. Struktur navigasi ini menunjukkan alur akses halaman yang digunakan oleh Admin untuk mengelola data pada sistem. Admin harus melakukan login terlebih dahulu sebelum dapat mengakses halaman dashboard admin. Setelah berhasil masuk, Admin dapat mengakses beberapa menu pengelolaan, seperti pengelolaan kursus, kuis, sesi coaching, data pengguna, dan mode pratinjau sistem.
Struktur navigasi Admin dirancang agar proses pengelolaan data dapat dilakukan secara terpusat melalui halaman dashboard. Melalui struktur ini, Admin dapat berpindah dari dashboard ke menu pengelolaan lain sesuai kebutuhan. Dengan demikian, pengelolaan kursus, kuis, dan sesi coaching pada sistem CS2Academy dapat dilakukan secara lebih terstruktur dan efisien.
### 3.6 Perancangan Antarmuka
Perancangan antarmuka dilakukan untuk memberikan gambaran mengenai tampilan halaman yang terdapat pada website CS2Academy. Perancangan ini bertujuan agar tampilan sistem dapat disusun secara terstruktur, mudah dipahami, dan sesuai dengan kebutuhan pengguna. Antarmuka yang dirancang pada sistem ini mencakup halaman utama, halaman autentikasi, halaman kursus, halaman kuis, halaman coaching, halaman simulasi pembayaran, halaman Tugas Saya, serta halaman dashboard Admin.
Perancangan antarmuka pada CS2Academy dibuat dengan memperhatikan kemudahan akses pengguna terhadap fitur-fitur utama. User diarahkan untuk dapat mengakses materi pembelajaran, mengerjakan kuis, memesan layanan coaching, melakukan simulasi pembayaran, dan mengirimkan pesan melalui sesi coaching. Sementara itu, Admin diarahkan untuk dapat mengelola data kursus, kuis, pengguna, serta sesi coaching melalui halaman dashboard Admin.
3.6.1	Rancangan Halaman Utama
Gambar 3.10 Rancangan Halaman Utama
/
Pada Gambar 3.10, ditampilkan rancangan halaman utama website CS2Academy. Halaman ini merupakan tampilan awal yang akan dilihat oleh pengguna ketika mengakses website. Pada halaman utama, ditampilkan informasi umum mengenai CS2Academy sebagai platform pembelajaran E-Sports Counter-Strike 2. Selain itu, halaman ini juga menyediakan menu navigasi yang dapat digunakan untuk mengakses fitur utama, seperti kursus, layanan coaching, login, dan registrasi.

3.6.2	Rancangan Halaman Login dan Registrasi
Gambar 3.11 Rancangan Halaman Login dan Registrasi
/
Pada Gambar 3.11, ditampilkan rancangan halaman login dan registrasi pada sistem CS2Academy. Halaman login digunakan oleh pengguna yang telah memiliki akun untuk masuk ke dalam sistem dengan memasukkan email dan kata sandi. Sementara itu, halaman registrasi digunakan oleh pengguna baru untuk membuat akun sebelum dapat mengakses fitur pembelajaran yang tersedia pada sistem. Halaman ini dirancang agar proses autentikasi pengguna dapat dilakukan secara sederhana dan mudah dipahami

3.6.3	Rancangan Materi dan Kuis
Gambar 3.12 Rancangan Halaman Materi dan Kuis
/
Pada Gambar 3.12, ditampilkan rancangan halaman materi dan kuis pada sistem CS2Academy. Halaman ini digunakan oleh User untuk mempelajari materi pembelajaran Counter-Strike 2 sekaligus mengerjakan kuis evaluasi yang tersedia pada setiap materi. Materi pembelajaran ditampilkan untuk membantu User memahami topik yang dipelajari, sedangkan kuis digunakan sebagai alat evaluasi pemahaman terhadap materi tersebut.
Pada halaman ini, User dapat membaca materi, melihat video pembelajaran apabila tersedia, memilih jawaban kuis, dan mengirimkan jawaban untuk diproses oleh sistem. Hasil kuis akan digunakan untuk menentukan progres pembelajaran User. Apabila nilai kuis memenuhi ketentuan, maka progres pembelajaran akan dicatat oleh sistem sebagai tanda bahwa materi telah diselesaikan.
3.6.4	Rancangan Coaching
Gambar 3.13 Rancangan Coaching

/
Pada Gambar 3.13, ditampilkan rancangan halaman coaching pada sistem CS2Academy. Halaman ini digunakan untuk menampilkan daftar layanan coaching yang dapat dipilih oleh User. Layanan coaching yang tersedia meliputi Textual Review, Panggil Pelatih, dan Demo Review. Setiap layanan ditampilkan dengan informasi singkat agar User dapat memilih jenis layanan yang sesuai dengan kebutuhan pembelajaran.
Setelah User memilih salah satu layanan coaching, sistem akan mengarahkan User ke proses simulasi pembayaran. Rancangan halaman ini dibuat agar User dapat memahami pilihan layanan yang tersedia sebelum melanjutkan ke tahap berikutnya.
3.6.5	Rancangan Pembayaran
Gambar 3.14 Rancangan Pembayaran
/
Pada Gambar 3.14, ditampilkan rancangan halaman pembayaran yang digunakan untuk melakukan simulasi pembayaran layanan coaching. Pada halaman ini, User dapat memilih metode pembayaran BCA Virtual Account. Setelah metode pembayaran dipilih, User dapat melakukan konfirmasi pembayaran untuk menyelesaikan proses pemesanan layanan.
Proses pembayaran pada sistem CS2Academy masih bersifat simulasi dan belum terhubung dengan layanan pembayaran gateway nyata. Rancangan halaman ini dibuat untuk merepresentasikan alur pembayaran secara sederhana agar proses pemesanan layanan coaching dapat digambarkan seperti transaksi pada sistem nyata..
3.6.6	Rancangan halaman Tugas Saya
Gambar 3.15 Rancangan halaman Tugas Saya
/

Pada Gambar 3.15, ditampilkan rancangan halaman Tugas Saya pada sistem CS2Academy. Halaman ini digunakan oleh User untuk mengirimkan pesan kepada Admin melalui sesi coaching yang aktif. Pada halaman ini, User dapat mengisi judul tugas, memasukkan isi tugas atau tautan, kemudian mengirimkan data tersebut agar dapat ditinjau oleh Admin.
halaman Tugas Saya dirancang sebagai sarana interaksi antara User dan Admin dalam proses pembelajaran. Melalui fitur ini, User dapat mengirimkan tugas atau hasil latihan, sedangkan Admin dapat meninjau dan memberikan umpan balik terhadap tugas yang telah dikirimkan.
3.6.7	Rancangan Halaman Dashboard Admin
Gambar 3.16 Rancangan Halaman Dashboard Admin
/
Pada Gambar 3.16, ditampilkan rancangan halaman dashboard Admin pada sistem CS2Academy. Halaman ini digunakan oleh Admin untuk mengelola data yang terdapat pada sistem. Melalui dashboard Admin, pengelolaan data kursus, kuis, pengguna, dan sesi coaching dapat dilakukan secara terpusat.
Rancangan halaman dashboard Admin dibuat agar proses pengelolaan sistem dapat dilakukan dengan lebih efektif. Admin dapat memilih menu pengelolaan sesuai kebutuhan, seperti melihat data pengguna, mengelola kuis, meninjau sesi coaching, serta mengatur data pembelajaran yang tersedia pada website CS2Academy.
### 3.7 	Implementasi Sistem
Implementasi sistem merupakan tahap penerapan hasil perancangan ke dalam bentuk aplikasi berbasis website. Pada tahap ini, rancangan sistem yang telah dibuat sebelumnya diimplementasikan menggunakan framework Laravel, bahasa pemrograman PHP, basis data MySQL, serta Blade sebagai template engine. Implementasi dilakukan agar fitur-fitur utama pada CS2Academy dapat digunakan oleh pengguna sesuai dengan kebutuhan sistem.
Website CS2Academy memiliki beberapa halaman utama yang telah diimplementasikan, yaitu halaman utama, halaman login dan registrasi, halaman materi dan kuis, halaman coaching, halaman pembayaran, halaman Tugas Saya, serta halaman dashboard Admin. Setiap halaman memiliki fungsi masing-masing dalam mendukung proses pembelajaran, evaluasi, layanan coaching, simulasi pembayaran, pengiriman tugas, dan pengelolaan data oleh Admin.
3.7.1	Implementasi Halaman Utama
Gambar 3.17 Rancangan Halaman Utama
/
Pada Gambar 3.17, ditampilkan implementasi halaman utama website CS2Academy. Halaman ini menjadi tampilan awal ketika pengguna mengakses website. Pada halaman utama, ditampilkan informasi mengenai platform CS2Academy, menu navigasi, serta akses menuju fitur utama seperti kursus, layanan coaching, login, dan registrasi.
Halaman utama dirancang agar pengguna dapat memahami tujuan website secara langsung. Melalui halaman ini, pengguna dapat mengetahui bahwa CS2Academy merupakan platform pembelajaran E-Sports Counter-Strike 2 yang menyediakan materi pembelajaran, kuis evaluasi, layanan coaching, dan fitur pengiriman tugas.
3.7.2	Implementasi Halaman Login dan Registrasi
Gambar 3.18 Implementasi Halaman Login dan Registrasi
/
Pada Gambar 3.18, ditampilkan implementasi halaman login dan registrasi pada website CS2Academy. Halaman login digunakan oleh pengguna yang telah memiliki akun untuk masuk ke dalam sistem dengan memasukkan email dan kata sandi. Sementara itu, halaman registrasi digunakan oleh pengguna baru untuk membuat akun sebelum dapat mengakses fitur pembelajaran yang tersedia.
Implementasi halaman autentikasi ini menggunakan Laravel Breeze sebagai sistem autentikasi dasar. Dengan adanya halaman login dan registrasi, sistem dapat membedakan pengguna yang telah terdaftar dan pengguna yang belum memiliki akun. Selain itu, sistem juga dapat membedakan hak akses berdasarkan peran pengguna, yaitu Admin dan User.
3.7.3	Implementasi Halaman Materi dan Kuis
Gambar 3.19 Implementasi Halaman Materi dan Kuis
/
Pada Gambar 3.19, ditampilkan implementasi halaman materi dan kuis pada website CS2Academy. Halaman ini digunakan oleh User untuk mempelajari materi pembelajaran Counter-Strike 2 dan mengerjakan kuis evaluasi yang tersedia. Materi pembelajaran ditampilkan agar User dapat memahami topik yang dipelajari sebelum menjawab pertanyaan kuis.
Pada halaman ini, User dapat membaca materi, melihat video pembelajaran apabila tersedia, memilih jawaban kuis, dan mengirimkan jawaban untuk diproses oleh sistem. Hasil kuis digunakan untuk menentukan progres pembelajaran User. Apabila hasil kuis memenuhi ketentuan, maka sistem akan mencatat progres pembelajaran sebagai tanda bahwa materi telah diselesaikan.
3.7.4		Implementasi Halaman Coaching
Gambar 3.20 Implementasi Halaman Coaching
/
Pada Gambar 3.20, ditampilkan implementasi halaman coaching pada website CS2Academy. Halaman ini berisi daftar layanan coaching yang dapat dipilih oleh User. Layanan yang tersedia meliputi Textual Review, Panggil Pelatih, dan Demo Review. Setiap layanan ditampilkan dengan informasi singkat agar User dapat memilih layanan yang sesuai dengan kebutuhan.
Implementasi halaman coaching bertujuan untuk memberikan pilihan layanan pembelajaran tambahan bagi pengguna. Setelah memilih salah satu layanan, User dapat melanjutkan proses ke halaman pembayaran untuk melakukan simulasi pembayaran layanan.
3.7.5	Implementasi Halaman Pembayaran
Gambar 3.21 Implementasi Halaman Pembayaran
/
Pada Gambar 3.21, ditampilkan implementasi halaman pembayaran pada website CS2Academy. Halaman ini digunakan untuk melakukan simulasi pembayaran layanan coaching. Pada halaman ini, User dapat memilih metode pembayaran BCA Virtual Account.
Setelah metode pembayaran dipilih, User dapat melakukan konfirmasi pembayaran. Proses pembayaran pada website CS2Academy masih bersifat simulasi dan belum terhubung dengan layanan pembayaran gateway nyata. Implementasi halaman ini dibuat untuk menggambarkan alur transaksi layanan coaching secara sederhana.
3.7.6 	Implementasi halaman Tugas Saya
Gambar 3.22 Implementasi Halaman Pembayaran
/
Pada Gambar 3.22, ditampilkan implementasi halaman Tugas Saya pada website CS2Academy. Halaman ini digunakan oleh User untuk mengirimkan pesan kepada Admin melalui sesi coaching yang aktif. User dapat mengisi judul tugas, memasukkan isi tugas atau tautan, kemudian mengirimkan data tersebut agar dapat ditinjau oleh Admin.
fitur sesi coaching digunakan sebagai sarana interaksi antara User dan Admin dalam proses pembelajaran. Melalui fitur ini, User dapat mengirimkan hasil latihan atau tugas, sedangkan Admin dapat meninjau tugas yang dikirimkan dan memberikan balasan atau umpan balik melalui sistem.
3.7.7	Implementasi Halaman Dashboard Admin
Gambar 3.23 Implementasi Halaman Dashboard Admin
/
Pada Gambar 3.23, ditampilkan implementasi halaman dashboard Admin pada website CS2Academy. Halaman ini digunakan oleh Admin untuk mengelola data yang terdapat pada sistem. Melalui dashboard Admin, pengelolaan data kursus, kuis, pengguna, dan sesi coaching dapat dilakukan secara terpusat.
Dashboard Admin hanya dapat diakses oleh pengguna yang memiliki hak akses sebagai Admin. Dengan adanya halaman dashboard, proses pengelolaan sistem dapat dilakukan dengan lebih mudah dan terstruktur. Admin dapat mengelola data pembelajaran, meninjau tugas yang dikirimkan oleh User, serta mengatur fitur yang tersedia pada website CS2Academy.
### 3.8 	Pengujian Sistem
Pengujian sistem dilakukan untuk memastikan bahwa setiap fungsi pada website CS2Academy dapat berjalan sesuai dengan kebutuhan fungsional yang telah ditentukan. Metode pengujian yang digunakan adalah Black Box Testing, yaitu metode pengujian yang berfokus pada fungsi sistem tanpa memperhatikan struktur kode program. Pengujian dilakukan terhadap fitur utama, seperti registrasi, login, akses materi dan kuis, layanan coaching, simulasi pembayaran, percakapan dalam sesi coaching, serta pengelolaan data oleh Admin.
Tabel 3.10 Black Box Testing
Input
Keterangan
Hasil 

Pengujian Akses Halaman Utama
Mengakses halaman utama dan memastikan elemen navigasi,  informasi utama, serta tombol akses fitur tampil dengan benar.
Sukses

Pengujian Registrasi Akun
Mengisi data registrasi berupa nama, email, dan password untuk memastikan akun pengguna berhasil dibuat.
Sukses

Pengujian Login
Memasukkan email dan password yang telah terdaftar untuk memastikan pengguna dapat masuk ke dalam sistem sesuai hak akses.
Sukses

Pengujian Materi dan Kuis
Mengakses halaman materi dan kuis untuk memastikan materi, video pembelajaran, pilihan jawaban, dan tombol pengiriman jawaban tampil dengan benar.
Sukses

Pengujian Progress Pembelajaran
Menyelesaikan kuis dengan nilai yang memenuhi ketentuan untuk memastikan sistem mencatat progres pembelajaran pengguna.
Sukses

Pengujian Layanan Coaching
Mengakses halaman coaching dan memilih salah satu layanan untuk memastikan sistem menampilkan detail layanan dan mengarahkan pengguna ke halaman pembayaran.
Sukses

Pengujian Pembayaran
Memilih metode pembayaran dan melakukan konfirmasi untuk memastikan sistem menampilkan status pembayaran berhasil sebagai simulasi transaksi.
Sukses

Pengujian Sesi Coaching
Mengisi judul dan isi tugas, kemudian mengirimkan pesan melalui sesi coaching untuk memastikan data tugas tersimpan pada sistem.
Sukses

Pengujian Dashboard Admin
Login sebagai Admin untuk memastikan halaman dashboard Admin dapat diaksesdan menampilkan menu pengelolaan sistem.
Sukses

Pengujian kelola sesi coaching Admin
Admin membuka data sesi coaching dan memberikan balasan atau mengubah status untuk memastikan perubahan data tersimpan.
Sukses

Pengujian Logout
Menekan tombol logout untuk memastikan sesi pengguna berakhir dan pengguna diarahkan keluar dari sistem.
Sukses


Berdasarkan hasil pengujian pada Tabel 3.10, seluruh fitur utama pada website CS2Academy dapat berjalan sesuai dengan hasil yang diharapkan. Dengan demikian, sistem telah memenuhi kebutuhan fungsional yang telah dirancang pada tahap analisis dan perancangan sistem.

# BAB 4 — PENUTUP

## 4.1 Kesimpulan
Website CS2Academy berhasil dirancang dan diimplementasikan sebagai platform pembelajaran E-Sports Counter-Strike 2 berbasis Laravel. Website ini dibuat menggunakan framework Laravel, bahasa pemrograman PHP, Blade sebagai template engine, serta MySQL sebagai basis data. Sistem ini menyediakan beberapa fitur utama, seperti registrasi, login, materi pembelajaran, kuis evaluasi, progress pembelajaran, layanan coaching, simulasi pembayaran, dan percakapan dalam sesi coaching.
Hasil pengujian menggunakan metode Black Box Testing menunjukkan bahwa fitur-fitur utama pada website CS2Academy dapat berjalan dengan baik sesuai rancangan. Fitur seperti halaman utama, registrasi, login, materi dan kuis, progress pembelajaran, coaching, pembayaran, sesi coaching, dashboard Admin, dan logout telah diuji dan memperoleh hasil sukses. Dengan demikian, website CS2Academy dapat digunakan sebagai media pembelajaran daring yang membantu pengguna dalam mempelajari materi dasar Counter-Strike 2 secara lebih terstruktur.

## 4.2 Saran
Website CS2Academy yang telah dikembangkan masih memiliki ruang untuk pengembangan lebih lanjut agar dapat memberikan manfaat yang lebih optimal. Sistem ini dapat dikembangkan dengan menambahkan integrasi pembayaran gateway nyata agar proses pembayaran layanan coaching tidak hanya berupa simulasi. Selain itu, materi pembelajaran dapat diperluas dengan topik yang lebih mendalam, seperti strategi lanjutan, analisis pertandingan, dan latihan berdasarkan peta tertentu. Fitur coaching juga dapat dikembangkan dengan penambahan jadwal pelatih dan riwayat sesi, sedangkan fitur sesi coaching dapat ditingkatkan dengan fasilitas unggah file, pemberian nilai, dan riwayat revisi. Ke depannya, tampilan antarmuka juga dapat dibuat lebih responsif agar nyaman digunakan pada berbagai perangkat.






# DAFTAR PUSTAKA

Firman, A., Wowor, H. F., Najoan, X., Teknik, J., Fakultas, E., & Unsrat, T. (2016). Sistem Informasi Perpustakaan Online Berbasis Web. E-Journal Teknik Elektro Dan Komputer, 5(2), 29–36.
Surono, G., Suhanda, Y., & Alfiah, F. (2022). Penerapan MVC Arsitektur Pada Sistem Informasi Monitoring Pada Divisi Produksi Menggunakan Laravel Framework. Journal Sensi, 8(2), 180–189. https://doi.org/10.33050/sensi.v8i2.2423
Itba, P., & Pksdu, D. C. C. (2024). ISSN : 2964-4763 Jurnal Ilmu Komputer , Sistem Informasi , Teknik Informatika ISSN : 2964-4763. 3(1), 1–12.
Dr. Ruliah, M.Kom. Andri Suryadi, S.Kom., M. K. (2016). Basis Data dan Sistem Basis Data Daftar Isi. 1–35.
Nursyaida, Anas, Anwar, A. S., Labolo, A. Y., & Azwar. (2022). Perancangan Media Pembelajaran Aritmatika Berbasis Web untuk Anak Tunagrahita Ringan. Simtek: Jurnal Sistem Informasi Dan Teknik Komputer, 7(2), 114–118.
Azhariyah, S., & Muhammad Mukhlis. (2024). Framework CSS: Tailwind CSS Untuk Front-End Website Store PT. XYZ. Jurnal Informatika, 3(1), 30–36. https://doi.org/10.57094/ji.v3i1.1601
Murani, N. A., Wahyuni, S., Pratiwi, R. A., Firdaus, T., & Wardianto. (2025). Analisis Penggunaan Visual Studio Code Sebagai Editor Pemrograman Terbaik Untuk Pemula Pada Mahasiswa Informatika Universitas Nurul Huda. Jurnal Rekayasa Informatika (Jrit), 2(2), 1–10. https://ejournal.pei.ac.id/index.php/JRIT/index
Prihandoyo, M. T. (2018). UML, Use case. Diagram class, activity. Unified Modeling Language (UML) Model Untuk Pengembangan Sistem Informasi Akademik Berbasis Web, 03(01), 126–129.
Al-Faruq, M. N. M., Nur’aini, S., & Aufan, M. H. (2022). Perancangan Ui / Ux Semarang Virtual Tourism. Walisongo Journal of Information Technology, 4(1), 43–52.
Harrness. (2023, December 13). The Seven Phases of the Software Development Life Cycle. Harness IO. https://www.harness.io/blog/software-development-life-cycle-phases
Bilal Haidar. (2025, December). Building MVC Applications in PHP Laravel. December. https://www.codemag.com/Article/2205071/Building-MVC-Applications-in-PHP-Laravel-Part-1
Taylor Otwell. (2025). Laravel - The clean stack for Artisans and agents. https://laravel.com/
Valve Corporation. (2023). Counter-Strike 2. https://www.counter-strike.net/cs2
Hamari, J., & Sjöblom, M. (2017). What is eSports and why do people watch it? Internet Research, 27(2), 211–232. https://doi.org/10.1108/IntR-04-2016-0085
Kosanke, R. M. (2019). Program Web Dasar. In Yayasan Kita Menulis.
Studi, P., Informasi, S., Komputer, F. I., & Makassar, U. H. (2025). Sistem Informasi Pengaduan Mahasiswa ( SIPMA ) menggunakan Framework Laravel pada Universitas Handayani Makassar Student Complain Information System ( SIPMA ) using the Laravel Framework at Handayani University Makassar. 14, 1246–1257.
Wahid, A. A. (2020). Jurnal Ilmu-ilmu Informatika dan Manajemen STMIK Oktober (2020) Analisis Metode Waterfall Untuk Pengembangan Sistem Informasi. Ilmu-Ilmu Informatika Dan ManajemenSTMIK, 1–5.
Wahid, A. A. (n.d.). Jurnal Ilmu-ilmu Informatika dan Manajemen STMIK Oktober (2020) Analisis Metode Waterfall Untuk Pengembangan Sistem Informasi.
Newzoo. (2022). Global Esports & Live Streaming Market Report.
Ridwan, M., & Fitri, I. (2021). Rancang Bangun Marketplace Berbasis Website menggunakan Metodologi Systems Development Life Cycle (SDLC) dengan Model Waterfall. Jurnal Teknologi Informasi Dan Komunikasi), 5(2), 2021. https://doi.org/10.35870/jti
Yudhi Handika, N., Fitriani, W., Studi Sistem Komputer, P., Sains dan Teknologi, F., Pembangunan Panca Budi, U., & Author, C. (2025). PERANCANGAN SISTEM E-LEARNING KURSUS ONLINE BERBASIS WEB MENGGUNAKAN LARAVEL. Jurnal Nasional Teknologi Komputer, 5(3).
Royce, W. W. (1970). MANAGING THE DEVELOPMENT OF LARGE SOFTWARE SYSTEMS.
SAP. (2026). What is a learning management system (LMS)? | SAP SuccessFactors HCM. https://www.sap.com/resources/what-is-lms



