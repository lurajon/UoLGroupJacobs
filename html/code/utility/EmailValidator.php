<?php

    class EmailValidator {
        
        public static function validateEmail($email) {
            $isValid = true;
            $atPosition = strpos($email, '@');
        
            if (is_bool($atPosition) && !$atPosition) {
                $isValid = false;
                return $email .' is not a valid email';
                
            } else {
            
                $domainName = substr($email, $atPosition + 1);
                $localName = substr($email, 0, $atPosition);
            
                $isLocalNameValid = self::validateLocalName($localName);
                
                if (strlen($isLocalNameValid) > 0) {
                    return $isLocalNameValid;
                }
                
                $isDomainNameValid = self::validateDomainName($domainName);
                
                if (strlen($isDomainNameValid)) {
                    return $isDomainNameValid;
                }
            }
            
            return null;
        }
        
        /**
         * Validate the local name
         */
        private static function validateLocalName($localName) {
            if (!self::isValidLength($localName, 1, 64)) {
                return 'Invalid local name length';
            }
            
            $length = strlen($localName);
            
            if ($localName[0] == '.') {
                return 'The name can not start with \'.\'';     
            }
                
            if ($localName[$length-1] == '.') {
                return 'The name can not end with \'.\'';     
            }
            
            if (preg_match('/\\.\\./', $localName)) {
                return 'The local name has two consecutive dots';
            }
            
            // check for valid characters. some characters are valid inside quotes (not commonly seen though)      
            if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$localName))) {
            
                if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$localName))){
                    return 'Invalid character(s) found';
                }
            }
            
            return '';
        }
        
        /**
         * Validate domain name
         */
        private static function validateDomainName($domainName) {
            if (!self::isValidLength($domainName, 1, 64)) {
                return 'Invalid domain name length';
            }
            
            if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domainName)) {
                return 'Invalid character(s) in the domain name';
            }

            if (preg_match('/\\.\\./', $domainName)) {
                return 'The domain name has two consecutive dots';
            }
            
            if (!preg_match('/[A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/', $domainName)) {
                return 'The domain name does not have a valid suffix';
            }
            
            return '';
        }
        
        /**
         *  Check that the valid is within the given range
         */
        private static function isValidLength($value, $min, $max) {
            $length = strlen($value);
            
            if ($length > $min && $length < $max) {
                return true;
            }
            
            return false;
        }
        
    }
?>