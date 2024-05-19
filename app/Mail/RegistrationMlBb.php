<?php

namespace App\Mail;

use App\Models\PendaftarEsport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationMlBb extends Mailable
{
    use Queueable, SerializesModels;
    
    public $pendaftar;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PendaftarEsport $pendaftar)
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
        $personils = $this->pendaftar->pesertaEsports;

        return $this->view('emails.registration_mlbb')
                ->with([
                    'no_registrasi' => $this->pendaftar->no_registrasi,
                    'tanggal_pendaftaran' => $this->pendaftar->tanggal_daftar,
                    'nama_kelompok' => $this->pendaftar->nama_kelompok,
                    'personils' => $personils,
                ])
                ->subject('Konfirmasi Pendaftaran MLBB');
    }
}
