<?php
/**
 * @link https://www.adminer.org/en/extension
 * @link https://www.adminer.org/en/password
 */
function adminer_object() {
    class AdminerSoftware extends Adminer\Adminer {
        function login($login, $password) {
            return TRUE;
        }
    }
    return new AdminerSoftware;
}
include __DIR__.'/latest-en.php';
