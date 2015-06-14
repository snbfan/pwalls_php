<?

/**
 * Abstract class for transforming numbers into text
 *
 * @author Medun Dima
 */
abstract class numberTranslate
{
	/**
	 * @var Integer $numberSize - amount of triads in the number (111000 - 2, 111000111 - 3)
	 */	
	protected $numberSize;
	
	/**
	 * @var String $number - number to process
	 */
	protected $number = '';
	
	/**
	 * @var Array $result - result array
	 */
	protected $result = array();
	
	/**
	 * @var Array $numbers - array for text digit representation 
	 */
	protected $numbers = array();
	
	/**
	 * @var Array $sizeWord - array for 'hundred'/'million'/'thousand' text
	 */
	protected $sizeWord = array();
	
	/**
	 * @var Integer $currentTriadNumber - number of triad beign currently processed
	 */
	
	/**
	 * Construct
	 * @param String $number
	 * 
	 */
	public function __construct($number)
	{
		if (!is_numeric($number))
		{
			die('please input correct integer');
		}
		
		if (strlen(strval($number)) > 9)
		{
			die('please input number less than 1 000 000 000');
		}
		
		$this->number = strval(intval($number));
	}
	
	/**
	 * Main processing method
	 * 
	 */
	public function process()
	{
		$this->detectNumberSize();
		$this->compileTransformedString();
	}
	
	/**
	 * Abstract method. Adds 'thousand'/'tysaycha' , etc. text
	 */
	abstract protected function getDigitSizeWord($num, $triad);
	
	
	/**
	 * Abstract method. Compile text for 3-digit numbers like 110 
	 */
	abstract protected function getHundredDigitName($str);
	
	
	/**
	 * Detect amount of triads in the number  
	 */
	protected function detectNumberSize()
	{
		$this->numberSize = ceil(strlen($this->number)/3);	
	}

	/**
	 * Compiles text representation of a number
	 * 
	 */
	protected function compileTransformedString()
	{
		$length = strlen($this->number);
		
		// get 3 digits from the end and transform them into text
		$j = 1;
		for($i = $this->numberSize; $i > 0; $i--)
		{
			$this->currentTriadNumber = $j;
			
			$start 	= (($length - 3 * $j) > 0 ) ? ($length - 3 * $j) : 0;
			$read 	= (($length - 3 * ($j-1)) < 3) ? ($length - 3 * ($j-1)) : 3; 

			// get string part
			$numberPart = ($length > 2) ? substr($this->number, $start, $read) : $this->number;

			// compile string
			$this->result[] = $this->processNumberPart($numberPart, $i).' '.$this->getDigitSizeWord(strlen($numberPart)-1, intval($numberPart));
			$j++;
		}
		// print_r();
		echo  $this->number.' -- '.implode(" ", array_reverse($this->result));
	}

	/**
	 * Returns single digit text representation
	 * @param String $str - digit to process
	 * @return String - text representation of a digit
	 * 
	 */
	protected function getSingleDigitName($str)
	{
		if (!is_array($this->numbers[0][intval($str)]))
		{
			return $this->numbers[0][intval($str)];
		}
		else 
		{
			if (isset($this->numbers[0][intval($str)][$this->currentTriadNumber]))
			{
				return $this->numbers[0][intval($str)][$this->currentTriadNumber];
			}
		}
	}
	
	/**
	 * Returns decimal digit name
	 * @param String $str - decimal number
	 * @return String - processed decimal string
	 */
	protected function getDecimalDigitName($str)
	{
		if ($str[0] == 1)
		{
			return $this->numbers[1][intval($str)];
		}
		else 
		{
			return $this->numbers[1][intval($str[0])].' '.$this->getSingleDigitName($str[1]);//$this->numbers[0][intval($str[1])];
		}
	}
	
	/**
	 * Main method that processes 1,2,3-digit numbers
	 * @param String $str - number (e.g. 11, 321, 5 etc.)
	 * @return String
	 */	
 	protected function getDigitName($str)
	{
		if (strlen($str) == 1)
		{
			return $this->getSingleDigitName($str);
		}
		
		if (strlen($str) == 2)
		{
			return $this->getDecimalDigitName($str);
		}

		if (strlen($str) == 3)
		{
			return $this->getHundredDigitName($str);
		}
	}
	
	/**
	 * Processes number part (triad) into text
	 * @param String $numberPart - number part of initial number (triad)
	 * @return String - text representation
	 */
	protected function processNumberPart($numberPart)
	{
		return $this->getDigitName($numberPart);
	}
	
}

/**
 * numberTranslateRU class for transforming numbers into russian text
 *
 * @author Medun Dima
 */
class numberTranslateRU extends numberTranslate
{
	/**
	 * @var Array $numbers - RU-specific text representation of numbers
	 */
	protected $numbers = array(
		2 => array(
			1 => 'sto',
			2 => 'dvesti',
			3 => 'trista',
			4 => 'chetyresta',
			5 => 'pyatsot',
			6 => 'shestsot',
			7 => 'semsot',
			8 => 'vosemsot',
			9 => 'devyatsot',
		),
		1 => array(
			2=>'dvadtsat', 
			3=>'tridtsat', 
			4=>'sorok', 
			5=>'pyatdesyat', 
			6=>'shestdesyat',
			7=>'semdesyat',
			8=>'vosemdesyat',
			9=>'devyanosto',
			
			10=>'desyat',
			11=>'odynnadtsat',
			12=>'dvenadtsat',
			13=>'trinadtsat',
			14=>'chetirnadtsat',
			15=>'pyatnadtsat',
			16=>'shestnadtsat',
			17=>'semnadtsat',
			18=>'vosemnadtsat',
			19=>'devyatnadtsat'
		),
		0 => array(
			1=>array(3=>'odin',2=>'odna'), 
			// 1=>'odin', 
			2=>array(3=>'dva',2=>'dve'), 
			// 2=>'dva', 
			3=>'tri', 
			4=>'chetire', 
			5=>'pyat', 
			6=>'shest', 
			7=>'sem', 
			8=>'vosem',
			9=>'devyat'
		)
		
	);
	
