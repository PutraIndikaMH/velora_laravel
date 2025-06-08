<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Analyzed History</title>
</head>
@include('template.historyStyle')

<body>
    <header>
        <a href="/">
            <img class="icon-btn" src="icons/left-arrow-alt-svgrepo-com.svg" alt="">
        </a>

        <h1>Analyzed History</h1>

        <a href="{{ route('edit_profile', $user->id) }}"
            style="text-decoration: none; display: flex; align-items: center;">
            <img class="icon-btn" src="icons/user-avatar-filled-alt-svgrepo-com.svg" alt="">
            <span class="edit-profile-text">Edit Profile</span>
        </a>
    </header>

    <main>
        <p class="subheading">Recent history</p>
        @if ($history->isEmpty())
        <p class="message">No scan history found. Please perform a scan.</p>
        @else
        <div class="history-grid">
            @foreach ($history as $item)
            <div class="history-card" style="position: relative;">
            <img src="{{ asset('storage/scans/' . basename($item->image_path)) }}" class="avatar hair1"
                alt="">
            <a href="{{ route('scan', ['history_id' => $item->id]) }}">
                <div class="analysis-info">
                <span class="analysis-text">Hasil Analisis: {{ $item->skin_type }}</span>
                <span class="arrow">→</span>
                </div>
            </a>
            <div class="analysis-date">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
            <form action="{{ route('history.delete', $item->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this history item?')"
                style="position: absolute; top: 10px; right: 10px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn"
                style="background: none; border: none; cursor: pointer; padding: 0;">
                <img src="icons/red-trash-can-icon.svg" alt="Delete" style="width: 20px; height: 20px;">
                </button>
            </form>
            </div>
            @endforeach
        </div>
        @endif
        </div>
    </main>
</body>

</html>