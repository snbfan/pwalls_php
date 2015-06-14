<?

	include('numberTranslate.php');
	include('numberTranslateEN.php');
	include('numberTranslateRU.php');		

	$numbers = array(1,10,11,95,106,331,990,10001,101205,313000,1234000,101100010,999999999);
	
	foreach($numbers as $num)
	{
		$e = new numberTranslateEN($num);
		$e->process();
		echo '<br>';

		$r = new numberTranslateRU($num);
		$r->process();
		echo '<br>--<br>';
	}

?>