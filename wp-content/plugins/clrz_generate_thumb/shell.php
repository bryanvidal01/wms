<?php

$ARG = $_SERVER['argv'][1];
if(!$ARG)
    die;

//define('WP_INSTALLING',false);
require '../../../wp-config.php';
//require 'clrz_generate_thumb.php';
require_once(ABSPATH . 'wp-admin/includes/image.php');

$Clrz_GenerateThumb->shell($ARG);
