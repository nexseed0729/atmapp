<?php

class BaseValidation {

    protected $errors = [];

    public function getErrorsMessage() {
        return $this->errors;
    }

}

?>