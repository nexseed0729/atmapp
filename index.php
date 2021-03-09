<?php

// 69 ATMを作成しよう
// コマンドラインから実行すること
// 要件定義
// ・残額、入金、引き出しの機能を実装
// 実際にATMに必要な機能をリストアップして、ご自由に開発してみてください！

require_once('validation/BaseValidation.php');
require_once('validation/InputOrderValidation.php');
require_once('validation/PasswordValidation.php');
require_once('validation/IdValidation.php');
require_once('validation/MoneyInputValidation.php');

class User {
    private static $user_list = array(
        1 => array(
            "id" => 1,
            "password" => "1234",
            "name" => "tanaka",
            "balance" => "500000"
        ),
        2 => array(
            "id" => 2,
            "password" => "3456",
            "name" => "suzuki",
            "balance" => "1000000"
        ),
    );

    public static function getUserList() {
        return self::$user_list;
    }

}

class Atm {
    const MENU_PAYMENT = 1;
    const MENU_WITHDRAW = 2;
    const MENU_BALANCE = 3;
    const PAYMENT = "入金";
    const WITHDRAW = "出金";
    const BALANCE = "残額";
    const FEE = 210;
    const CHOICES = [
        self::PAYMENT,
        self::WITHDRAW,
        self::BALANCE,
    ];
    public $user = [];
    public function __construct() {
        $this->login();
    }
    
    public function login() {
        $userId = $this->userIdInput();
        $registeredUser = User::getUserList()[$userId];
        $this->passwordInput($registeredUser);
        $this->user = $registeredUser;
        return;
    }
    
    public function userIdInput() {
        echo "ユーザーIDを入力してください \n";
        $userId = rtrim(fgets(STDIN));
        $idCheck = new IdValidation();
        if(!($idCheck->check($userId))) {
            for($i = 0 ;$i < count($idCheck->getErrorsMessage()) ;$i++) {
                echo $idCheck->getErrorsMessage()[$i];
            }
            return $this->userIdInput();
        }
        return $userId;
    }
    
    public function passwordInput($registeredUser) {
        echo "パスワードを入力してください \n";
        $password = rtrim(fgets(STDIN));
        $userPassword = $registeredUser["password"];
        $passwordCheck = new PasswordCheck($password, $userPassword);
        if(!($passwordCheck->check($password))) {
            if($passwordCheck->numberSecurity(PasswordCheck::$count)) {
                for($i = 0 ;$i <= count($passwordCheck->getErrorsMessage()) ;$i++) {
                    echo $passwordCheck->getErrorsMessage()[$i];
                }
                return $this->passwordInput($registeredUser);
            } else {
                return exit;
            }
        }
        return $password;
    }

    public function main() {
        echo $this->user["name"]." 樣ご希望のお取引を数字でご入力選択下さい（半角数字） \n";
        $this->choice();
        $this->menu();
    }
    
    public function choice() {
        foreach (self::CHOICES as $key => $choice) {
            echo ($key+1)." ".$choice .PHP_EOL;
        }
    }
    
    public function menu() {
        $order = $this->inputOrder();
        switch($order) {
            case self::MENU_PAYMENT:
                $this->payment();
            break;
            case self::MENU_WITHDRAW:
                $this->withdraw();
            break;
            case self::MENU_BALANCE:
                $this->showBalance();
            break;
        }
    }
    
    public function inputOrder() {
        $inputOrder = rtrim(fgets(STDIN));
        $check1 = new InputOrderValidation();
        if(!($check1->check($inputOrder))) {
            for($i = 0 ;$i <= count($check1->getErrorsMessage()) ;$i++) {
                echo $check1->getErrorsMessage()[$i];
            }
            return $this->inputOrder();
        }
        return $inputOrder;
    }
    
    
    public function payment() {
        echo "入金額を入力下さい \n";
        $money = $this->moneyOrder();
        $totalMoney = $this->inMoney($money);
        $processed = self::MENU_PAYMENT;
        return $this->outputBalance($totalMoney, $processed);
    }
    
    public function withdraw() {
        echo "引き出し額を入力下さい \n";
        $money = $this->moneyOrder();
        $totalMoney = $this->outMoney($money);
        $processed = self::MENU_WITHDRAW;
        return $this->outputBalance($totalMoney, $processed);
    }
    
    public function showBalance() {
        $money = $this->user["balance"];
        $processed = self::MENU_BALANCE;
        return $this->outputBalance($money, $processed);
    }
    
    public function moneyOrder() {
        $moneyOrder = rtrim(fgets(STDIN));
        $check2 = new MoneyInputValidation();
        if(!($check2->check($moneyOrder, $this->user))) {
            for($i = 0 ;$i <= count($check2->getErrorsMessage()) ;$i++) {
                echo $check2->getErrorsMessage()[$i];
            }
            return $this->moneyOrder();
        }
        return $moneyOrder;
    }
    
    public function inMoney($inMoney) {
        $this->user["balance"] = $this->user["balance"] + $inMoney - self::FEE;
        return $this->user["balance"];
    }
    
    public function outMoney($outMoney) {
        $this->user["balance"] = $this->user["balance"] - $outMoney - self::FEE;  
        return $this->user["balance"];
    }
    
    public function outputBalance($money, $processed) {
        if($processed == self::MENU_BALANCE) {
            echo "残金は、".$money."円です。\n";
        } else {
            echo "残金は".$money."円です。(手数料".self::FEE."円引かれました) \n";
        }
    }

}

$atm = new Atm($user1);
$atm->main();

?>