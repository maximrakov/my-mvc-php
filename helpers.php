<?php
function dd()
{
    $args = func_get_args();
    call_user_func_array('var_dump', $args);
    die();
}
function env($key, $default = '') {
    $env = file_get_contents('.env');
    $patternForEnvRecord = "/$key=(.*)/";
    preg_match_all($patternForEnvRecord, $env, $values);
    if(empty($values)) {
        return $default;
    } else {
        return $values[1];
    }
}
