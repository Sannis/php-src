--TEST--
Check opcache revalidation in long running scripts
--INI--
opcache.enable=1
opcache.enable_cli=1
opcache.revalidate_freq=5
--EXTENSIONS--
opcache
--FILE--
<?php
$tmp = __DIR__ . "/opcache_revalidation_in_cli.inc.php";

file_put_contents($tmp, '<?php return "a";');
$v = require $tmp;
var_dump($v);

sleep(10);

file_put_contents($tmp, '<?php return "b";');
$v = require $tmp;
var_dump($v);
?>
--CLEAN--
<?php
@unlink(__DIR__ . "/opcache_revalidation_in_cli.inc.php")
?>
--EXPECTF--
string(1) "a"
string(1) "b"
