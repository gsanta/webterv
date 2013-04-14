<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Php alapok</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<h2>Változók</h2>

<?php
//egysoros komment 
# ez is
/*több
soros
komment*/
print "<p>";

$max = PHP_INT_MAX;
echo gettype($max). "<br />";

print $max . "<br />";

$x = 3.14;
echo gettype($x). "<br />";
print $x . "<br />";
$y = 3.14e3;
print $y . "<br />";

$large_number = $max;
print gettype($large_number) . ":$large_number<br />";        // int

$large_number++;
print gettype($large_number) . ":$large_number<br />";        // float

$t = TRUE;
$f = FALSE;
echo gettype($t). "<br />";
print "true:" . $t . "<br />";
print "false:" . $f . "<br />";

$a = "Testing $t";
$b = 'Testing $t$';
$c = "Testing $t\$t";
echo gettype($a). "<br />";
print $a . "<br />";
print $b . "<br />";
print $c . "<br />";

if (is_integer($y))
  print $y . " is an integer.<br />";
else 
  print $y . " is not an integer.<br />";

print "</p>";
?>

<?php

class szamok
{
    var $tipus; // PHP4 (var = public)
    public $ertek; // PHP5 (public, protected, private)
    private $nyelv;

    public function __construct()
    {
        $this->tipus = 'string';
        $this->ertek = array('elso', 'masodik', 'harmadik');
	$this->nyelv = 'magyar';
    }
}



$szamok = new szamok();
$szam = 5;

$betuk = new stdClass();
$betuk->ertek = array('a', 'b', 'c');

print '<p>';
echo '$szamok:<br />';
print_r($szamok);
echo '<br />$betuk:<br />';
print_r($betuk);
print '</p>';

print "<p>";
echo <<<HEREDOC
A szám $szam. Kiírok egy típust: $szamok->tipus.
Most kiírok egy tömbelemet: {$szamok->ertek[1]}.
Ez nagy 'A' kell, hogy legyen: \x41
HEREDOC;
print "</p>";

/* PHP 5.3-tól
print "<p>";
echo <<<'NOWDOC'
A szám $szam. Kiírok egy típust: $szamok->tipus.
Most kiírok egy tömbelemet: {$szamok->ertek[1]}.
Ez nagy 'A' kell, hogy legyen: \x41
NOWDOC;
print "</p>";
*/
?>

<h2>Állandók</h2>

<?php
print "<p>";
define("HETFO","1");
print HETFO . "<br />";
print Hetfo . "<br />";

define("MA","kedd", TRUE);
print MA . "<br />";
print Ma . "<br />";

/* PHP 5.3-tól
const SZERDA = "szerda";
print SZERDA . '<br />';
*/
print "</p>";
?>

<h3>Mágikus konstansok</h3>
<?php
print "<ul>";
print "<li>line: " . __LINE__ . "</li>";
print "<li>file: " . __FILE__ . "</li>";
print "<li>function: " . __FUNCTION__ . "</li>";
print "<li>class: " . __CLASS__ . "</li>";
print "</ul>";
?>

<h2>Tömbök</h2>
<?php
print "<p>Tömb és bejárása<br />";

$array[] = 42;
$array[] = 2.71;

foreach ($array as $key => $varible) 
	print $key . " => " . $varible . "<br />";

print "<p>Objektum bejárása<br />";
foreach ($szamok as $property => $value) 
	print $property . ':' . gettype($value) . "<br />";


print "</p>";
	
print "<p>Tömb módosítása adott pozíción és bejárása<br />";

$array[4] = 3;
unset($array[1]);
foreach ($array as $key => $varible) 
	print $key . " => " . $varible . "<br />";

print_r(array_values($array));
print "</p>";

print "<p>Többdimenziós tömb bejárása";
print "<br />";

for ($i = 0; $i < 10; $i++) 
	for ($j = 0; $j < 10; $j++)
		$matrix[$i][$j] = "($i,$j)";


foreach ($matrix as $key => $varible) {
	foreach ($matrix[$key] as $v) {
		print $v . " ";
		
	}
	print "<br />";
}
print "</p>";

print "<p>Tömb rendezése: sort(); rsort();<br />";

$fruits = array("lemon", "orange", "banana", "apple");

sort($fruits);

foreach ($fruits as $key => $val) {
    print "fruits[$key] = $val<br />";
}
print "</p>";

print "<p>Asszociatív tömbök kulcs szerinti rendezése<br />";

$assoc['cat'] = "mouse";
$assoc['dog'] = "cat";
$assoc['chinese'] = "dog";

ksort($assoc);

foreach ($assoc as $key => $val) {
    print "assoc[" . $key . "] = " . $val . "<br />";
}

print "</p>";

print "<p>Tömbök saját rendezése<br />";

function cmp($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a < $b) ? -1 : 1;
}

$a = array(3, 2, 5, 6, 1);

usort($a, "cmp");

foreach ($a as $key => $value) {
    print "$key: $value<br/>";
}
print "</p>";

print "<p>Többdimenziós tömbök rendezése dimenziónként<br />";

$ar = array(
       array("10", 11, 100, 100, "a"),
       array(   1,  2, "2",   3,   1)
      );
array_multisort($ar[0], SORT_ASC, SORT_STRING,
                $ar[1], SORT_NUMERIC, SORT_DESC);
var_dump($ar);
print "</p>";

?>

<h2>Példa függvényre</h2>
<?php
include "function.php";
print numbered_message("Ez egy üzenet");
print numbered_message("Ez egy másik üzenet","blue");
?>

</body>
</html>
