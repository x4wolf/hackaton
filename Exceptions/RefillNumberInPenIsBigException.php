<?php
 /*
  * This file is part of Hotels24.ua project (c) 2008-2015.
  */

namespace WritingInstruments\Exceptions;

use Exception;

class RefillNumberInPenIsBigException extends Exception{
    protected $message = 'Номер превышает максимальное кол-во паст в ручке';
    protected $code = 0;

    public function __construct() {
        parent::__construct($this->message, $this->code, null);
    }
}