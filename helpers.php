<?php
function dd()
{
    $args = func_get_args();
    call_user_func_array('var_dump', $args);
    die();
}
