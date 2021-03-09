<?php

require_once('./index.php');
require_once('BaseValidation.php');

class IdValidation extends BaseValidation {

    public function check($id) {
        $idCheck = false;
        for($i = 1 ;$i <= count(User::getUserList()) ;$i++) {
            if($id == User::getUserList()[$i]["id"]) {
                $idCheck = true;
            break;
            }
        }
            //$errors にエラーメッセージを格納
        $this->errors = [];
        if(empty($id)) {
            $this->errors[] = "空です！ \n";
        }
        if(!(is_numeric($id))) {
            $this->errors[] = "数字を入力して下さい！ \n";
        }
        if(!(in_array($id, user::getUserList()))) {
            $this->errors[] = "登録がありません！ \n";
        }
        return $idCheck;
    }

}

?>