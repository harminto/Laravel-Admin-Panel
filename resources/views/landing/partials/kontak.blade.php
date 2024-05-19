@if(session('success'))
    <div class="notification success">
        <p>{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="notification error">
        <p>{{ session('error') }}</p>
    </div>
@endif
<section class="contact" id="contact">
    <h1 class="heading"><span>Hubungi</span> Kami</h1>
    <div class="box-container">
        <div class="box">
            <form action="{{ route('submit.contact') }}" method="POST">
                @csrf
                <div class="inputBox">
                    <input type="text" name="nama" id="" placeholder="nama anda" required>
                    <input type="email" name="email" id="" placeholder="email" required>
                </div>
                <div class="inputBox">
                    <input type="number" name="wa" id="" placeholder="nomor tlp atau wa" required>
                    <input type="text" name="perihal" id="" placeholder="Perihal" required>
                </div>
                <div class="inputBox">
                    <div class="captcha-input">
                        <img src="{{ route('captcha') }}" alt="Captcha">
                        <input type="text" name="captcha" placeholder="Masukkan kode captcha di sini" required>
                    </div>
                </div>
                <div class="inputBox">
                    <textarea name="pesan" placeholder="Pesan anda" id="" cols="30" rows="10" required></textarea>
                </div>
                <input type="submit" value="Kirim" class="btn">
            </form>
        </div>
    </div>
</section>