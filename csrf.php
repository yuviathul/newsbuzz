<?php

$_session['_token'] = bin2hex(openssl_random_pseudo_bytes(16));
if ($_SERVER['REQUEST_METHOD'] == 'post') {
    if (!isset($_post['_token']) || ($_post['_token'] !== $_session['token'])) {
        die('invalid CSRF token');
    }
}

