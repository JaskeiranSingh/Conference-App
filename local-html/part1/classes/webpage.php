<?php

/**
 * Creates a simple web page 
 *	
 */		
    class WebPage {

	protected $pageStart;
	protected $header; 
	protected $main; 
	protected $footer; 
	protected $pageEnd;

	function __construct($pageTitle, $pageHeading1, $main) {
		$this->pageStart = $this->makePageStart($pageTitle);
		$this->header = $this->makeHeader($pageHeading1);
		$this->main = $this->makeMain($main);
		$this->pageEnd = $this->makePageEnd();
	}

	/**
  	* @return string The initial HTML for a webpage
  	*
  	* @param string $pageTitle The title for the webpage
  	*/
	protected function makePageStart($pageTitle) {

		$mycss = $this->makeCSS();

		return <<< PAGESTART
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
  	<title>$pageTitle</title>
  	$mycss  
</head>
<body>

PAGESTART;
	}

	/**
  	* @return string The header and h1 for a webpage
  	*
  	* @param string $pageHeading1 The h1 for the webpage
  	*/
	protected function makeHeader($pageHeading1) {
		return <<< HEADER
    <header>
        <h1>$pageHeading1</h1>
    </header>

HEADER;
	}
    /**
  	* Adds bootstrap css to webpage
  	*
  	*/    
    protected function makeCSS() {
		return <<< MYCSS
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
MYCSS;
	}
    /**
  	* Adds JQuery to webpage
  	*
  	*/  
	protected function makeJS() {
		return <<< MYJS
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
MYJS;
	}

	/**
  	* @return string The contents of the webpage wrapped in main tags.
  	*
  	* @param string $main The content of the main block 
  	*/
	protected function makeMain($main) {
		return <<< MAIN
    <main>
        $main
    </main>

MAIN;
	}

	/**
  	* @return string The footer section and footer text.
  	*
  	* @param string $footer The content of the footer block
  	*/
	protected function makeFooter($footerText) {
		return <<< FOOTER
  <footer>
  	$footerText
  </footer>

FOOTER;
	}

	/**
  	* @return string Final closing tags for webpage. JS added at end of body.
  	*/
	protected function makePageEnd() {
		$myJS = $this->makeJS();
		return <<< PAGEEND
 $myJS
 </body>
</html>

PAGEEND;
	}

	/**
  	* This is a public fuction that can be used to add text to the webpage
  	*
  	* @param string $text Content to add to the webpage
  	*/
	public function addToBody($text) {
	      $this->main .= $text; 
	}

	/**
  	* This is a public fuction will return the completed webpage
  	*
  	* @return String The HTML for a compelete webpage
  	*/
	public function getPage() {

		$this->main = $this->makeMain($this->main);

		return 	$this->pageStart.
				$this->header.
				$this->main.
				$this->footer.
				$this->pageEnd; 
	}
}

?>
