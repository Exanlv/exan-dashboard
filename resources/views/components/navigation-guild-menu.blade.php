<div class="btn-group">
    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ $avatarUrl }}" style="vertical-align: middle; margin-right: 1rem;" height="30" />
        <span style="vertical-align: middle; margin-right: 1rem;">{{ $username }}</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end" style="margin-top: 1rem">
        <li><button class="dropdown-item" type="button">My data</button></li>
        <li>
            <hr class="dropdown-divider">
        </li>

        @foreach ($guilds as $guild)
        <li>
            <button class="dropdown-item" type="button">
                <img src="{{ $guild->icon ? 'https://cdn.discordapp.com/icons/' . $guild->id . '/' . $guild->icon . '.webp?size=128' : asset('images/unknown.png') }}" style="vertical-align: middle; margin-right: 1rem;" height="30" />
                <span style="vertical-align: middle; margin-right: 1rem;">{{ $guild->name }}</span>
            </button>
        </li>
        @endforeach
    </ul>
</div>