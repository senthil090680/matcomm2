<?php

//Testing

$wsmemClient = new WSMemcacheClient;

$matriId = "AGR100158";
$table = "memberinfo";

$rs = $wsmemClient->processRequest($matriId, $table);



