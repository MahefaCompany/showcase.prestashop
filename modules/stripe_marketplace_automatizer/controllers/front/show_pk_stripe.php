<?php
require_once __DIR__."/../../../../config/config.inc.php";

echo (Configuration::get("STRIPE_MODE") == '0') ? Configuration::get("STRIPE_PUBLISHABLE") :  Configuration::get("STRIPE_TEST_PUBLISHABLE");
exit();