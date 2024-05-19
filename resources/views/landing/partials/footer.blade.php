<section class="footer">
    <div class="box-container">
        <div class="box">
            <h3>quick link</h3>
            <a href="{{ route('beranda') }}#home"><i class="fas fa-arrow-right"></i> Home</a>
            <a href="{{ route('beranda') }}#timeline"><i class="fas fa-arrow-right"></i> Timeline</a>
            <a href="{{ route('beranda') }}#artikel"><i class="fas fa-arrow-right"></i> News</a>
            {{-- <a href="{{ route('beranda') }}#gallery"><i class="fas fa-arrow-right"></i> Galeri Prodi</a> --}}
            <a href="{{ route('beranda') }}#price"><i class="fas fa-arrow-right"></i> Unggulan</a>
            <a href="{{ route('beranda') }}#review"><i class="fas fa-arrow-right"></i> Sponsorship</a>
            <a href="{{ route('beranda') }}#contact"><i class="fas fa-arrow-right"></i> Hubungi Kami</a>
        </div>
        <div class="box">
            <h3>contact info</h3>
            <a href="#"><i class="fa-brands fa-whatsapp"></i> {{ \App\Models\AppSetting::where('setting_key', 'app_contact1')->value('setting_value') }}</a>
            <a href="#"><i class="fa-brands fa-whatsapp"></i> {{ \App\Models\AppSetting::where('setting_key', 'app_contact2')->value('setting_value') }}</a>
            <a href="#"><i class="fas fa-envelope"></i>  {{ \App\Models\AppSetting::where('setting_key', 'app_mail')->value('setting_value') }}</a>
            <a href="#"><i class="fas fa-map-marker-alt"></i> {{ \App\Models\AppSetting::where('setting_key', 'app_alamat')->value('setting_value') }}</a>
        </div>
        <div class="box">
            <h3>follow us</h3>
            <a href="{{ \App\Models\AppSetting::where('setting_key', 'app_fb')->value('setting_value') }}"><i class="fab fa-facebook-f"></i> facebook</a>
            <a href="{{ \App\Models\AppSetting::where('setting_key', 'app_twitter')->value('setting_value') }}"><i class="fab fa-twitter"></i> twitter</a>
            <a href="{{ \App\Models\AppSetting::where('setting_key', 'app_ig')->value('setting_value') }}"><i class="fab fa-instagram"></i> instagram</a>
            <a href="{{ \App\Models\AppSetting::where('setting_key', 'app_linkedin')->value('setting_value') }}"><i class="fab fa-linkedin"></i> linkedin</a>
            <a href="{{ \App\Models\AppSetting::where('setting_key', 'app_yt')->value('setting_value') }}"><i class="fab fa-youtube"></i> youtube</a>
        </div>
    </div>
    <div class="credit">created by <span>Harminto Mulyo</span> | all right reserved!</div>
</section>

<style>
/* Telegram icon */
.telegram-icon {
  width: 50px;
  height: 50px;
  cursor: pointer;
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 9999;
  /* Tambahkan bayangan */
  box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 0.5);
  border-radius: 50%; /* Membuat ikon bulat */
}

/* The popup chat - hidden by default */
.telegram-popup {
  display: none;
  position: fixed;
  bottom: 80px;
  right: 20px;
  border: 3px solid #f1f1f1;
  z-index: 9998;
}

/* Add styles to the form container */
.telegram-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}

/* Full-width textarea */
.telegram-container textarea {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
  resize: none;
  min-height: 200px;
}

/* When the textarea gets focus, do something */
.telegram-container textarea:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/send button */
.telegram-container .btn {
  background-color: #04AA6D;
  color: white;
  padding: 8px 10px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom: 10px;
  opacity: 0.8;
}

/* Add some hover effects to buttons */
.telegram-container .btn:hover, .telegram-icon:hover {
  opacity: 1;
}
</style>

<img class="telegram-icon" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/82/Telegram_logo.svg/1024px-Telegram_logo.svg.png" alt="Telegram Icon" onclick="toggleForm()">

<div class="telegram-popup" id="telegramForm">
  <form action="" class="telegram-container">
    <h1>Chat</h1>

    <label for="msg"><b>Message</b></label>
    <textarea placeholder="Type message.." name="msg" required></textarea>

    <button type="submit" class="btn">Send</button>
  </form>
</div>

<script>
function toggleForm() {
  var form = document.getElementById("telegramForm");
  if (form.style.display === "block") {
    form.style.display = "none";
  } else {
    form.style.display = "block";
  }
}
</script>
