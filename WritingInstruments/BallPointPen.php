<?php
 /*
  * This file is part of Hotels24.ua project (c) 2008-2015.
  */

namespace WritingInstruments;


use WritingInstruments\Exceptions\EmptyRefillException;
use WritingInstruments\Refills\Refill;

class BallPointPen
{

    /** @var Refill  */
    private $refill;

    /**
     * @param Refill $refill
     */
    public function __construct ($refill = null)
    {
        $this->changeRefill($refill);
    }

    /**
     * @param $text
     * @throws EmptyRefillException
     * @throws \Exception
     */
    public function write ($text) {
        try {
            $this->refill->write($text);
        } catch (EmptyRefillException $e){
            throw $e;
        }
    }

    /**
     * @param Refill $refill
     */
    public function changeRefill($refill = null)
    {
        if (is_null($refill)) {
            $this->refill = new Refill();
        } else {
            $this->refill = $refill;
        }
    }

}