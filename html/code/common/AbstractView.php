<?php

	abstract class AbstractView {
		
		private $_message;
		
		public function setMessage($message) {
			$this->_message = $message;
		}
		
		public function getMessage() {
			return $this->_message;
		}
		
		function printMessage() {
            print $this->getMessage();
        }
        
        function setErrorMessage($errorMessage) {
            $this->setMessage('{ "message": { "type": "error", "content": "'. $errorMessage.'" } }');
           
        }
        
        function setInfoMessage($infoMessage) {
            $this->setMessage('{ "message": { "type": "info", "content": "'. $infoMessage.'"} }');
            
        }
		
		function printInfoMessage($infoMessage) {
			$this->setInfoMessage($infoMessage);
			$this->printMessage();
		}
		
		function printErrorMessage($infoMessage) {
			$this->setErrorMessage($infoMessage);
			$this->printMessage();
		}
		
	}
?>