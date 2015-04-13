<?php
/*
 * This file is part of Hotels24.ua project (c) 2008-2015.
 */

namespace WritingInstruments\Exceptions;

use Exception;

class EmptyRefillLeadException extends Exception
{
    protected $message = 'Грифель закончился';
    protected $code = 0;

    public function __construct() {
        parent::__construct($this->message, $this->code, null);
    }
}