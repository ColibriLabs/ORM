<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$array = [];

$array['test'][1][] = 1;

var_dump($array);