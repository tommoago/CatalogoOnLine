<?php
require_once 'Mobile-Detect-2.7.7/Mobile_Detect.php';

$detect = new Mobile_Detect;

if ($detect -> isMobile()) {
	header('location:../melarossa.mobile.old');
} else {
	header('location:pages/index.php');
}
?>