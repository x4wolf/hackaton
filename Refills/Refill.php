<?php
 /*
  * This file is part of Hotels24.ua project (c) 2008-2015.
  */

namespace WritingInstruments\Refills;


use WritingInstruments\Exceptions\EmptyRefillException;

class Refill {

    /**
     * @var int $amount
     */
    protected $amount;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return self
     */
    protected function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param int $amount
     */
    public function __constructor ($amount = 10000)
    {
        $this->setAmount($amount);
    }

    /**
     * @param String $text
     * @throws EmptyRefillException
     */
    public function write ($text)
    {
        $remain = $this->getAmount();
        if ($remain > 0) {
            $strlen = strlen($text);
            if ($strlen <= $remain) {
                echo ($text);
                $this->setAmount($remain-$strlen);
            } else {
                $writeText = substr($text, 0, $remain);
                echo ($writeText);
                $this->setAmount(0);
                throw new EmptyRefillException();
            }
        } else {
            throw new EmptyRefillException();
        }
    }

}