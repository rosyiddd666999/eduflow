<div class="aspect-video w-full overflow-hidden rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
    @php
        $record = $getRecord();
        $isUpload = $record && $record->type === 'upload';
        $url = $getState();
        $embedUrl = '';
        
        if (!$isUpload) {
            if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
                if (isset($matches[1])) {
                    $embedUrl = "https://www.youtube.com/embed/{$matches[1]}";
                }
            } elseif (str_contains($url, 'vimeo.com')) {
                preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/', $url, $matches);
                if (isset($matches[1])) {
                    $embedUrl = "https://player.vimeo.com/video/{$matches[1]}";
                }
            }
        }
    @endphp

    @if($isUpload)
        @php
            // Priority 1: Use the auto-filled URL from the model (full cPanel URL)
            if ($record->url && str_starts_with($record->url, 'http')) {
                $videoUrl = $record->url;
            } elseif ($record->file_path) {
                $filePath = $record->file_path;
                if (str_starts_with($filePath, 'http')) {
                    // Already a full URL
                    $videoUrl = $filePath;
                } elseif (str_starts_with($filePath, 'videos/')) {
                    // Local fallback file (stored on public disk)
                    $videoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($filePath);
                } else {
                    // cPanel filename only (e.g. "1234567890_video.mp4")
                    $baseUrl = rtrim(config('cpanel.video_base_url'), '/');
                    $videoUrl = $baseUrl . '/' . ltrim($filePath, '/');
                }
            } else {
                $videoUrl = null;
            }
        @endphp
        @if($videoUrl)
            <video controls class="w-full h-full object-cover">
                <source src="{{ $videoUrl }}" type="video/mp4">
                Browser Anda tidak mendukung tag video.
            </video>
        @else
            <div class="flex items-center justify-center h-full bg-gray-100 dark:bg-gray-800 text-gray-500">
                <p>File video belum tersedia.</p>
            </div>
        @endif
    @elseif($embedUrl)
        <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    @else
        <div class="flex items-center justify-center h-full bg-gray-100 dark:bg-gray-800 text-gray-500">
            <p>Video tidak tersedia atau format tidak didukung.</p>
        </div>
    @endif
</div>
