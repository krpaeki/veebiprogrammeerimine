<?php
	class Test{
		//muutujad ehk properties
		private $secretNumber;
		public $publicNumber;
		
		//funktsioonil on meetodid ehk methods
		//constructor, mis käivitub classi kasutusele võtmisel
		function __construct($givenNumber){
			$this->secretNumber = 7;
			$this->publicNumber = $givenNumber * $this->secretNumber;			
		}
		
		function __destruct(){
			echo "Ma lõpetan tegevuse";
		}
		
		public function showValues(){
			echo "Salajane number on: " .$this->secretNumber;
		}
		
		private function tellInfo(){
			echo "See on salajane";
		}
		
	}//class lõppeb
?>