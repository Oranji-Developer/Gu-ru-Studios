<?php
function asset_vite($path): string
{
    $manifestPath = public_path('build/manifest.json');
    if (!file_exists($manifestPath)) {
        return asset($path);
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);

    if (isset($manifest[$path])) {
        $entry = $manifest[$path];

        return asset('build/'.$entry['file']);
    }

    return asset($path);
}
