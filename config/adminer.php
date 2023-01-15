<?php
/**
 * @link https://www.adminer.org/en/password
 */
function adminer_object() {
    include_once __DIR__.'/plugins/plugin.php';
    foreach (glob("plugins/*.php") as $filename) {
        include_once __DIR__.'/'.$filename;
    }
    class AdminerCustomPlugin extends AdminerPlugin {
        function login($login, $password) {
            return TRUE;
        }
    }
    return new AdminerCustomPlugin(array(
        new AdminerLoginPasswordLess(""),
        new AdminerDumpJson(),
        new AdminerPrettyJsonColumn(new AdminerPlugin(array())),
    ));
}

include __DIR__.'/latest-en.php';
