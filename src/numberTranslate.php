<?php

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
?>