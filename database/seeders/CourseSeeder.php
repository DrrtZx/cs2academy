<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Quiz;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['icon'=>'🎯','title'=>'Aim & Movement','body'=>'Aim yang konsisten adalah fondasi utama CS2. Di modul ini kamu akan belajar crosshair placement yang benar, teknik counter-strafing untuk berhenti sebelum tembak, dan dasar-dasar spray control untuk senjata populer seperti AK-47 dan M4A4.',
             'quiz'=>[
               ['q'=>'Apa yang dimaksud crosshair placement yang baik?','opts'=>['Arahkan ke tanah selalu','Jaga setinggi kepala musuh','Gerakkan secepat mungkin','Selalu spray penuh'],'ans'=>1,'ex'=>'Crosshair di level kepala musuh meminimalkan adjustment saat peek.'],
               ['q'=>'Untuk spray control AK-47, apa yang harus dilakukan?','opts'=>['Gerakan mouse ke atas','Tarik mouse ke bawah lalu kompensasi ke kiri','Berhenti tembak setiap 3 peluru','Tidak perlu kompensasi'],'ans'=>1,'ex'=>'Recoil AK-47 membentuk pola naik-kanan. Counter: tarik mouse ke bawah lalu sedikit ke kiri.'],
               ['q'=>'Kapan flick shot paling efektif?','opts'=>['Selalu digunakan tiap ronde','Saat musuh muncul tiba-tiba di sudut tak terduga','Sambil berjalan','Saat reload senjata'],'ans'=>1,'ex'=>'Flick cocok untuk situasi reaktif mendadak.'],
             ]],
            ['icon'=>'🗺','title'=>'Map Control','body'=>'Map control adalah tentang menguasai area kunci sebelum musuh. Pelajari konsep early map control, pentingnya mid control di berbagai map, serta kapan harus push vs hold.',
             'quiz'=>[
               ['q'=>'Mengapa mid control penting di Mirage?','opts'=>['Ada banyak senjata drop di sana','Membuka rotasi cepat ke A dan B','Grafisnya bagus','Untuk camping aman'],'ans'=>1,'ex'=>'Menguasai mid membuka akses split-attack ke site A dan B.'],
               ['q'=>'Apa itu "information play"?','opts'=>['Membaca peta mini game','Peek berisiko rendah untuk memancing posisi musuh','Bermain tanpa info','Selalu rush B tiap ronde'],'ans'=>1,'ex'=>'Gerakan kecil untuk mendapat info musuh tanpa risiko besar.'],
               ['q'=>'Apa fungsi smoke dalam map control?','opts'=>['Hanya efek visual','Menutup line of sight agar tim bergerak aman','Meracuni musuh','Tidak berguna di rank rendah'],'ans'=>1,'ex'=>'Smoke memblok pandangan sniper dan musuh.'],
             ]],
            ['icon'=>'💸','title'=>'Economy System','body'=>'Economy CS2 sangat underrated. Pelajari kapan eco, force buy, dan full buy — serta cara koordinasi dengan tim agar semua bisa beli bersamaan di ronde kritis.',
             'quiz'=>[
               ['q'=>'Kapan tepat melakukan eco round?','opts'=>['Selalu ronde pertama','Uang tidak cukup untuk full buy bersama','Musuh terlihat lemah','Setiap ronde genap'],'ans'=>1,'ex'=>'Eco = save untuk full buy ronde berikutnya.'],
               ['q'=>'Pilihan terbaik saat bonus round setelah menang pistol?','opts'=>['Beli rifle langsung','Menabung semua uang','SMG/shotgun cost-efficient','Tetap pakai pistol'],'ans'=>2,'ex'=>'SMG seperti MP9 atau MAC-10 efisien dan memberikan kill reward tinggi.'],
               ['q'=>'Berapa minimum uang untuk full buy ideal?','opts'=>['$1000','$2000','$4000 atau lebih','$500'],'ans'=>2,'ex'=>'Full buy membutuhkan sekitar $4000+ untuk rifle, armor penuh, dan utility dasar.'],
             ]],
            ['icon'=>'💣','title'=>'Utility Usage','body'=>'Utility adalah senjata kedua di CS2. Pelajari kapan throw smoke, cara bounce flash agar musuh tidak bisa dodge, dan penggunaan molotov untuk area denial.',
             'quiz'=>[
               ['q'=>'Apa fungsi utama smoke grenade?','opts'=>['Meracuni musuh','Memblok line of sight dan area tertentu','Dekorasi map','Slow musuh'],'ans'=>1,'ex'=>'Smoke memblok pandangan, menutup angle berbahaya.'],
               ['q'=>'Flash yang efektif adalah yang...','opts'=>['Langsung ke muka musuh','Bounce dari dinding agar musuh tak bisa menghindar','Dilempar ke langit','Dipakai saat ada teman di depan'],'ans'=>1,'ex'=>'Pop flash atau bounce flash muncul mendadak.'],
               ['q'=>'Kapan molotov paling efektif?','opts'=>['Dilempar ke langit','Membakar choke point dan spot favorit musuh','Membakar senjata drop','Peluru terakhir'],'ans'=>1,'ex'=>'Molotov efektif memaksa musuh keluar dari pojok.'],
             ]],
            ['icon'=>'🧠','title'=>'Game Sense','body'=>'Game sense membedakan pemain biasa dari pemain hebat — kemampuan memprediksi situasi tanpa melihat musuh. Pelajari cara membaca informasi dari tim, timing rotasi, dan membuat keputusan terbaik.',
             'quiz'=>[
               ['q'=>'Apa inti dari "game sense" di CS2?','opts'=>['Aim tinggi','Memprediksi posisi dan keputusan musuh dari info yang ada','Hafal semua callout','Main banyak jam saja'],'ans'=>1,'ex'=>'Game sense = membaca situasi berdasarkan economy, info tim, dan logika permainan.'],
               ['q'=>'Saat satu teammate mati di awal ronde, apa yang harus dilakukan?','opts'=>['Panik dan rush dendam','Evaluasi ulang — adaptasi strategi, lebih safe atau rotasi','Langsung surrender','Diam di spawn'],'ans'=>1,'ex'=>'Kehilangan satu pemain mengubah keseimbangan. Segera adaptasi.'],
               ['q'=>'Cara membaca timing rotasi musuh adalah...','opts'=>['Tebak-tebakan','Dengar footstep, perhatikan economy & info dari tim','Ikut feeling','Selalu rush A'],'ans'=>1,'ex'=>'Rotasi dibaca dari footstep, economy musuh, dan komunikasi aktif.'],
             ]],
        ];

        foreach ($data as $i => $d) {
            $course = Course::create(['icon'=>$d['icon'],'title'=>$d['title'],'body'=>$d['body'],'urutan'=>$i]);
            foreach ($d['quiz'] as $q) {
                Quiz::create(['course_id'=>$course->id,'pertanyaan'=>$q['q'],'opsi'=>$q['opts'],'jawaban_benar'=>$q['ans'],'penjelasan'=>$q['ex']]);
            }
        }
    }
}