<?php

namespace App\Mail;

use App\Models\PesertaBazar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationBazar extends Mailable
{
    use Queueable, SerializesModels;
    
    public $pendaftar;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PesertaBazar $pendaftar)
    {
        $this->pendaftar = $pendaftar;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.registration_bazar')
                ->with([
                    'no_registrasi' => $this->pendaftar->no_registrasi,
                    'tanggal_daftar' => $this->pendaftar->tanggal_daftar,
                    'nama_peserta' => $this->pendaftar->nama_peserta,                    
                    'nama_usaha' => $this->pendaftar->nama_usaha,
                    'jenis_usaha' => $this->pendaftar->jenis_usaha,
                    'no_stand' => $this->pendaftar->no_stand,
                    'no_wa' => $this->pendaftar->no_wa,
                ])
                ->subject('Konfirmasi Pendaftaran Bazar UMKM');
    }
}
