<?php

namespace App\Mail;

use App\Models\PendaftaranPhotografi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationPhotografi extends Mailable
{
    use Queueable, SerializesModels;
    
    public $pendaftar;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PendaftaranPhotografi $pendaftar)
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
        return $this->view('emails.registration_photografi')
                ->with([
                    'no_registrasi' => $this->pendaftar->no_registrasi,
                    'nama_peserta' => $this->pendaftar->nama_peserta,
                    'no_wa' => $this->pendaftar->no_wa,                    
                    'asal_sekolah' => $this->pendaftar->asal_sekolah,
                    'email' => $this->pendaftar->email,
                ])
                ->subject('Konfirmasi Pendaftaran Photografi Competition');
    }
}
