<?php

class Config
{
    public function __construct()
    {
        $this->defineConstantsWPCore();
        $this->loadEnv();
        $this->initWPCore();
    }

    private function defineConstantsWPCore(): void
    {
        if (!defined('ABSPATH')) {
            define('ABSPATH', __DIR__ . '/');
        }

        if (!defined('THEMEPATH')) {
            define('THEMEPATH', constant('ABSPATH') . 'wp-content/themes/minomarkt/');
        }

        if (!defined('DB_NAME')) {
            define('DB_NAME', 'wordpress');
        }

        if (!defined('DB_USER')) {
            define('DB_USER', 'wp_user');
        }

        if (!defined('DB_PASSWORD')) {
            define('DB_PASSWORD', 'wp_pass');
        }

        if (!defined('DB_HOST')) {
            define('DB_HOST', 'db');
        }

        if (!defined('DB_CHARSET')) {
            define('DB_CHARSET', 'utf8');
        }

        if (!defined('DB_COLLATE')) {
            define('DB_COLLATE', '');
        }

        if (!defined('AUTH_KEY')) {
            define('AUTH_KEY', 'f;5kkg?<d<=nkB~.1&u>NpaPq*XkAc<~K[T%HY8r2tkvV^RLN%ga+{Gq& y!-%t');
            define('SECURE_AUTH_KEY', '}kV@K8@g18rP?hd-4Y=S[6tbAF+6jp7,^KWB,d~tFl8?[qUv%M,3v#t_|Vzt9nnL');
            define('LOGGED_IN_KEY', '<{B;C<.QvZ8qF5N&~W<RDL:&U4^a+uDjR/N7=YJ?-5-Hd_E:1|Hxf6-EvPXytADd');
            define('NONCE_KEY', 'rAWh0iNW6it7dgzS~xoI5eO1[eC-XZYF%>v|2mA^x7o4@90d;SM|E!k)T+$=na$M');
            define('AUTH_SALT', '!lOglA-dBU%h]*+9uxkG#GAm{> zu+=WBX|X2?B<y4]g16UfZVG)7/IB~309NC3y');
            define('SECURE_AUTH_SALT', 'z0y W`~J[)obd0@P-eE+8d`WK!61|/XO(Ysbu[&%7tpw+R2zNJ^o9*oM-l-v`F$7');
            define('LOGGED_IN_SALT', '.gPg79.7]W%lSkb1?y?zL$f|IgJEcg*s9 il?%_K7m(t7,P1i!e@U_ju (~R^sau');
            define('NONCE_SALT', '0JdlhCTb]_f]f#H2OJ#QI+q#z%RY*+tGSU4o}] n<)W,dZg)fluxA0/=7JQ,a)=]');
        }
    }

    private function loadEnv(): void
    {
        $envFile = constant('THEMEPATH') . '.env';

        if (!file_exists($envFile)) {
            die('Missing .env file, please create an .env file by copying the .env.example');
        }

        $lines = file($envFile, constant('FILE_IGNORE_NEW_LINES') | constant('FILE_SKIP_EMPTY_LINES'));

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0 || strpos($line, '=') === false) {
                continue;
            }

            [$name, $value] = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (preg_match('/^([\'"])(.*)\1$/', $value, $matches)) {
                $value = $matches[2];
            }

            $constantName = strtoupper($name);
            if (!defined($constantName)) {
                define($constantName, $value);
            }
        }
    }

    private function initWPCore(): void
    {
        $table_prefix = defined('TABLE_PREFIX') ? constant('TABLE_PREFIX') : 'wp_';

        require_once constant('ABSPATH') . 'wp-settings.php';
    }
}

new Config();