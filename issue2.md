# Issue #2: Implementasi Fitur Lanjutan EduFlow (Fase 2)

## Deskripsi

Fase 1 telah selesai dengan inisialisasi arsitektur dasar, panel Filament (Admin, Guru, Siswa), pembuatan skema database, dan alur pengerjaan kuis dasar.

Pada Fase 2 ini, kita akan mengimplementasikan fitur-fitur lanjutan sesuai dengan panduan di `SKILL.md`, seperti Papan Peringkat (Leaderboard), pembuatan kuis dengan metode Wizard untuk Guru, fitur unggah video lokal, serta refactoring logika penilaian ke dalam Service tersendiri.

## Daftar Tugas (Task List)

### 1. Refactor Logika Penilaian (QuizService)

- [ ] Buat file `app/Services/QuizService.php`.
- [ ] Pindahkan logika penghitungan skor, akurasi, dan penyimpanan `QuizAttempt` dari komponen Livewire (`TakeQuiz`) ke dalam method `grade(Quiz $quiz, array $answers, User $student)` di `QuizService`.
- [ ] Panggil `QuizService` dari komponen Livewire saat siswa mengumpulkan kuis.

### 2. Fitur Papan Peringkat (Leaderboard) Siswa

- [ ] Buat halaman custom Filament untuk Siswa: `PapanPeringkatPage`.
- [ ] Buat query database untuk menghitung peringkat (aggregate berdasarkan `student_id`: `SUM(score)`, `COUNT(quizzes)`, `AVG(accuracy)`).
- [ ] Tampilkan Top 3 siswa dalam bentuk Widget (Card khusus).
- [ ] Tampilkan daftar lengkap peringkat di bawahnya menggunakan Filament Table.

### 3. Upgrade Form Pembuatan Kuis Guru (Wizard)

- [ ] Modifikasi `CreateQuiz` (dan/atau Edit) di `app/Filament/Guru/Resources/QuizResource/Pages/`.
- [ ] Implementasikan trait `HasWizard`.
- [ ] Bagi proses pembuatan kuis menjadi 3 langkah (Steps):
  1. **Detail Kuis**: Judul, Mata Pelajaran, Deskripsi, Durasi.
  2. **Soal**: (Integrasi dengan RelationManager atau Repeater).
  3. **Tinjau**: Ringkasan sebelum disimpan.

### 4. Halaman Hasil Kuis (Guru)

- [ ] Buat halaman atau resource khusus `HasilPage` di Panel Guru.
- [ ] Tampilkan tabel _read-only_ yang memuat semua riwayat pengerjaan (`QuizAttempt`) dari siswa **hanya** untuk kuis-kuis yang dibuat oleh guru yang sedang login.

### 5. Dukungan Unggah Video Lokal (Video Upload)

- [ ] Buat migrasi untuk menambahkan kolom `type` (`enum: youtube, upload`) pada tabel `videos` (atau sesuaikan jika belum ada).
- [ ] Modifikasi `VideoResource` (Admin & Guru) untuk menambahkan input `Select` tipe video.
- [ ] Tambahkan komponen `FileUpload` yang menyimpannya ke disk `public` direktori `videos`, dan diatur agar hanya muncul jika `type` adalah `upload`.
- [ ] Sesuaikan komponen Blade `video-embed` agar mendukung pemutaran video lokal menggunakan tag `<video>` standar HTML5 jika tipe video adalah `upload`.

## Kriteria Penerimaan (Acceptance Criteria)

- [ ] Penilaian kuis berjalan normal dan terpusat di `QuizService`.
- [ ] Papan Peringkat siswa dapat menampilkan urutan peringkat secara dinamis dengan query yang efisien.
- [ ] Guru dapat membuat kuis menggunakan sistem 3-langkah (Wizard).
- [ ] Guru dapat melihat nilai siswa yang mengerjakan kuis mereka di satu halaman khusus.
- [ ] Guru dapat memilih antara menyisipkan link YouTube/Vimeo atau mengunggah file video lokal (.mp4).
