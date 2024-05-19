<?php

namespace App\Mail;

use App\Models\PendaftarBand;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    
    public $pendaftar;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PendaftarBand $pendaftar)
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
        $personils = $this->pendaftar->pesertaBand;

        return $this->view('emails.registration_confirmation')
                ->with([
                    'no_registrasi' => $this->pendaftar->no_registrasi,
                    'tanggal_pendaftaran' => $this->pendaftar->tanggal_daftar,
                    'nama_kelompok' => $this->pendaftar->nama_kelompok,
                    'personils' => $personils,
                ])
                ->subject('Konfirmasi Pendaftaran Festival Musik');
    }
}
