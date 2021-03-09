<?php

require_once('./index.php');
require_once('BaseValidation.php');

class MoneyInputValidation extends BaseValidation {

    public function check($moneyOrder, $user) {
        $moneyOrderCheck = false;
        $this->errors = [];
        if(is_numeric($moneyOrder)) {
            if(($user["balance"] - ($moneyOrder + Atm::FEE)) < 0) {
                $this->errors[] = "残高が不足しております \n";
            } else {
                $moneyOrderCheck = true;
            }
        }
        if(empty($moneyOrder)) {
            $this->errors[] = "空です！ \n";
        }
        if(!(is_numeric($moneyOrder))) {
            $this->errors[] = "数字を入力して下さい！ \n";
        }
        return $moneyOrderCheck;
    }

}

?>