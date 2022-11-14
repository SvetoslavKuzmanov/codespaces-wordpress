<?php

/**
 * @package Mailtrap
 * @version 1.0.0
 */
/*
Plugin Name: Mailtrap
Description: This plugin is used to configure mailtrap service as SMTP server on development environment.
Author: Svetoslav Kuzmanov
Version: 1.0.0
*/

// a helper function to lookup "env_FILE", "env", then fallback
if (!function_exists('getenv_docker')) {
    function getenv_docker($env, $default) {
        if ($fileEnv = getenv($env . '_FILE')) {
            return rtrim(file_get_contents($fileEnv), "\r\n");
        } else if (($val = getenv($env)) !== false) {
            return $val;
        } else {
            return $default;
        }
    }
}

function mailtrap($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = getenv_docker('MAILTRAP_USER', '');
    $phpmailer->Password = getenv_docker('MAILTRAP_PASSWORD', '');
}

if (
    getenv_docker('ENV', 'development') === 'development' &&
    !empty(getenv_docker('MAILTRAP_USER', '')) &&
    !empty(getenv_docker('MAILTRAP_PASSWORD', ''))
) {
    add_action('phpmailer_init', 'mailtrap');
}