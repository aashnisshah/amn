<?php

session_start();

mysql_connect("localhost", "projects_affies", "sanjay6959") or die(mysql_error());
mysql_select_db("projects_affies") or die(mysql_error());

require_once("layout.php");
?>