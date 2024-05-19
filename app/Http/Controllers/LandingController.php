<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\CompetitionType;
use App\Models\Contact;
use App\Models\LaguWajib;
use App\Models\PendaftarBand;
use App\Models\PesertaBand;
use App\Models\Post;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;
use App\Mail\RegistrationBazar;
use App\Models\AppSetting;
use App\Models\Sponsorship;
use App\Mail\RegistrationConfirmation;
use App\Mail\RegistrationMlBb;
use App\Models\PendaftaranPhotografi;
use App\Models\PendaftaranSim;
use App\Models\PendaftarEsport;
use App\Models\PesertaBazar;
use App\Models\PesertaEsport;

class LandingController extends Controller
{
    public function index()
    {
        $agendas = Agenda::all();
        $latestPosts = Post::latest()->take(2)->get();
        $timelines = Timeline::all();
        $competitionTypes = CompetitionType::all();
        $sponsorships = Sponsorship::all();

        $shortName = AppSetting::where('setting_key', 'short_name')->value('setting_value');
        $ogTitle = $shortName . " :: Evolusi Teknologi: Kreasi, Inovasi dan Kearifan Lokal";
        $ogDescription = 'Menyajikan serangkaian acara berbasis sains dan teknologi yang menginspirasi serta memberdayakan siswa SLTA, UMKM dan komunitas akademik dilingkungan Fakultas Sains dan Teknologi pada Khsusnya dan sivitas akademika UNISNU Jepara pada Umumnya';

        return view('landing.page.index', compact('agendas', 'latestPosts', 'timelines', 'competitionTypes', 'sponsorships', 'ogTitle', 'ogDescription'));
    }

    public function artikel()
    {
        $shortName = AppSetting::where('setting_key', 'short_name')->value('setting_value');
        $ogTitle = $shortName . " :: Informasi Artikel Terbaru";
        $ogDescription = 'Temukan informasi terbaru mengenai sains, teknologi, dan berita terkini seputar Fakultas Sains dan Teknologi UNISNU Jepara.';

        $artikel = Post::get();
        return view('landing.page.artikels', compact('artikel', 'ogTitle', 'ogDescription'));
    }

    public function detilArtikel($slug)
    {
        $artikelDetail = Post::where('slug', $slug)->firstOrFail();

        $shortName = AppSetting::where('setting_key', 'short_name')->value('setting_value');
        $ogTitle = $artikelDetail->post_title;
        $ogDescription = $artikelDetail->post_excerpt;

        return view('landing.page.detail-artikel', compact('artikelDetail', 'ogTitle', 'ogDescription'));
    }

    public function timelines()
    {
        $shortName = AppSetting::where('setting_key', 'short_name')->value('setting_value');
        $ogTitle = $shortName . " :: Saintek Expo - Serangkaian Acara";
        $ogDescription = "Rangkaian acara dalam Saintek Expo menampilkan berbagai kegiatan menarik yang berfokus pada sains dan teknologi.";

        $timelines = Timeline::get();
        return view('landing.page.timelines', compact('timelines', 'ogTitle', 'ogDescription'));
    }

    public function unggulans($slug)
    {
        $competitionTypes = CompetitionType::where('slug', $slug)->firstOrFail();
        $laguWajibs = LaguWajib::all();

        $shortName = AppSetting::where('setting_key', 'short_name')->value('setting_value');
        $ogTitle = $shortName . " :: Unggulan Saintek Expo";
        $ogDescription = "Bagian unggulan dalam Saintek Expo: Bazar UMKM, Festival Musik, Kompetisi Esport Mobile Legends, Fasilitasi SIM Masal.";

        return view('landing.page.detail-unggulan', compact('competitionTypes', 'laguWajibs', 'ogTitle', 'ogDescription'));
    }

