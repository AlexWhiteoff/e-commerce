<?php

use core\Core;
use core\Template;

include('config/config.php');
include('core/Core.php');

$core = Core::getInstance();
$core->init();
$core->run();

$core->done();

