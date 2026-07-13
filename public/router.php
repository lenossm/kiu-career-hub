<?php

// PHP built-in server router — serve real files from /public as-is
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');
$file = __DIR__.$uri;

if ($uri !== '/' && is_file($file)) {
    return false;
}

require_once __DIR__.'/index.php';
