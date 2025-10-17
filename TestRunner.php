<?php
echo "|-------------------------------------------------------------------------------------------------------|\n";
echo "| Library             | File / Mem | Insert | Update | Find   | Complex| EagerL. | memory usage|  time  |\n";
echo "| -------------------:|-----------:| ------:| ------:| ------:| ------:| -------:| -----------:| ------:|\n";

$separator = "|-------------------------------------------------------------------------------------------------------|\n";

passthru('php atlas_21/TestRunner.php   atlas');
echo $separator;
//passthru('php cycleorm/TestRunner.php   cycleorm');
//echo $separator;
//passthru('php doctrine_m/TestRunner.php doctrine');
//echo $separator;
passthru('php eloquent/TestRunner.php   eloquent');
echo $separator;
//passthru('php siriusorm/TestRunner.php  siriusorm');
//echo $separator;
passthru('php PHPFUI_ORM/TestRunner.php PHPFUI_ORM');
echo $separator;
passthru('php atlas_21/TestRunner.php   :memory:');
echo $separator;
//passthru('php cycleorm/TestRunner.php   :memory:');
//echo $separator;
//passthru('php doctrine_m/TestRunner.php :memory:');
//echo $separator;
passthru('php eloquent/TestRunner.php   :memory:');
echo $separator;
//passthru('php siriusorm/TestRunner.php  :memory:');
//echo $separator;
passthru('php PHPFUI_ORM/TestRunner.php :memory:');
echo $separator;


