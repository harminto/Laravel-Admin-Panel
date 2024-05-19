<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pendaftaran Festival Musik</title>
</head>
<body>
    <h2>Konfirmasi Pendaftaran Festival Musik</h2>
    <p>Nomor Registrasi: {{ $no_registrasi }}</p>
    <p>Tanggal Pendaftaran: {{ $tanggal_pendaftaran }}</p>
    <p>Nama Kelompok: {{ $nama_kelompok }}</p>

    <!-- Tampilkan informasi personil -->
    @foreach ($personils as $personil)
        <p>Nama Peserta: {{ $personil->nama_peserta }}</p>
        <p>No WA: {{ $personil->no_wa }}</p>
        <p>Asal Sekolah: {{ $personil->asal_sekolah }}</p>
    @endforeach

    <p>Silahkan melakukan pembayaran dengan men-transfer biaya kepesertaan <b>Rp. 100.000,-</b> ke nomer rekening <b>BNI : 1344077088 a.n Ike Istanti</b></p>
</body>
</html>
