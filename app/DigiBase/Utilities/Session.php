<?php

namespace App\DigiBase\Utilities;

use Auth;

trait Session
{
    protected function getSession($key, $default, $sessionPrefix = null)
    {
        $sessionPrefix = $sessionPrefix ? 'login_' . $sessionPrefix : 'login_' . 'web';

        return session()->get($sessionPrefix . "_" . $key, $default);
    }

    protected function setSession($key, $value, $sessionPrefix = null)
    {
        $sessionPrefix = $sessionPrefix ? 'login_' . $sessionPrefix : 'login_' . 'web';

        return session()->put($sessionPrefix . "_" . $key, $value);
    }

    protected function getAllSession($sessionPrefix = null)
    {
        $sessionPrefix = $sessionPrefix ? 'login_' . $sessionPrefix : 'login_' . 'web';

        $content = [];
        foreach (session()->all() as $key => $value) {
            if (preg_match("/$sessionPrefix/", $key)) {
                $content = array_merge($content, array($key => $value));
            }
        }

        return $content;
    }

    protected function flushSession($sessionPrefix)
    {
        $sessionPrefix = $sessionPrefix ? 'login_' . $sessionPrefix : 'login_' . 'web';

        $content = [];
        foreach (session()->all() as $key => $value) {
            if (preg_match("/$sessionPrefix/", $key)) {
                session()->forget($key);
            }
        }

        return true;
    }

    protected function invalidateSession()
    {
        return session()->flush();
    }
}
