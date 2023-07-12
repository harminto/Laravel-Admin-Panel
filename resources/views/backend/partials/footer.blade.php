<div class="pull-right hidden-xs">
    <b>{{ \App\Models\AppSetting::where('setting_key', 'system_name')->value('setting_value') }}</b> v.{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
</div>
<strong>Copyright &copy; 2023-2026 <a href="https://unisnu.ac.id">Minto`s Prod</a>.</strong> All rights reserved.