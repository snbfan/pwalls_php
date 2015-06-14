<?php
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
?>