	/**
	 * @var Array $sizeWord - RU-specific number size words + suffixes
	 */
	public $sizeWord = array(
		3 => array(
			'base' => 'million',
			'add' => array(1=>'',2=>'a',3=>'a',4=>'a'),
			'final' => 'ov'
		),
		2 => array(
			'base' => 'tysyach',
			'add' => array(1=>'a',2=>'i',3=>'i',4=>'i'),
			'final' => ''
		)
	);

	/**
	 * Construct 
	 * @param String $number
	 */	
	public function __construct($number)
	{
		parent::__construct($number);
	}
	
	/**
	 * Adds russian 'tysyacha'/'million' word
	 * @param Integer $num - number
	 * @param Integer $triad - number compiled of triad
	 * @return String 'tysyacha'/'million' word
	 */
	protected function getDigitSizeWord($num, $triad)
	{
		if (intval($triad) == 0)
		{
			return '';
		} 	

		$ending = (strlen($triad) > 2) ? $triad % 100 : $triad;
		$size = $this->currentTriadNumber;
		
		// echo $size.' -- '.$ending.'<br>';
		switch(strlen($ending))
		{
			case 1:
				return $this->sizeWord[$size]['base'].(($ending > 0 && $ending < 5) ? $this->sizeWord[$size]['add'][$ending] : $this->sizeWord[$size]['final']);
			break;
			 
			case 2:
			default:	
				
				if ($ending > 10 && $ending < 19)
				{
					return $this->sizeWord[$size]['base'].$this->sizeWord[$size]['final'];
				}
				else if ($ending%10 > 0 && $ending%10 < 5)
				{
					return $this->sizeWord[$size]['base'].$this->sizeWord[$size]['add'][$ending%10];
				}
				else 
				{
					return $this->sizeWord[$size]['base'].$this->sizeWord[$size]['final'];
				}
			break;
		}
	}	

	/**
	 * Returns RU-specific hundreds names
	 * @param String $str - 3-digits string
	 * @return String $out - text representation of 3-digit number
	 */
	protected function getHundredDigitName($str)
	{
		$out = '';
		$out .= $this->numbers[2][intval($str[0])].' ';
		$out .= $this->getDecimalDigitName($str[1].$str[2]);
		return $out;	
	}
	
}

/**
 * numberTranslateEN class for transforming numbers into english text
 *
 * @author Medun Dima
 */
class numberTranslateEN extends numberTranslate
{
	/**
	 * @var Array $numbers - EN-specific text representation of numbers
	 */
	protected $numbers = array(
		1 => array(
			0=>'',
			2=>'twenty', 
			3=>'thirty', 
			4=>'fourty', 
			5=>'fifty', 
			6=>'sixty',
			7=>'seventy',
			8=>'eighty',
			9=>'ninety',
			
			10=>'ten',
			11=>'eleven',
			12=>'twelve',
			13=>'thirteen',
			14=>'fourteen',
			15=>'fifteen',
			16=>'sixteen',
			17=>'seventeen',
			18=>'eighteen',
			19=>'nineteen'
		),
		0 => array(
			1=>'one', 
			2=>'two', 
			3=>'three', 
			4=>'four', 
			5=>'five', 
			6=>'six', 
			7=>'seven', 
			8=>'eight',
			9=>'nine'
		),
	);
	
	/**
	 * @var Array $sizeWord - RU-specific number size words + suffixes
	 */		
	protected $sizeWord = array(
		3 => 'million',
		2 => 'thousand',
		1 => '',
		0 => 'hundred'
	);

	/**
	 * Construct 
	 * @param String $number
	 */		
	public function __construct($number)
	{
		parent::__construct($number);
	}
	
	/**
	 * Adds english 'thousand'/'million' word
	 * @param Integer $num - number
	 * @param Integer $triad - number compiled of triad
	 * @return String 'thousand'/'million' word
	 */	
	protected function getDigitSizeWord($num, $triad)
	{
		$str = '';
		$size = $this->currentTriadNumber;
		// echo $num.' -- '.$size.' -- '.$triad.'<br>';
		if ($this->sizeWord[$size] != '')
		{
			$str .= ' '.$this->sizeWord[$size];
			if ($num > 1 || ($size > 0 && $triad > 1))
			{
				$str .= 's';
			}
		}
		else
		{
			$str .= '';
		}

		return $str.' ';
	}	
	
	/**
	 * Returns EN-specific hundreds names
	 * @param String $str - 3-digits string
	 * @return String $out - text representation of 3-digit number
	 */	
	protected function getHundredDigitName($str)
	{
		$out = '';
		$out .= $this->getSingleDigitName($str[0]);
		$out .= ($str[0] > 0) ? $this->getDigitSizeWord($str[0],0,intval($str)) : ''; 
		$out .= $this->getDecimalDigitName($str[1].$str[2]);
		return $out;	
	}
	
}



		

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