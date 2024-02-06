<?php
require 'config.php';
$_SESSION =[];
session_unsent();
session_destroy();
header("Location: login.php");