    public function prosesDaftarFes(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required',
            'email_kelompok' => 'required',
            'lagu_wajib_id' => 'required',
            'lagu_pilihan' => 'required',
            'nama_peserta.*' => 'required',
            'no_wa.*' => 'required',
            'kartu_pelajar.*' => 'required|mimes:pdf,jpg,png',
            'asal_sekolah.*' => 'required',
        ], [
            'nama_peserta.*.required' => 'Nama peserta harus diisi.',
            'no_wa.*.required' => 'Nomor WA harus diisi.',
            'kartu_pelajar.*.required' => 'Kartu pelajar harus diunggah (format: PDF/JPG/PNG).',
            'asal_sekolah.*.required' => 'Asal sekolah harus diisi.',
        ]);

        DB::beginTransaction();
        try {
            // Simpan ke model pendaftar_bands
            $pendaftar = PendaftarBand::create([
                'competition_types_id' => $request->competition_types_id,
                'no_registrasi' => 'EXPO-FST.FEST.' . strtoupper(substr(uniqid(), 8, 6)),
                'nama_kelompok' => $request->nama_kelompok,
                'email_kelompok' => $request->email_kelompok,
                'tanggal_daftar' => date('Y-m-d'),
                'lagu_wajib_id' => $request->lagu_wajib_id,
                'lagu_pilihan' => $request->lagu_pilihan,
            ]);

            // Pastikan semua array memiliki panjang yang sama
            $jumlahPeserta = count($request->nama_peserta);
            if (
                $jumlahPeserta === count($request->no_wa) &&
                $jumlahPeserta === count($request->kartu_pelajar) &&
                $jumlahPeserta === count($request->asal_sekolah)
            ) {
                // Proses penyimpanan peserta
                for ($key = 0; $key < $jumlahPeserta; $key++) {
                    $kartuPelajarFile = $request->file('kartu_pelajar')[$key];
                    $fileName = uniqid() . '_' . $kartuPelajarFile->getClientOriginalName();
                    $kartuPelajarFile->move(public_path('../../public_html/peserta_identitas'), $fileName);
    
                    $peserta = PesertaBand::create([
                        'nama_peserta' => $request->nama_peserta[$key],
                        'no_wa' => $request->no_wa[$key],
                        'kartu_pelajar' => $fileName,
                        'asal_sekolah' => $request->asal_sekolah[$key],
                        'pendaftar_band_id' => $pendaftar->id,
                    ]);
                }
            }

            // Kirim email konfirmasi pendaftaran
            // Mail::to($request->email_kelompok)->send(new RegistrationConfirmation($pendaftar));
            
            // Kirim pesan ke bot Telegram
            $message = "Pendaftaran baru pada Festival Musik:\nKelompok: {$request->nama_kelompok}\nEmail: {$request->email_kelompok}\n";

            foreach ($request->no_wa as $no_wa) {
                $message .= "WA: $no_wa\n";
            }

            $telegramController = new TelegramController();
            $telegramController->sendMessage($message);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Informasi pendaftaran berhasil dikirim']);
            //return redirect()->back()->with('success', 'Informasi pendaftaran berhasil dikirim');
        } catch (\Exception $e) {
            DB::rollback();
            //dd($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.']);
            //return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function prosesDaftarEspr(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required',
            'email_kelompok' => 'required',
            'nama_peserta.*' => 'required',
            'nickname.*' => 'required',
            'no_wa.*' => 'required',
            'kartu_pelajar.*' => 'required|mimes:pdf,jpg,png',
            'asal_sekolah.*' => 'required',
        ], [
            'nama_peserta.*.required' => 'Nama peserta harus diisi.',
            'nickname.*.required' => 'Nickname peserta harus diisi.',
            'no_wa.*.required' => 'Nomor WA harus diisi.',
            'kartu_pelajar.*.required' => 'Kartu pelajar harus diunggah (format: PDF/JPG/PNG).',
            'asal_sekolah.*.required' => 'Asal sekolah harus diisi.',
        ]);

        DB::beginTransaction();
        try {
            // Simpan ke model PendaftarEsport
            $pendaftar = PendaftarEsport::create([
                'competition_types_id' => $request->competition_types_id,
                'no_registrasi' => 'EXPO-FST.MLBB.' . strtoupper(substr(uniqid(), 8, 6)),
                'nama_kelompok' => $request->nama_kelompok,
                'email_kelompok' => $request->email_kelompok,
                'tanggal_daftar' => date('Y-m-d'),
            ]);

            // Pastikan semua array memiliki panjang yang sama
            $jumlahPeserta = count($request->nama_peserta);
            if (
                $jumlahPeserta === count($request->no_wa) &&
                $jumlahPeserta === count($request->kartu_pelajar) &&
                $jumlahPeserta === count($request->nickname) &&
                $jumlahPeserta === count($request->asal_sekolah)
            ) {
                // Proses penyimpanan peserta
                for ($key = 0; $key < $jumlahPeserta; $key++) {
                    $kartuPelajarFile = $request->file('kartu_pelajar')[$key];
                    $fileName = uniqid() . '_' . $kartuPelajarFile->getClientOriginalName();
                    $kartuPelajarFile->move(public_path('../../public_html/peserta_identitas'), $fileName);
    
                    $peserta = PesertaEsport::create([
                        'nama_peserta' => $request->nama_peserta[$key],
                        'nickname' => $request->nickname[$key],
                        'no_wa' => $request->no_wa[$key],
                        'kartu_pelajar' => $fileName,
                        'asal_sekolah' => $request->asal_sekolah[$key],
                        'pendaftar_esport_id' => $pendaftar->id,
                    ]);
                }
            }

            // Kirim email konfirmasi pendaftaran
            // Mail::to($request->email_kelompok)->send(new RegistrationMlBb($pendaftar));

            // Kirim pesan ke bot Telegram
            $message = "Pendaftaran baru pada turnamen Esport:\nKelompok: {$request->nama_kelompok}\nEmail: {$request->email_kelompok}\n";

            foreach ($request->no_wa as $no_wa) {
                $message .= "WA: $no_wa\n";
            }

            $telegramController = new TelegramController();
            $telegramController->sendMessage($message);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Informasi pendaftaran berhasil dikirim']);
        } catch (\Exception $e) {
            DB::rollback();
            //dd($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    public function prosesDaftarBazar(Request $request)
    {
        $request->validate([
            'nama_peserta' => 'required',
            'email_peserta' => 'required',
            'nama_usaha' => 'required',
            'jenis_usaha' => 'required',
            'no_stand' => 'required',
            'no_wa' => 'required',
            'kartu_identitas' => 'required|mimes:pdf,jpg,png',
        ]);

        DB::beginTransaction();
        try {
            // Simpan ke model PendaftarEsport
            $data = [
                'competition_types_id' => $request->competition_types_id,
                'no_registrasi' => 'EXPO-FST.BAZR.' . strtoupper(substr(uniqid(), 8, 6)),
                'nama_peserta' => $request->nama_peserta,
                'email_peserta' => $request->email_peserta,
                'nama_usaha' => $request->nama_usaha,
                'jenis_usaha' => $request->jenis_usaha,
                'no_stand' => $request->no_stand,
                'no_wa' => $request->no_wa,
                'tanggal_daftar' => date('Y-m-d'),
            ];

            if ($request->hasFile('kartu_identitas')) {
                $file = $request->file('kartu_identitas');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('../../public_html/peserta_identitas'), $fileName);
                $data['kartu_identitas'] = $fileName;
            }
            $pendaftar = PesertaBazar::create($data);

            // Kirim email konfirmasi pendaftaran
            // Mail::to($request->email_peserta)->send(new RegistrationBazar($pendaftar));
            
            // Kirim pesan ke bot Telegram menggunakan TelegramController
            $message = "Nama: {$request->nama_peserta}\nEmail: {$request->email_peserta}\nWA: {$request->no_wa}\nNama Usaha: {$request->nama_usaha}\nJenis Usaha: {$request->jenis_usaha}\nPesan: Pendaftaran baru pada Bazar.";

            $telegramController = new TelegramController();
            $telegramController->sendMessage($message);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Informasi pendaftaran berhasil dikirim']);
        } catch (\Exception $e) {
            DB::rollback();
            //dd($e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function prosesDaftarSim(Request $request)
    {
        $request->validate([
            'nomor_nik' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'no_wa' => 'required',
            'jenis_sim' => 'required|in:A,C',
            'competition_types_id' => 'required|exists:competition_types,id',
        ]);

        // Validasi tambahan untuk memeriksa apakah nomor NIK dan jenis SIM sudah terdaftar sebelumnya
        $isDuplicate = PendaftaranSim::where('nomor_nik', $request->nomor_nik)->where('jenis_sim', $request->jenis_sim)->exists();

        if ($isDuplicate) {
            return response()->json(['success' => false, 'message' => 'NIK dan jenis SIM sudah terdaftar sebelumnya.'], 422);
        }

        DB::beginTransaction();
        try {
            $data = [
                'competition_types_id' => $request->competition_types_id,
                'nomor_nik' => $request->nomor_nik,
                'nama' => $request->nama,
                'no_wa' => $request->no_wa,
                'alamat' => $request->alamat,
                'jenis_sim' => $request->jenis_sim,
            ];

            $pendaftaranSim = PendaftaranSim::create($data);

            // Kirim pesan ke bot Telegram menggunakan TelegramController
            $message = "NIK: {$request->nomor_nik}\nNama: {$request->nama}\nWA: {$request->no_wa}\nJenis SIM: {$request->jenis_sim}\nPesan: Pendaftaran baru pada SIM Kolektif.";

            $telegramController = new TelegramController();
            $telegramController->sendMessage($message);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Informasi pendaftaran berhasil dikirim']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function prosesDaftarPhotografy(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi request
            $request->validate([
                'competition_types_id' => 'required|exists:competition_types,id',
                'nama_peserta' => 'required|string|max:255',
                'no_wa' => 'required|string|max:18',
                'asal_sekolah' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'kartu_pelajar' => 'required|file|mimes:pdf,jpg,png',
            ]);

            $data = [
                'competition_types_id' => $request->competition_types_id,
                'no_registrasi' => 'EXPO-FST.PHOT.' . strtoupper(substr(uniqid(), 8, 6)),
                'nama_peserta' => $request->nama_peserta,
                'no_wa' => $request->no_wa,
                'asal_sekolah' => $request->asal_sekolah,
                'email' => $request->email,
            ];

            // Upload file kartu pelajar
            if ($request->hasFile('kartu_pelajar')) {
                $file = $request->file('kartu_pelajar');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('kartu_pelajar'), $fileName);
                $data['kartu_pelajar'] = $fileName;
            }
            
            $pendaftaranPhotografy = PendaftaranPhotografi::create($data);

            // Kirim pesan ke bot Telegram menggunakan TelegramController
            $message = "No Registrasi: {$pendaftaranPhotografy->no_registrasi}\nNama Peserta: {$pendaftaranPhotografy->nama_peserta}\nWA: {$pendaftaranPhotografy->no_wa}\nAsal Sekolah: {$pendaftaranPhotografy->asal_sekolah}\nEmail: {$pendaftaranPhotografy->email}\n\nPesan: Pendaftaran baru pada Lomba Photografi";

            $telegramController = new TelegramController();
            $telegramController->sendMessage($message);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Informasi pendaftaran berhasil dikirim']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function submitContact(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'wa' => 'required|string|max:20',
            'perihal' => 'required|string|max:255',
            'captcha' => ['required', function ($attribute, $value, $fail) use ($request) {
                if ($value !== $request->session()->get('captcha')) {
                    return $fail('Captcha tidak valid.');
                }
            }],
            'pesan' => 'required|string',
        ]);

        $contact = Contact::create($validatedData);
        Mail::to($request->email)->send(new ContactNotification($contact));

        // Kirim pesan ke bot Telegram menggunakan TelegramController
        $message = "Nama: {$validatedData['nama']}\nEmail: {$validatedData['email']}\nWA: {$validatedData['wa']}\nPerihal: {$validatedData['perihal']}\nPesan: {$validatedData['pesan']}";

        $telegramController = new TelegramController();
        $telegramController->sendMessage($message);

        // Beri respon atau lakukan aksi lainnya sesuai kebutuhan
        $request->session()->flash('success', 'Pesan berhasil dikirim!');
        return redirect()->back();
    }

    public function captcha()
    {
        $randomString = Str::random(6);
        session(['captcha' => $randomString]);

        $img = Image::canvas(120, 36, '#f2f2f2');
        $img->text($randomString, 60, 18, function($font) {
            $font->file(public_path('assets/backend/stisla/fonts/nunito-v9-latin-600.ttf')); // Ganti dengan path font Anda
            $font->size(20);
            $font->color('#000');
            $font->align('center');
            $font->valign('middle');
        });

        return $img->response('jpg');
    }
}
