<?php
/*
 * This file is part of Hotels24.ua project (c) 2008-2015.
 */

namespace WritingInstruments\Exceptions;

use Exception;

class EmptyNebException extends Exception
{
    protected $message = 'Кончик грифеля закончился';
    protected $code = 0;

    public function __construct() {
        parent::__construct($this->message, $this->code, null);
    }
}