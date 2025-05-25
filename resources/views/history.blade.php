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
            <img class="icon-btn" src="icons/left-arrow-alt-svgrepo-com.svg" alt="" srcset="">
        </a>

        <h1>Analyzed History</h1>

        <img class="icon-btn" src="icons/user-avatar-filled-alt-svgrepo-com.svg" alt="" srcset="">
    </header>

    <main>
        <p class="subheading">Recent history</p>
        @if ($history->isEmpty())
            <p class="message">No scan history found. Please perform a scan.</p>
        @else
        <div class="history-grid">
                @foreach ($history as $item)
                    <div class="history-card">
                        <img src="{{ asset('storage/scans/' . basename($item->image_path)) }}" class="avatar hair1"
                            alt="">
                        <a href="{{ route('scan', ['history_id' => $item->id]) }}">
                            <div class="analysis-info">
                                <span class="analysis-text">Hasil Analisis: {{ $item->skin_type }}</span>
                                <span class="arrow">→</span>
                            </div>
                        </a>
                        <div class="analysis-date">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>
</body>

</html>
