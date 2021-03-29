<?php
/**
 * Fetch app root dir
 * @return string
 */
if (!function_exists('app_root')) {
    function APP_ROOT()
    {
        return dirname(__DIR__);
    }
}
