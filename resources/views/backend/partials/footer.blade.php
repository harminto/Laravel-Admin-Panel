<div class="footer-left">
    <i class="blockquote-footer">{{ \App\Models\AppSetting::where('setting_key', 'short_name')->value('setting_value') }} v.{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    Copyright &copy; 2024-2026 <div class="bullet"></div> Design By <a href="https://tif.unisnu.ac.id">Harminto Mulyo</a></i>
</div>