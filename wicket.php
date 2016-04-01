<?php

require_once "vendor/autoload.php";

$api_key = null;

$Wicket = new \Wicket\Wicket($api_key);

$orgs = $Wicket->get('organizations');

var_dump($orgs);