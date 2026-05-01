<div class="aspect-video w-full overflow-hidden rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
    @php
        $url = $getState();
        $embedUrl = '';
        
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
    @endphp

    @if($embedUrl)
        <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    @else
        <div class="flex items-center justify-center h-full bg-gray-100 dark:bg-gray-800 text-gray-500">
            <p>Video URL tidak valid atau tidak didukung untuk embed.</p>
        </div>
    @endif
</div>
