<?php

require_once('./index.php');
require_once('BaseValidation.php');

class InputOrderValidation extends BaseValidation {

    public function check($inputOrder) {
        $this->errors = [];
        $choices = [
            Atm::MENU_PAYMENT,
            Atm::MENU_WITHDRAW,
            Atm::MENU_BALANCE,
        ];
        if(in_array($inputOrder, $choices)) {
            return true;
        } else {
            $this->errors = [];
            $this->errors[] = "正しい数字を入力して下さい！ \n";
            if(empty($inputOrder)) {
                $this->errors[] = "空です！ \n";
            }
            if(!(is_numeric($inputOrder))) {
                $this->errors[] = "入力が数字ではありません！ \n";
            }
            return false;
        }
    }

}

?>