<?
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
 
?>