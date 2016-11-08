<?php

if (! function_exists('asset_env')) {
    /**
     * Return URL to asset depending on environment
     * For production and develop server assets are versioned on deploy
     *
     * @param  string $path
     * @return string
     */
    function asset_env($path)
    {
        if (config('app.env') == 'develop') {
            return asset($path);
        }

        return elixir($path);
    }
}
