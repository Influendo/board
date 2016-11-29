<?php

namespace App\Services;

class Version
{
    private function _version($path)
    {
        $result = elixir($path);
        $result = preg_replace('/(.*)\/app-/', '', $result);
        $result = preg_replace('/\.(css|js)$/', '', $result);

        return $result;
    }

    public function current()
    {
        return [
            'version' => $this->_version('css/app.css') . $this->_version('js/app.js')
        ];
    }
}
