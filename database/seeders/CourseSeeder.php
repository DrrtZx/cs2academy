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
                        ['q' => 'Apa yang dimaksud crosshair placement yang baik?', 'opts' => ['Arahkan ke tanah selalu', 'Jaga setinggi kepala musuh', 'Gerakkan secepat mungkin', 'Selalu spray penuh'], 'ans' => 1, 'ex' => 'Crosshair di level kepala musuh meminimalkan adjustment saat peek.'],
                    ]],
                    ['title' => 'Counter-Strafing', 'body' => "Kenapa tembak sambil jalan bikin akurasi kamu hancur\nTeknik tap arah berlawanan buat berhenti instan sebelum tembak", 'quizzes' => [
                        ['q' => 'Fungsi utama counter-strafing adalah?', 'opts' => ['Bikin karakter lari lebih cepat', 'Menghentikan pergerakan secara instan sebelum tembak', 'Mengisi ulang amunisi otomatis', 'Menyamarkan posisi di map'], 'ans' => 1, 'ex' => 'Counter-strafing menghentikan momentum gerakan sehingga akurasi tembakan langsung pulih.'],
                    ]],
                    ['title' => 'Spray Control', 'body' => "Pola recoil dasar AK-47 dan cara membacanya\nKompensasi mouse untuk spray pattern M4A4\nKapan harus spray vs kapan harus tap/burst", 'quizzes' => [
                        ['q' => 'Spray control paling efektif dipakai pada jarak?', 'opts' => ['Sangat jauh (long range)', 'Dekat-menengah (close-mid range)', 'Hanya saat reload', 'Tidak berpengaruh pada jarak'], 'ans' => 1, 'ex' => 'Spray paling efektif di jarak dekat-menengah. Jarak jauh lebih baik tap/burst.'],
                    ]],
                    ['title' => 'Kuis Akhir: Aim & Movement', 'body' => "Kuis ini menggabungkan seluruh materi Crosshair, Counter-Strafing, dan Spray Control\nSelesaikan untuk membuka kursus berikutnya: Map Control", 'quizzes' => [
                        ['q' => 'Kombinasi teknik mana yang paling menentukan duel jarak dekat?', 'opts' => ['Crosshair placement + counter-strafing', 'Spray penuh tanpa henti', 'Selalu jongkok', 'Menghindari duel sama sekali'], 'ans' => 0, 'ex' => 'Crosshair placement + counter-strafing = akurasi instan di jarak dekat.'],
                    ]],
                ],
            ],
            [
                'icon' => '🗺', 'title' => 'Map Control', 'level' => 'Menengah', 'durasi' => '1 jam',
                'type' => 'Kursus Wajib', 'is_popular' => true,
                'body' => 'Map control adalah tentang menguasai area kunci sebelum musuh. Pelajari konsep early map control, pentingnya mid control, dan kapan harus push vs hold.',
                'modules' => [
                    ['title' => 'Mid Control Basics', 'body' => "Kenapa mid adalah jantungnya kebanyakan map CS2\nRotasi cepat antara site A dan B lewat mid\nLatihan peek & clear angle di mid Mirage", 'quizzes' => [
                        ['q' => 'Mengapa mid control penting di Mirage?', 'opts' => ['Ada banyak senjata drop di sana', 'Membuka rotasi cepat ke A dan B', 'Grafisnya bagus', 'Untuk camping aman'], 'ans' => 1, 'ex' => 'Menguasai mid membuka akses split-attack ke site A dan B.'],
                    ]],
                    ['title' => 'Information Play', 'body' => "Apa itu information play dan kenapa penting\nPeek berisiko rendah untuk memancing posisi musuh\nKomunikasi info ke tim secara efektif", 'quizzes' => [
                        ['q' => 'Apa itu "information play"?', 'opts' => ['Membaca peta mini game', 'Peek berisiko rendah untuk memancing posisi musuh', 'Bermain tanpa info', 'Selalu rush B tiap ronde'], 'ans' => 1, 'ex' => 'Gerakan kecil untuk mendapat info musuh tanpa risiko besar.'],
                    ]],
                    ['title' => 'Smoke Lineups', 'body' => "Smoke dasar yang wajib dikuasai di setiap map\nMenutup line of sight agar tim bergerak aman\nTiming smoke yang tepat biar gak sia-sia", 'quizzes' => [
                        ['q' => 'Apa fungsi smoke dalam map control?', 'opts' => ['Hanya efek visual', 'Menutup line of sight agar tim bergerak aman', 'Meracuni musuh', 'Tidak berguna di rank rendah'], 'ans' => 1, 'ex' => 'Smoke memblok pandangan sniper dan musuh dari angle kunci.'],
                    ]],
                    ['title' => 'Kuis Akhir: Map Control', 'body' => "Rangkuman Mid Control, Information Play, dan Smoke Lineups\nSelesaikan untuk membuka kursus berikutnya", 'quizzes' => [
                        ['q' => 'Saat musuh sering push mid, strategi terbaik untuk tim kamu adalah?', 'opts' => ['Abaikan mid dan fokus ke site', 'Koordinasikan double-peek atau utility untuk counter mid push', 'Selalu hindari mid sepanjang game', 'Laporkan musuh'], 'ans' => 1, 'ex' => 'Koordinasi utility + double peek bisa membalikkan kontrol mid.'],
                    ]],
                ],
            ],
            [
                'icon' => '💸', 'title' => 'Economy System', 'level' => 'Menengah', 'durasi' => '40 menit',
                'type' => 'Kursus Wajib', 'is_popular' => false,
                'body' => 'Economy CS2 sangat underrated. Pelajari kapan eco, force buy, dan full buy — serta cara koordinasi dengan tim agar semua bisa beli bersamaan.',
                'modules' => [
                    ['title' => 'Eco & Force Buy', 'body' => "Apa itu eco round dan kapan harus dilakuin\nForce buy: kalkulasi risiko vs reward\nKoordinasi tim saat ekonomi gak merata", 'quizzes' => [
                        ['q' => 'Kapan tepat melakukan eco round?', 'opts' => ['Selalu ronde pertama', 'Uang tidak cukup untuk full buy bersama', 'Musuh terlihat lemah', 'Setiap ronde genap'], 'ans' => 1, 'ex' => 'Eco = save untuk full buy ronde berikutnya bareng tim.'],
                    ]],
                    ['title' => 'Bonus Round Strategy', 'body' => "Kenapa bonus round setelah menang pistol krusial\nPilihan senjata cost-efficient: SMG & shotgun\nJangan greedy — jaga keunggulan ekonomi", 'quizzes' => [
                        ['q' => 'Pilihan terbaik saat bonus round setelah menang pistol?', 'opts' => ['Beli rifle langsung', 'Menabung semua uang', 'SMG/shotgun cost-efficient', 'Tetap pakai pistol'], 'ans' => 2, 'ex' => 'SMG seperti MP9 atau MAC-10 efisien dan memberikan kill reward tinggi.'],
                    ]],
                    ['title' => 'Full Buy Math', 'body' => "Komponen full buy: rifle + armor + utility\nBerapa minimum untuk full buy ideal\nBaca ekonomi lawan dari kill feed & utility yang dipakai", 'quizzes' => [
                        ['q' => 'Berapa minimum uang untuk full buy ideal?', 'opts' => ['$1000', '$2000', '$4000 atau lebih', '$500'], 'ans' => 2, 'ex' => 'Full buy butuh ~$4000+ untuk rifle, armor penuh, dan utility dasar.'],
                    ]],
                    ['title' => 'Kuis Akhir: Economy', 'body' => "Rangkuman Eco, Force Buy, Bonus Round, dan Full Buy Math\nSelesaikan untuk membuka kursus berikutnya", 'quizzes' => [
                        ['q' => 'Tim kamu kalah ronde dan 3 pemain punya $3000, 2 lainnya $5500. Apa yang harus dilakukan?', 'opts' => ['Semua full buy', '2 pemain kaya drop senjata, sisanya beli armor + utility', 'Semua eco', 'Force buy semua'], 'ans' => 1, 'ex' => 'Drop senjata dari pemain kaya bikin tim tetap kompetitif tanpa mengorbankan ekonomi.'],
                    ]],
                ],
            ],
            [
                'icon' => '🧪', 'title' => 'Utility Usage', 'level' => 'Menengah', 'durasi' => '1 jam',
                'type' => 'Kursus Wajib', 'is_popular' => false,
                'body' => 'Utility adalah senjata kedua di CS2. Pelajari kapan throw smoke, cara bounce flash agar musuh tidak bisa dodge, dan penggunaan molotov untuk area denial.',
                'modules' => [
                    ['title' => 'Smoke Fundamentals', 'body' => "Fungsi utama smoke grenade di CS2\nMemblok line of sight dan area tertentu\nPerbedaan smoke defensif vs ofensif", 'quizzes' => [
                        ['q' => 'Apa fungsi utama smoke grenade?', 'opts' => ['Meracuni musuh', 'Memblok line of sight dan area tertentu', 'Dekorasi map', 'Slow musuh'], 'ans' => 1, 'ex' => 'Smoke memblok pandangan, menutup angle berbahaya.'],
                    ]],
                    ['title' => 'Flash Techniques', 'body' => "Flash yang efektif — pop flash vs bounce flash\nCara bounce dari dinding agar musuh tak bisa menghindar\nHindari nge-flash teman sendiri (team flash)", 'quizzes' => [
                        ['q' => 'Flash yang efektif adalah yang...', 'opts' => ['Langsung ke muka musuh', 'Bounce dari dinding agar musuh tak bisa menghindar', 'Dilempar ke langit', 'Dipakai saat ada teman di depan'], 'ans' => 1, 'ex' => 'Pop flash atau bounce flash muncul mendadak sehingga musuh tidak sempat berbalik.'],
                    ]],
                    ['title' => 'Molotov & Area Denial', 'body' => "Kapan molotov paling efektif\nMembakar choke point dan spot favorit musuh\nKombinasi molotov + smoke untuk area denial total", 'quizzes' => [
                        ['q' => 'Kapan molotov paling efektif?', 'opts' => ['Dilempar ke langit', 'Membakar choke point dan spot favorit musuh', 'Membakar senjata drop', 'Peluru terakhir'], 'ans' => 1, 'ex' => 'Molotov efektif memaksa musuh keluar dari pojok atau menunda push.'],
                    ]],
                    ['title' => 'Kuis Akhir: Utility Usage', 'body' => "Rangkuman Smoke, Flash, dan Molotov\nSelesaikan untuk membuka kursus berikutnya", 'quizzes' => [
                        ['q' => 'Di situasi 1v1 post-plant sebagai CT, utility apa yang paling krusial?', 'opts' => ['Semua smoke dipakai sekaligus', 'Flash + molotov untuk delay defuser', 'Hanya mengandalkan aim', 'Utility tidak penting di 1v1'], 'ans' => 1, 'ex' => 'Flash dan molotov bisa delay defuser cukup lama untuk memenangkan ronde.'],
                    ]],
                ],
            ],
            [
                'icon' => '🧠', 'title' => 'Game Sense', 'level' => 'Lanjutan', 'durasi' => '1.5 jam',
                'type' => 'Kursus Lanjutan', 'is_popular' => true,
                'body' => 'Game sense membedakan pemain biasa dari pemain hebat — kemampuan memprediksi situasi tanpa melihat musuh. Pelajari cara membaca informasi dan membuat keputusan terbaik.',
                'modules' => [
                    ['title' => 'Reading the Enemy', 'body' => "Apa inti dari game sense di CS2\nMemprediksi posisi dan keputusan musuh dari info yang ada\nPola permainan musuh dan cara membacanya", 'quizzes' => [
                        ['q' => 'Apa inti dari "game sense" di CS2?', 'opts' => ['Aim tinggi', 'Memprediksi posisi dan keputusan musuh dari info yang ada', 'Hafal semua callout', 'Main banyak jam saja'], 'ans' => 1, 'ex' => 'Game sense = membaca situasi berdasarkan economy, info tim, dan logika permainan.'],
                    ]],
                    ['title' => 'Adaptasi & Rotasi', 'body' => "Saat satu teammate mati — evaluasi ulang strategi\nKapan harus agresif vs pasif\nRotasi cepat dan efektif berdasarkan info", 'quizzes' => [
                        ['q' => 'Saat satu teammate mati di awal ronde, apa yang harus dilakukan?', 'opts' => ['Panik dan rush dendam', 'Evaluasi ulang — adaptasi strategi, lebih safe atau rotasi', 'Langsung surrender', 'Diam di spawn'], 'ans' => 1, 'ex' => 'Kehilangan satu pemain mengubah keseimbangan. Segera adaptasi strategi.'],
                    ]],
                    ['title' => 'Timing & Decision Making', 'body' => "Cara membaca timing rotasi musuh\nDengar footstep, perhatikan economy & info dari tim\nKeputusan di bawah tekanan: kapan push, kapan hold", 'quizzes' => [
                        ['q' => 'Cara membaca timing rotasi musuh yang benar adalah...', 'opts' => ['Tebak-tebakan', 'Dengar footstep, perhatikan economy & info dari tim', 'Ikut feeling', 'Selalu rush A'], 'ans' => 1, 'ex' => 'Rotasi dibaca dari footstep, economy musuh, dan komunikasi aktif.'],
                    ]],
                    ['title' => 'Kuis Akhir: Game Sense', 'body' => "Rangkuman Reading, Adaptasi, dan Decision Making\nKamu udah menyelesaikan seluruh kursus CS2 Academy!", 'quizzes' => [
                        ['q' => 'Kamu lihat 3 musuh terdeteksi di A dan bomb dibawa oleh pemain ke-4 yang belum terlihat. Keputusan terbaik sebagai rotator dari B:', 'opts' => ['Tetap di B karena takut fake', 'Langsung sprint ke A tanpa info', 'Komunikasikan ke tim, minta info bomb, lalu rotasi lewat jalur aman', 'Save senjata'], 'ans' => 2, 'ex' => 'Komunikasi + rotasi lewat jalur aman = tiba tepat waktu tanpa risiko dibunuh dari belakang.'],
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

            foreach ($d['modules'] as $mi => $mod) {
                $module = Module::create([
                    'course_id' => $course->id,
                    'title'     => $mod['title'],
                    'body'      => $mod['body'],
                    'urutan'    => $mi,
                ]);

                foreach ($mod['quizzes'] as $q) {
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
