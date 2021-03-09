<?php

require_once('./index.php');
require_once('BaseValidation.php');

class PasswordCheck extends BaseValidation {
    
    public static $count = 0;
    public $userPassword;
    public $password;

    public function __construct($password, $userPassword) {
        $this->userPassword = $userPassword;
        $this->password = $password;
        self::$count++; 
    }
    
    public function check($password) {
        if(!($this->userPassword == $this->password)) {
            echo  "連続入力可能３回：残り入力可能回数".(3-self::$count)."回で終了します  \n";
            $this->errors = [];
            $this->errors[] = "パスワードが間違ってます。 \n";
            if(empty($password)) {
                $this->errors[] = "空です！ \n";
            }
            if(!(is_numeric($password))) {
                $this->errors[] = "数字を入力して下さい！ \n";
            }
            return false;
        }
        return true;
    }
    
    public function numberSecurity($count) {
        if($count < 3) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>