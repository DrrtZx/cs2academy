<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Module;
use App\Models\Quiz;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'icon' => '🎯', 'title' => 'Aim & Movement', 'level' => 'Pemula', 'durasi' => '45 menit',
                'type' => 'Kursus Wajib', 'is_popular' => false,
                'body' => 'Aim yang konsisten adalah fondasi utama CS2. Di kursus ini kamu akan belajar crosshair placement yang benar, teknik counter-strafing, dan dasar-dasar spray control.',
                'modules' => [
                    ['title' => 'Crosshair Placement', 'body' => "Kenapa posisi crosshair menentukan reaction time kamu\nCara jaga crosshair setinggi kepala musuh di setiap sudut\nLatihan pre-aim di angle-angle umum map Mirage & Inferno", 'quizzes' => [
                        ['q' => 'Apa yang dimaksud crosshair placement yang baik?', 'opts' => ['Arahkan ke tanah selalu', 'Jaga setinggi kepala musuh di angle taktis', 'Gerakkan secepat mungkin ke segala arah', 'Selalu spray penuh tanpa membidik'], 'ans' => 1, 'ex' => 'Crosshair di level kepala musuh meminimalkan adjustment saat musuh muncul.'],
                        ['q' => 'Mengapa menaruh crosshair menempel pas di pinggir tembok itu berbahaya saat slicing the pie?', 'opts' => ['Bikin peluru tidak keluar', 'Reaction time manusia butuh jeda, sehingga musuh keburu lewat', 'Bikin gerakan lari lambat', 'Musuh bisa melihat crosshair kamu'], 'ans' => 1, 'ex' => 'Beri sedikit jarak dari tembok agar saat musuh peek, crosshair pas di kepalanya saat kamu bereaksi.'],
                        ['q' => 'Apa istilah teknik memeriksa sudut satu per satu saat memasuki area baru?', 'opts' => ['Rush B', 'Slicing the pie (Clearing angles)', 'Bunny hopping', 'Crab walking'], 'ans' => 1, 'ex' => 'Slicing the pie mengisolasi setiap angle satu per satu agar kamu tidak terekspos ke banyak musuh sekaligus.'],
                        ['q' => 'Kapan posisi crosshair harus disesuaikan ke level lebih tinggi/rendah?', 'opts' => ['Saat tanah naik (rampa) atau ada tempat elevated', 'Tidak pernah, harus selalu datar', 'Saat memakai pistol saja', 'Hanya saat reload'], 'ans' => 0, 'ex' => 'Ketinggian kepala musuh berubah mengikuti kontur tanah seperti di Stairs Mirage atau Ramp Nuke.'],
                    ]],
                    ['title' => 'Counter-Strafing', 'body' => "Kenapa tembak sambil jalan bikin akurasi kamu hancur\nTeknik tap arah berlawanan buat berhenti instan sebelum tembak", 'quizzes' => [
                        ['q' => 'Fungsi utama counter-strafing adalah?', 'opts' => ['Bikin karakter lari lebih cepat', 'Menghentikan pergerakan secara instan sebelum tembak', 'Mengisi ulang amunisi otomatis', 'Menyamarkan posisi di map'], 'ans' => 1, 'ex' => 'Counter-strafing menghentikan momentum gerakan sehingga akurasi tembakan langsung 100% pulih.'],
                        ['q' => 'Jika kamu sedang bergerak ke kanan dengan menekan tombol [D], tombol apa yang harus kamu tap untuk counter-strafe?', 'opts' => ['Tombol [W]', 'Tombol [A]', 'Tombol [S]', 'Tombol [Space]'], 'ans' => 1, 'ex' => 'Menekan tombol arah berlawanan ([A] lawan [D]) mengunci kecepatan karakter ke 0 unit/detik secara instan.'],
                        ['q' => 'Apa risiko terbesar melakukan firing (menembak) sebelum gerakan karakter berhenti sepenuhnya?', 'opts' => ['Senjata bisa jammed', 'Peluru pertama langsung melenceng acak (inaccuracy)', 'Layar bergetar hebat', 'Footstep terdengar lebih kencang'], 'ans' => 1, 'ex' => 'Dalam CS2, bergerak saat menembak menghasilkan spread peluru yang sangat acak.'],
                        ['q' => 'Senjata mana di CS2 yang masih memiliki akurasi bergerak lumayan tinggi dibandingkan rifle?', 'opts' => ['AK-47', 'AWP', 'Tec-9 & SMG (Mac-10 / MP9)', 'Desert Eagle'], 'ans' => 2, 'ex' => 'SMG dan beberapa pistol seperti Tec-9 dirancang untuk run-and-gun di jarak dekat.'],
                    ]],
                    ['title' => 'Spray Control', 'body' => "Pola recoil dasar AK-47 dan cara membacanya\nKompensasi mouse me-recoil pattern M4A4\nKapan harus spray vs kapan harus tap/burst", 'quizzes' => [
                        ['q' => 'Spray control paling efektif dipakai pada jarak?', 'opts' => ['Sangat jauh (long range)', 'Dekat-menengah (close-mid range)', 'Hanya saat reload', 'Tidak berpengaruh pada jarak'], 'ans' => 1, 'ex' => 'Spray paling efektif di jarak dekat-menengah. Jarak jauh lebih baik tap/burst.'],
                        ['q' => 'Secara umum, ke mana arah tarik mouse pertama saat melakukan spray control AK-47?', 'opts' => ['Ke atas', 'Ke bawah', 'Kanan atas', 'Kiri bawah'], 'ans' => 1, 'ex' => 'Peluru 3-5 pertama naik ke atas, sehingga mouse harus ditarik lurus ke bawah.'],
                        ['q' => 'Apa itu "burst firing"?', 'opts' => ['Menembak seluruh amunisi dalam magazin', 'Menembak 2-3 peluru terkontrol lalu melakukan reset recoil', 'Menembak sambil melompat', 'Menembak menggunakan peredam suara'], 'ans' => 1, 'ex' => 'Burst firing menjaga akurasi tinggi sambil tetap memberikan dps mematikan di jarak menengah-jauh.'],
                        ['q' => 'Mengapa melakukan spray sambil berjongkok (crouch spray) sering dilakukan pro player?', 'opts' => ['Bikin musuh tidak bisa menembak', 'Menurunkan recoil spread sedikit & mengejutkan crosshair musuh', 'Menambah damage peluru', 'Mempercepat reload'], 'ans' => 1, 'ex' => 'Crouch menurunkan center recoil dan mengubah head level kamu dari crosshair pre-aim musuh.'],
                    ]],
                    ['title' => 'Kuis Akhir: Aim & Movement', 'body' => "Kuis ini menggabungkan seluruh materi Crosshair, Counter-Strafing, dan Spray Control\nSelesaikan untuk membuka kursus berikutnya: Map Control", 'quizzes' => [
                        ['q' => 'Kombinasi teknik mana yang paling menentukan duel jarak dekat?', 'opts' => ['Crosshair placement + counter-strafing', 'Spray penuh tanpa henti sambil lari', 'Selalu jongkok di tengah jalan', 'Menghindari duel sama sekali'], 'ans' => 0, 'ex' => 'Crosshair placement + counter-strafing = akurasi instan satu ketukan di kepala.'],
                        ['q' => 'Di sudut long range seperti Mid Mirage, metode tembak mana yang paling direkomendasikan?', 'opts' => ['Full spray 30 peluru', 'Tap atau 2-bullet burst dengan counter-strafe', 'Jump shot', 'Run-and-gun'], 'ans' => 1, 'ex' => 'Di jarak jauh, recoil spread spray terlalu lebar. Tap/burst adalah kunci first-bullet accuracy.'],
                        ['q' => 'Apa penyebab utama seorang pemain sering kalah duel padahal aim-nya bagus?', 'opts' => ['Beli skin terlalu murah', 'Posisi crosshair terlalu rendah (nembak kaki) atau menembak saat bergerak', 'Menggunakan headset', 'Bermain di server lokal'], 'ans' => 1, 'ex' => 'Aim bagus jadi sia-sia jika crosshair selalu di lantai atau tembakan melenceng karena masih bergerak.'],
                        ['q' => 'Apa tujuan utama berlatih "Pre-aim" di workshop map?', 'opts' => ['Menghafal posisi spawn', 'Membiasakan crosshair berada tepat di sudut tempat musuh sering berada sebelum terlihat', 'Meningkatkan FPS', 'Mendapatkan achievement Steam'], 'ans' => 1, 'ex' => 'Pre-aim membuat kamu tidak perlu menggeser mouse saat peek karena crosshair sudah pas di kepalanya.'],
                    ]],
                ],
            ],
            [
                'icon' => '🗺', 'title' => 'Map Control', 'level' => 'Menengah', 'durasi' => '1 jam',
                'type' => 'Kursus Wajib', 'is_popular' => true,
                'body' => 'Map control adalah tentang menguasai area kunci sebelum musuh. Pelajari konsep early map control, pentingnya mid control, dan kapan harus push vs hold.',
                'modules' => [
                    ['title' => 'Mid Control Basics', 'body' => "Kenapa mid adalah jantungnya kebanyakan map CS2\nRotasi cepat antara site A dan B lewat mid\nLatihan peek & clear angle di mid Mirage", 'quizzes' => [
                        ['q' => 'Mengapa mid control sangat penting di map seperti Mirage atau Ascent?', 'opts' => ['Ada banyak senjata drop di sana', 'Membuka akses rotasi cepat ke site A dan B serta memecah pertahanan musuh', 'Grafisnya bagus', 'Untuk tempat AFK yang aman'], 'ans' => 1, 'ex' => 'Menguasai mid memberikan fleksibilitas menyerang ke dua site sekaligus.'],
                        ['q' => 'Apa risiko terbesar jika tim Terrorist membiarkan musuh menguasai Mid tanpa perlawanan?', 'opts' => ['Darah tim berkurang', 'CT bebas melakukan flank dari Mid ke spawn Terrorist', 'Waktu ronde langsung habis', 'Gagal membeli bom'], 'ans' => 1, 'ex' => 'Tanpa Mid control, CT bisa maju bebas (flank) dan mengurung T di daerah spawn.'],
                        ['q' => 'Utility apa yang paling efektif untuk memutus pandangan AWP musuh di Nest/Window Mid Mirage?', 'opts' => ['HE Grenade', 'Smoke Window dari spawn', 'Decoy Grenade', 'Molotov di underpass'], 'ans' => 0, 'ex' => 'Smoke Window wajib dilempar di awal ronde untuk membutakan sniper CT di Window.'],
                        ['q' => 'Apa arti istilah "Pincer Attack" (Serangan Jepitan) setelah menguasai Mid?', 'opts' => ['Menyerang dari satu pintu bersamaan', 'Menyerang site A/B bersamaan dari dua arah (misal: Short & Main A)', 'Melempar 5 grenade bersamaan', 'Save senjata bersama'], 'ans' => 1, 'ex' => 'Serangan dari dua sudut (Short + Main) membingungkan crosshair pemain yang bertahan di site.'],
                    ]],
                    ['title' => 'Information Play', 'body' => "Apa itu information play dan kenapa penting\nPeek berisiko rendah untuk memancing posisi musuh\nKomunikasi info ke tim secara efektif", 'quizzes' => [
                        ['q' => 'Apa yang dimaksud dengan "Information Play" dalam kompetitif CS2?', 'opts' => ['Membaca peta mini game', 'Gerakan berisiko rendah (jiggle/shoulder peek) untuk memancing tembakan & mengetahui posisi musuh', 'Bermain tanpa mikrofon', 'Selalu rush B tiap ronde'], 'ans' => 1, 'ex' => 'Info play bertumpu pada mengumpulkan lokasi musuh tanpa memberikan kill gratis.'],
                        ['q' => 'Teknik peek mana yang paling aman untuk mendapatkan info AWP musuh di sudut berbahaya?', 'opts' => ['Wide peek berdiri', 'Shoulder / Jiggle peek (peek secepat kilat lalu kembali ke cover)', 'Crouch walk peek', 'Jump peek ke tengah area terbuka'], 'ans' => 1, 'ex' => 'Shoulder peek memancing AWP menembak tembok tanpa mengenai badan kamu.'],
                        ['q' => 'Info apa yang PALING krusial untuk dikomunikasikan ke tim saat kamu melihat musuh?', 'opts' => ['Jumlah musuh, posisi spesifik, dan senjata yang dipakai (misal: 2 Mid, 1 AWP)', 'Keluhan tentang lag', 'Warna baju musuh', 'Skin senjata musuh'], 'ans' => 0, 'ex' => 'Info jumlah + lokasi + senjata membantu kawan mengambil keputusan rotasi yang tepat.'],
                        ['q' => 'Apa yang harus dilakukan tim Terrorist jika tidak menemukan musuh sama sekali di site A?', 'opts' => ['Langsung lari ke B', 'Waspada stacking/ambush dan periksa sudut tersembunyi dengan utility sebelum plant', 'Chat ke musuh', 'Drop C4 di jalan'], 'ans' => 1, 'ex' => 'Tidak ada info bukan berarti kosong — musuh bisa saja memainkan retake setup atau hiding.'],
                    ]],
                    ['title' => 'Smoke Lineups', 'body' => "Smoke dasar yang wajib dikuasai di setiap map\nMenutup line of sight agar tim bergerak aman\nTiming smoke yang tepat biar gak sia-sia", 'quizzes' => [
                        ['q' => 'Apa fungsi utama smoke grenade dalam perebutan area map?', 'opts' => ['Efek visual dekorasi', 'Menutup line of sight (sudut pandang) musuh agar tim bisa bergerak aman', 'Meracuni musuh saat lewat', 'Membuat suara ledakan keras'], 'ans' => 1, 'ex' => 'Smoke membutakan sudut sniper musuh, memungkinkan eksekusi site aman.'],
                        ['q' => 'Berapa durasi bertahan satu Smoke Grenade di CS2?', 'opts' => ['5 detik', '10 detik', 'Sekitar 20 detik', '1 menit'], 'ans' => 2, 'ex' => 'Smoke CS2 bertahan ~20 detik, memberikan jendela waktu eksekusi yang cukup.'],
                        ['q' => 'Fitur baru apa di CS2 yang memungkinkan Smoke dibolongkan sementara?', 'opts' => ['Ledakan HE Grenade dan tembakan peluru', 'Flashbang', 'Molotov', 'Defuse kit'], 'ans' => 0, 'ex' => 'Di CS2 (Sub-tick engine), HE grenade bisa menghilangkan asap smoke sementara waktu.'],
                        ['q' => 'Apa risiko melempar Smoke di posisi yang terlalu maju ke arah musuh (Deep Smoke)?', 'opts' => ['Asapnya cepat hilang', 'Musuh bisa menggunakan asap itu sebagai perlindungan untuk mendekat', 'Musuh dapat uang tambahan', 'Smoke tidak memantul'], 'ans' => 1, 'ex' => 'Bad smoke bisa malah menguntungkan musuh untuk bersembunyi atau push tak terduga.'],
                    ]],
                    ['title' => 'Kuis Akhir: Map Control', 'body' => "Rangkuman Mid Control, Information Play, dan Smoke Lineups\nSelesaikan untuk membuka kursus berikutnya", 'quizzes' => [
                        ['q' => 'Saat musuh sering melakukan push agresif di awal ronde, strategi terbaik tim kamu adalah?', 'opts' => ['Abaikan dan pasrah', 'Set setup nunggok (default hold) + siapkan utility counter-push di awal ronde', 'Selalu lari ke tempat musuh push', 'Keluar dari game'], 'ans' => 1, 'ex' => 'Counter-push dilakukan dengan menahan sudut aman dan melempar utility penahan (molo/flash).'],
                        ['q' => 'Apa yang dimaksud dengan konsep "Default Play" di awal ronde bagi Terrorist?', 'opts' => ['Semua pemain lari ke site A bersamaan', 'Menyebar di berbagai area map untuk mengumpulkan info & menahan push agresif CT', 'AFK di spawn selama 30 detik', 'Beli pistol saja'], 'ans' => 1, 'ex' => 'Default play mencegah CT mengambil gratis map control dan memberikan info posisi musuh.'],
                        ['q' => 'Mengapa membagi tim 4-1 (4 A, 1 Lurk B) sangat populer dalam taktik CS2?', 'opts' => ['Agar 1 pemain tidak kesepian', '1 pemain Lurk bisa menahan rotasi cepat musuh & memotong musuh dari belakang', 'Hanya kebetulan', 'Meningkatkan skor kill'], 'ans' => 1, 'ex' => 'Lurker bertugas memotong jalur rotasi CT yang panik berlari ke site eksekusi.'],
                        ['q' => 'Apa tindakan terbaik jika eksekusi site kamu digagalkan oleh Smoke & Molotov CT yang tebal?', 'opts' => ['Terobos api molotov bersamaan', 'Mundur sejenak, reset posisi, dan pilih rotate ke site lain atau tunggu utility habis', 'Tembak asap tanpa henti', 'Drop senjata'], 'ans' => 1, 'ex' => 'Menerobos utility CT membuat tim kamu babak belur. Lebih baik rotate atau tunggu utility padam.'],
                    ]],
                ],
            ],
            [
                'icon' => '💸', 'title' => 'Economy System', 'level' => 'Menengah', 'durasi' => '40 menit',
                'type' => 'Kursus Wajib', 'is_popular' => false,
                'body' => 'Economy CS2 sangat underrated. Pelajari kapan eco, force buy, dan full buy — serta cara koordinasi dengan tim agar semua bisa beli bersamaan.',
                'modules' => [
                    ['title' => 'Eco & Force Buy', 'body' => "Apa itu eco round dan kapan harus dilakuin\nForce buy: kalkulasi risiko vs reward\nKoordinasi tim saat ekonomi gak merata", 'quizzes' => [
                        ['q' => 'Kapan waktu yang paling tepat untuk melakukan Eco Round (Save)?', 'opts' => ['Selalu di ronde pertama', 'Saat tim tidak memiliki cukup uang untuk Full Buy bersama di ronde ini', 'Saat sedang memimpin skor jauh', 'Setiap ronde genap'], 'ans' => 1, 'ex' => 'Eco dilakukan agar uang tim terkumpul cukup untuk Full Buy ideal di ronde berikutnya.'],
                        ['q' => 'Apa risiko terbesar melakukan Force Buy yang gagal di ronde penting?', 'opts' => ['Karakter kena Banned', 'Ekonomi tim hancur total dan terpaksa Eco lagi di ronde selanjutnya (Double Eco)', 'Senjata hilang permanen', 'Musuh dapat uang $10.000'], 'ans' => 1, 'ex' => 'Gagal Force Buy memaksa tim kamu mengalami krisis uang berturut-turut.'],
                        ['q' => 'Berapa uang loss bonus minimum yang didapat tim saat kalah ronde pertama kali di CS2?', 'opts' => ['$1.000', '$1.400', '$2.900', '$3.400'], 'ans' => 1, 'ex' => 'Loss streak dimulai dari $1400, lalu bertambah $500 per kekalahan beruntun hingga max $3400.'],
                        ['q' => 'Apa tujuan utama tim yang sedang Eco saat bermain sebagai Terrorist?', 'opts' => ['Membunuh semua musuh', 'Menanam bomb (Plant C4) untuk mendapat bonus $800 per pemain atau cari exit kill', 'Lari keliling map', 'Sembunyi di spawn'], 'ans' => 1, 'ex' => 'Plant bomb di ronde Eco memberikan ekstra $800 bagi seluruh anggota tim T.'],
                    ]],
                    ['title' => 'Bonus Round Strategy', 'body' => "Kenapa bonus round setelah menang pistol krusial\nPilihan senjata cost-efficient: SMG & shotgun\nJangan greedy — jaga keunggulan ekonomi", 'quizzes' => [
                        ['q' => 'Pilihan senjata paling efisien di ronde 2 setelah memenangkan Pistol Round adalah?', 'opts' => ['Langsung beli AWP', 'Menabung tanpa beli apa-apa', 'SMG (MP9 / MAC-10) atau Galil/Famas + Armor Penuh', 'Hanya beli Granat'], 'ans' => 2, 'ex' => 'SMG efisien membantai musuh yang sedang Eco (tanpa helmet) dan memberi kill reward $600.'],
                        ['q' => 'Berapa Kill Reward yang didapatkan saat mengeliminasi musuh menggunakan SMG seperti MP9 / MAC-10?', 'opts' => ['$100', '$300', '$600', '$900'], 'ans' => 2, 'ex' => 'SMG memberikan kill reward $600 (2x lipat dari rifle $300), sangat bagus membangun bank uang.'],
                        ['q' => 'Mengapa membeli AWP di ronde 2 setelah menang pistol sering dianggap "Greedy Risk"?', 'opts' => ['AWP tidak ada di shop', 'Jika mati, AWP gratis jatuh ke tangan musuh yang sedang Eco dan merusak ekonomi tim', 'AWP tidak bisa menembak', 'AWP harganya murah'], 'ans' => 1, 'ex' => 'Memberikan AWP gratis ke musuh eco bisa membalikkan keadaan ronde secara tragis.'],
                        ['q' => 'Apa yang dimaksud dengan istilah "Hero Rifle" di ronde berisiko?', 'opts' => ['Satu pemain membeli AK-47/M4 sendirian sementara kawan lain Eco/Pistol', 'Membeli 5 rifle sekaligus', 'Membeli Grenade saja', 'Menggunakan Knife sepanjang ronde'], 'ans' => 0, 'ex' => 'Hero Rifle mengandalkan 1 fragger utama untuk mencari entry kill pembuka jalan.'],
                    ]],
                    ['title' => 'Full Buy Math', 'body' => "Komponen full buy: rifle + armor + utility\nBerapa minimum untuk full buy ideal\nBaca ekonomi lawan dari kill feed & utility yang dipakai", 'quizzes' => [
                        ['q' => 'Berapa perkiraan saldo minimum yang dibutuhkan satu pemain CT untuk Full Buy ideal (Rifle + Kevlar/Helm + Kit + Full Utility)?', 'opts' => ['$1.000', '$2.500', 'Sekitar $4.500 - $5.000', '$10.000'], 'ans' => 2, 'ex' => 'M4A4 ($3100) + Helm ($1000) + Kit ($400) + Utility ($1000) = ~$5500.'],
                        ['q' => 'Apa perbedaan fungsi antara Kevlar Vest ($650) dan Kevlar + Helmet ($1000)?', 'opts' => ['Kevlar Vest melindung kepala dari One-tap AK-47', 'Helmet melindungi kepala dari One-tap pistol & SMG agar tidak langsung mati', 'Helmet bikin lari lebih cepat', 'Kevlar Vest hanya untuk kaki'], 'ans' => 1, 'ex' => 'Helmet mencegah pistol (USP/Glock/MP9) membunuhmu dalam 1 tembakan kepala.'],
                        ['q' => 'Saat bertanding melawan Terrorist yang menggunakan AK-47 di late game, apakah CT wajib membeli Helmet ($350 tambahan)?', 'opts' => ['Wajib selalu', 'Bisa dipertimbangkan skip jika uang pas-pasan, karena AK-47 selalu 1-tap helm maupun tidak', 'Helm bikin AK-47 tidak membal', 'Gak berpengaruh'], 'ans' => 1, 'ex' => 'AK-47 memberikan headshot 1-tap tembus helm. Skip helm hemat $350 saat uang CT krisis.'],
                        ['q' => 'Bagaimana cara memprediksi bahwa musuh sedang mengalami krisis uang (Eco) di ronde selanjutnya?', 'opts' => ['Lihat berapa kali musuh kalah berturut-turut & tidak ada plant bomb di ronde sebelumnya', 'Tanya musuh di all chat', 'Lihat skor game', 'Tebak acak'], 'ans' => 0, 'ex' => 'Membaca loss streak musuh adalah kunci memprediksi kekuatan senjata lawan.'],
                    ]],
                    ['title' => 'Kuis Akhir: Economy', 'body' => "Rangkuman Eco, Force Buy, Bonus Round, dan Full Buy Math\nSelesaikan untuk membuka kursus berikutnya", 'quizzes' => [
                        ['q' => 'Tim kamu kalah ronde dan 3 pemain punya $3.000, sedangkan 2 pemain kaya punya $6.000. Apa keputusan ekonomi terbaik?', 'opts' => ['Semua nekat beli sendiri-sendiri', 'Dua pemain kaya membelikan (drop) AK/M4 untuk kawannya agar seluruh tim bisa buy kompetitif bersama', 'Semua simpan uang (full eco)', 'Beli Deagle saja'], 'ans' => 1, 'ex' => 'Drop senjata meratakan kekuatan tim tanpa meninggalkan kawan dengan pistol biasa.'],
                        ['q' => 'Berapa uang bonus yang didapatkan Terrorist jika berhasil menanam bomb (C4) walaupun akhirnya ronde tersebut kalah?', 'opts' => ['$0', '$300 per pemain', '$800 per pemain', '$3.000 per pemain'], 'ans' => 2, 'ex' => 'Plant bonus $800 sangat berharga untuk membangun modal beli di ronde berikutnya.'],
                        ['q' => 'Apa fungsi utama Defuse Kit bagi pemain CT?', 'opts' => ['Memotong waktu jinakkan bomb dari 10 detik menjadi 5 detik', 'Menambah armor', 'Membuat bom tidak bisa meledak', 'Mempercepat lari'], 'ans' => 0, 'ex' => 'Kit memotong waktu defuse menjadi 5 detik — sering kali jadi pembeda antara menang vs kehabisan waktu.'],
                        ['q' => 'Kapan situasi di mana tim KAMU harus memprioritaskan "Drop Senjata" untuk kawan daripada membeli utility pribadi?', 'opts' => ['Saat kawan tidak punya senjata utama (Rifle)', 'Saat kawan minta skin', 'Setiap awal ronde', 'Saat kawan sudah punya $16.000'], 'ans' => 0, 'ex' => 'Firepower rifle tim jauh lebih berharga daripada 1 grenade ekstra di tanganmu.'],
                    ]],
                ],
            ],
            [
                'icon' => '🧪', 'title' => 'Utility Usage', 'level' => 'Menengah', 'durasi' => '1 jam',
                'type' => 'Kursus Wajib', 'is_popular' => false,
                'body' => 'Utility adalah senjata kedua di CS2. Pelajari kapan throw smoke, cara bounce flash agar musuh tidak bisa dodge, dan penggunaan molotov untuk area denial.',
                'modules' => [
                    ['title' => 'Smoke Fundamentals', 'body' => "Fungsi utama smoke grenade di CS2\nMemblok line of sight dan area tertentu\nPerbedaan smoke defensif vs ofensif", 'quizzes' => [
                        ['q' => 'Apa fungsi utama Smoke Grenade di CS2?', 'opts' => ['Meracuni musuh', 'Memblokir sudut pandang (line of sight) musuh dan memberi cover area', 'Membuat suara bising', 'Memperlambat lari musuh'], 'ans' => 1, 'ex' => 'Smoke menutup sudut pandang sniper/defender musuh agar tim bergerak aman.'],
                        ['q' => 'Apa itu istilah "One-way Smoke"?', 'opts' => ['Smoke yang dilempar satu arah saja', 'Smoke khusus yang memungkinkan kamu melihat musuh tapi musuh tidak melihatmu', 'Smoke yang langsung padam', 'Smoke berwarna merah'], 'ans' => 1, 'ex' => 'One-way smoke memanfaatkan sudut ketinggian asap untuk mendapat vantage point rahasia.'],
                        ['q' => 'Bagaimana interaksi unik antara HE Grenade dengan Smoke di CS2?', 'opts' => ['HE grenade akan memadamkan smoke permanen', 'Ledakan HE grenade membuat lubang pandang sementara pada asap smoke selama beberapa detik', 'HE grenade memantul kembali', 'Asap berubah jadi api'], 'ans' => 1, 'ex' => 'Ledakan HE membuka celah asap sementara untuk surprise kill.'],
                        ['q' => 'Apa yang terjadi jika Molotov dilempar tepat di atas permukaan asap Smoke?', 'opts' => ['Molotov meledak lebih besar', 'Api molotov langsung padam (extinguished) secara instan', 'Smoke ikut terbakar', 'Tidak terjadi apa-apa'], 'ans' => 1, 'ex' => 'Asap smoke secara otomatis memadamkan api molotov di area tersebut.'],
                    ]],
                    ['title' => 'Flash Techniques', 'body' => "Flash yang efektif — pop flash vs bounce flash\nCara bounce dari dinding agar musuh tak bisa menghindar\nHindari nge-flash teman sendiri (team flash)", 'quizzes' => [
                        ['q' => 'Manakah jenis Flashbang yang paling sulit dihindari (dodge) oleh musuh?', 'opts' => ['Flashbang yang dilempar tinggi melayang di udara lama', 'Pop-Flash (Flash yang meledak tepat saat keluar dari tembok tanpa peringatan suara)', 'Flashbang yang jatuh di kaki sendiri', 'Flashbang tanpa bounce'], 'ans' => 1, 'ex' => 'Pop-flash meledak instan di pandangan musuh tanpa memberi waktu berbalik badan.'],
                        ['q' => 'Bagaimana cara melempar Flashbang menggunakan klik kanan (Secondary Attack)?', 'opts' => ['Melempar melambung sangat jauh', 'Melempar dengan jarak dekat (underhand lob) pelan', 'Membuang flashbang ke tanah', 'Memicu flashbang di tangan'], 'ans' => 1, 'ex' => 'Klik kanan melempar pelan di dekat badan, cocok untuk pop-flash peek cepat.'],
                        ['q' => 'Berapa durasi maksimal dibutakan oleh efek Full Flashbang di CS2?', 'opts' => ['1 detik', 'Sekitar 4 - 5 detik', '10 detik', 'Sepanjang ronde'], 'ans' => 1, 'ex' => 'Full flash membutakan layar putih total hingga ~4.7 detik.'],
                        ['q' => 'Apa yang harus kamu lakukan jika kawan kamu memberi aba-aba "Flashing A Site"?', 'opts' => ['Maju dan tatap arah flash', 'Berbalik arah (turn around/look away) sejenak agar tidak kena kebutaan flash kawan', 'Lari ke spawn', 'Tembak kawan'], 'ans' => 1, 'ex' => 'Berbalik arah meminimalkan efek kebutaan dari flash kawan (anti team-flash).'],
                    ]],
                    ['title' => 'Molotov & Area Denial', 'body' => "Kapan molotov paling efektif\nMembakar choke point dan spot favorit musuh\nKombinasi molotov + smoke untuk area denial total", 'quizzes' => [
                        ['q' => 'Apa fungsi taktis utama dari Incendiary / Molotov Grenade?', 'opts' => ['Memberikan efek cahaya', 'Area Denial — memaksa musuh keluar dari posisi persembunyian atau menunda advance musuh', 'Menghancurkan tembok', 'Menyembuhkan darah kawan'], 'ans' => 1, 'ex' => 'Molotov memaksa musuh keluar ke area terbuka atau mengulur waktu plant/defuse.'],
                        ['q' => 'Berapa lama durasi api Molotov membakar tanah sebelum padam?', 'opts' => ['3 detik', 'Sekitar 7 detik', '15 detik', ' Sampai akhir ronde'], 'ans' => 1, 'ex' => 'Api molotov membakar selama ~7 detik, sangat berguna mengulur detik-detik terakhir.'],
                        ['q' => 'Mengapa Molotov sangat efektif digunakan saat situasi Retake bagi CT?', 'opts' => ['Bikin bom cepat jinak', 'Memaksa Terrorist keluar dari sudut sembunyi (seperti Ninja / Default spot) tanpa perlu peek fisik', 'Memadamkan smoke', 'Mengisi amunisi'], 'ans' => 1, 'ex' => 'Molotov "membersihkan" sudut tersembunyi tanpa risiko kawan kamu tertembak duluan.'],
                        ['q' => 'Apa perbedaan nama dan harga utility pembakar di sisi Terrorist vs CT?', 'opts' => ['T pakai Molotov ($400), CT pakai Incendiary Grenade ($500)', 'Sama saja', 'CT gratis', 'T tidak bisa beli molotov'], 'ans' => 0, 'ex' => 'Molotov T berharga $400, sedangkan Incendiary CT berharga $500.'],
                    ]],
                    ['title' => 'Kuis Akhir: Utility Usage', 'body' => "Rangkuman Smoke, Flash, dan Molotov\nSelesaikan untuk membuka kursus berikutnya", 'quizzes' => [
                        ['q' => 'Di situasi 1v1 post-plant sebagai CT, kombinasi utility apa yang paling krusial untuk menahan defuser?', 'opts' => ['Semua smoke dilempar sekaligus', 'Flashbang + Molotov untuk delay defuse di detik-detik terakhir', 'Hanya mengandalkan knife', 'Utility tidak berguna di 1v1'], 'ans' => 1, 'ex' => 'Molotov di atas bom memaksa musuh tidak bisa defuse selama 7 detik penuh.'],
                        ['q' => 'Apa arti istilah "Utility Lineup" dalam CS2?', 'opts' => ['Menjual granat di shop', 'Posisi berdiri dan titik bidik crosshair spesifik untuk mendaratkan granat di lokasi presisi', 'Menyusun granat di lantai', 'Beli granat acak'], 'ans' => 1, 'ex' => 'Lineup memastikan smoke/flash jatuh tepat di spot sasaran tanpa misthrow.'],
                        ['q' => 'Apa risiko melempar HE Grenade ke area sempit di mana kawan kamu sedang berada?', 'opts' => ['Kawan mendapat damage kawan (Friendly Fire / Team Damage)', 'Granat berubah jadi smoke', 'Musuh dapat poin bonus', 'Gak ada risiko'], 'ans' => 0, 'ex' => 'HE grenade memberi team damage cukup besar jika memantul salah di dekat kawan.'],
                        ['q' => 'Urutan pelemparan utility yang benar saat eksekusi bombsite adalah?', 'opts' => ['Smoke dulu untuk tutup angle jauh ➔ Molotov ke spot ngintip ➔ Flashbang pembuka jalan saat masuk', 'Flashbang dulu baru Smoke', 'Semua dilempar asal', 'Tidak perlu utility'], 'ans' => 0, 'ex' => 'Smoke menutup sudut sniper ➔ Molotov usir persembunyian ➔ Flash meledak saat entry hitter masuk.'],
                    ]],
                ],
            ],
            [
                'icon' => '🧠', 'title' => 'Game Sense', 'level' => 'Lanjutan', 'durasi' => '1.5 jam',
                'type' => 'Kursus Lanjutan', 'is_popular' => true,
                'body' => 'Game sense membedakan pemain biasa dari pemain hebat — kemampuan memprediksi situasi tanpa melihat musuh. Pelajari cara membaca informasi dan membuat keputusan terbaik.',
                'modules' => [
                    ['title' => 'Reading the Enemy', 'body' => "Apa inti dari game sense di CS2\nMemprediksi posisi dan keputusan musuh dari info yang ada\nPola permainan musuh dan cara membacanya", 'quizzes' => [
                        ['q' => 'Apa inti utama dari kemampuan "Game Sense" di CS2?', 'opts' => ['Kecepatan menggeser mouse', 'Kemampuan memprediksi posisi, ekonomi, dan pergerakan musuh berdasarkan minimnya informasi', 'Hafal nama-nama tempat', 'Punya jam main 10.000 jam'], 'ans' => 1, 'ex' => 'Game sense adalah kalkulasi logika tentang apa yang kemungkinan besar dilakukan musuh.'],
                        ['q' => 'Jika kamu mendengar suara 4 musuh lari di A Site tapi bom belum kelihatan, apa kesimpulan game sense kamu?', 'opts' => ['Musuh pasti semuanya ada di A', 'Waspada 1 pemain musuh mungkin melakukan Fake atau membawa bom ke B (Lurker)', 'Langsung disconnect', 'Musuh sedang AFK'], 'ans' => 1, 'ex' => 'Pemain ke-5 bisa saja membawa bom ke site lawan sementara 4 lainnya membuat kekacauan (Fake).'],
                        ['q' => 'Bagaimana cara memanfaatkan suara footstep musuh untuk keuntungan taktis?', 'opts' => ['Lari ke arah suara', 'Hitung jumlah langkah & arah geraknya untuk menyiapkan pre-aim atau utility ambush', 'Matikan suara game', 'Chat musuh'], 'ans' => 1, 'ex' => 'Suara footstep memberi tahu estimasi jumlah & kecepatan pergerakan musuh.'],
                        ['q' => 'Apa itu istilah "Trigger Discipline" dalam situasi bertahan atau mengepung musuh?', 'opts' => ['Menembak langsung saat melihat ujung baju musuh', 'Menahan diri tidak menembak musuh pertama agar bisa mendapatkan kill lebih banyak dari barisan musuh di belakangnya', 'Melepas tombol tembak saat spray', 'Membeli senjata otomatis'], 'ans' => 1, 'ex' => 'Trigger discipline membiarkan musuh lewat agar kamu bisa mengeksekusi multi-kill dari belakang.'],
                    ]],
                    ['title' => 'Adaptasi & Rotasi', 'body' => "Saat satu teammate mati — evaluasi ulang strategi\nKapan harus agresif vs pasif\nRotasi cepat dan efektif berdasarkan info", 'quizzes' => [
                        ['q' => 'Saat satu teammate mati di awal ronde (First Death), apa yang harus dilakukan tim?', 'opts' => ['Panik dan nekat lari balasan', 'Evaluasi ulang — adaptasi strategi, main lebih tertutup (safe) atau ganti fokus site', 'Langsung menyerah', 'Diam di spawn'], 'ans' => 1, 'ex' => 'Kehilangan 1 pemain mengubah peta kekuatan. Jangan memaksakan strategi awal yang sudah bocor.'],
                        ['q' => 'Kapan waktu yang paling tepat bagi pemain CT di B Site untuk melakukan Rotasi ke A Site?', 'opts' => ['Saat mendengar suara bom ditanam (Plant) atau ada konfirmasi jelas keberadaan C4 di A', 'Saat ronde baru mulai 1 detik', 'Saat kawan di A baru melihat 1 flashbang', 'Tidak pernah rotasi'], 'ans' => 0, 'ex' => 'Konfirmasi C4 adalah sinyal valid untuk rotasi penuh.'],
                        ['q' => 'Apa bahaya melakukan rotasi dengan berlari (sprint) lewat jalur terbuka tanpa memeriksa sudut?', 'opts' => ['Sepatu karakter jadi kotor', 'Rentan dibunuh oleh pemain Lurker musuh yang sengaja menanti jalur rotasi kamu', 'Darah berkurang', 'Senjata hilang'], 'ans' => 1, 'ex' => 'Lurker bertugas memotong pemain yang rotasi dengan terburu-buru.'],
                        ['q' => 'Apa yang dimaksud dengan strategi "Retake" bersama tim?', 'opts' => ['Merebut kembali bombsite yang sudah dikuasai musuh secara terkoordinasi menggunakan utility bersama', 'Maju satu per satu', 'Save senjata di spawn', 'Menunggu bom meledak'], 'ans' => 0, 'ex' => 'Retake butuh sinkronisasi smoke/flash bersamaan sebelum masuk bombsite.'],
                    ]],
                    ['title' => 'Timing & Decision Making', 'body' => "Cara membaca timing rotasi musuh\nDengar footstep, perhatikan economy & info dari tim\nKeputusan di bawah tekanan: kapan push, kapan hold", 'quizzes' => [
                        ['q' => 'Di situasi 1v2 (kamu sendirian lawan 2 musuh), strategi terbaik kamu adalah?', 'opts' => ['Lari ke tengah area terbuka', 'Isolasi pertarungan menjadi dua kali duel 1v1 menggunakan sudut & cover', 'Jongkok di pojok', 'Tembak ke langit'], 'ans' => 1, 'ex' => 'Memecah situasi 1v2 menjadi dua kali duel 1v1 meningkatkan peluang menang secara drastis.'],
                        ['q' => 'Kapan seorang pemain Terrorist harus mengambil keputusan untuk "Save Senjata" daripada mencoba retake/clutch?', 'opts' => ['Saat waktu tersisa 10 detik, hp tipis 10 HP, lawan 4 CT dengan armor penuh & bomsite dijaga ketat', 'Setiap kali darah berkurang', 'Saat memegang pistol', 'Saat tim menang'], 'ans' => 0, 'ex' => 'Save rifle $4700 + kevlar menyelamatkan ekonomi tim untuk ronde berikutnya.'],
                        ['q' => 'Apa itu "Trade Kill" dan mengapa sangat penting dalam game kompetitif?', 'opts' => ['Tukar skin senjata saat mati', 'Membunuh musuh yang baru saja membunuh kawanmu dalam jeda waktu singkat', 'Membeli senjata bekas', 'Tukar posisi berdiri'], 'ans' => 1, 'ex' => 'Trade kill memastikan kematian kawanmu tidak sia-sia dan menjaga keseimbangan jumlah pemain.'],
                        ['q' => 'Apa arti kata "Clutch" di CS2?', 'opts' => ['Memenangkan ronde saat kamu menjadi pemain terakhir yang tersisa di timmu (misal 1v3 Clutch)', 'Membeli AWP di ronde 1', 'Melakukan defuse bom dalam 1 detik', 'Membawa bom sendirian'], 'ans' => 0, 'ex' => 'Clutch adalah momen kemenangan yang diraih oleh survivor terakhir dalam tim.'],
                    ]],
                    ['title' => 'Kuis Akhir: Game Sense', 'body' => "Rangkuman Reading, Adaptasi, dan Decision Making\nKamu udah menyelesaikan seluruh kursus CS2 Academy!", 'quizzes' => [
                        ['q' => 'Kamu melihat 3 musuh di A dan C4 (bom) terlihat jatuh di lantai dekat A. Langkah terbaik sebagai pemain B:', 'opts' => ['Tetap diam di B sepanjang ronde', 'Segera rotasi membantu A via jalur aman sambil menyisakan 1 pemain menjaga flank', 'Lari ke spawn Terrorist', 'Save senjata'], 'ans' => 1, 'ex' => 'C4 yang jatuh di tanah adalah kepastian lokasi objektif utama musuh.'],
                        ['q' => 'Apa kesalahan paling umum pemain pemula saat melakukan clutch 1v1 post-plant?', 'opts' => ['Terlalu banyak membuat suara langkah kaki (footstep) yang membocorkan posisinya ke musuh', 'Menembak musuh', 'Menggunakan armor', 'Membeli kit'], 'ans' => 0, 'ex' => 'Suara footstep memberi tahu musuh di mana kamu berada dan dari mana kamu akan peek.'],
                        ['q' => 'Mengapa menjaga ketenangan (composure) dan tidak ngamuk (tilt) mempengaruhi Game Sense kamu?', 'opts' => ['Tilt merusak fokus logika, membuat keputusan terburu-buru, dan menurunkan respon koordinasi', 'Bikin internet lambat', 'Gak ada pengaruhnya', 'Bikin senjata melenceng'], 'ans' => 0, 'ex' => 'Ketenangan adalah kunci mengambil keputusan rasional di situasi tertekan.'],
                        ['q' => 'Selamat! Kamu telah menguasai seluruh materi CS2 Academy. Apa langkah selanjutnya untuk terus berkembang?', 'opts' => ['Hapus game', 'Praktekkan rutin di Matchmaking/FACEIT, analisa demo sendiri, dan selalu evaluasi kesalahan', 'Salahkan kawan tiap kalah', 'Berhenti berlatih'], 'ans' => 1, 'ex' => 'Konsistensi latihan + evaluasi demo adalah jalan menjadi Pro Player CS2 sesungguhnya!'],
                    ]],
                ],
            ],
        ];

        foreach ($data as $i => $d) {
            $course = Course::create([
                'icon'       => $d['icon'],
                'title'      => $d['title'],
                'body'       => $d['body'],
                'urutan'     => $i,
                'level'      => $d['level'],
                'durasi'     => $d['durasi'],
                'type'       => $d['type'],
                'is_popular' => $d['is_popular'],
            ]);

            foreach ($d['modules'] as $mIdx => $m) {
                $module = Module::create([
                    'course_id'   => $course->id,
                    'title'       => $m['title'],
                    'body'        => $m['body'],
                    'urutan'      => $mIdx,
                    'youtube_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                ]);

                foreach ($m['quizzes'] as $qIdx => $q) {
                    Quiz::create([
                        'course_id'     => $course->id,
                        'module_id'     => $module->id,
                        'pertanyaan'    => $q['q'],
                        'opsi'          => $q['opts'],
                        'jawaban_benar' => $q['ans'],
                        'penjelasan'    => $q['ex'],
                    ]);
                }
            }
        }
    }
}
