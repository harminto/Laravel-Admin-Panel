@if ($menu->children->isNotEmpty())
    <ul>
        @foreach ($menu->children as $child)
            <li>
                <label>
                    <input type="checkbox" name="menu_ids[]" value="{{ $child->id }}" {{ $role->menus->contains('id', $child->id) ? 'checked' : '' }}>
                    {{ $child->title }}
                </label>
                @include('backend.hak-akses.menu-child', ['menu' => $child, 'role' => $role])
            </li>
        @endforeach
    </ul>
@endif
