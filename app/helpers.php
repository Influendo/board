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

if ( ! function_exists('humanize_number')) {
    /**
     * Display large numbers in a more readable format
     *
     * @param  int     $num
     * @param  int     $places
     * @param  string  $type
     * @return string
     */
    function humanize_number($num, $places = 0, $type = 'metric')
    {
    	if ($type == 'metric') {
        	$k = 'K'; $m = 'M';
        } else {
        	$k = ' thousand'; $m = ' million';
        }

        if ($num < 1000) {
            $num_format = number_format($num, 0, ",", ".");
        } else if ($num < 1000000) {
            $num_format = number_format($num / 1000, $places, ",", ".") . $k;
        } else {
            $num_format = number_format($num / 1000000, $places, ",", ".") . $m;
        }

        return $num_format;
    }
}
