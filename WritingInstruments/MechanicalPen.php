<?php
 /*
  * This file is part of Hotels24.ua project (c) 2008-2015.
  */

namespace WritingInstruments;


use WritingInstruments\Exceptions\EmptyRefillException;
use WritingInstruments\Exceptions\PenIsClosedException;
use WritingInstruments\Refills\Refill;

class MechanicalPen extends BallPointPen
{
    const STATE_ON = 'on';
    const STATE_OFF = 'off';

    /**
     * @var String
     */
    protected $clickState;

    /**
     * @param Refill $refill
     */
    public function __construct($refill = null)
    {
        $this->clickState = self::STATE_OFF;
        parent::__construct($refill);
    }

    /**
     * @return String
     */
    public function getClickState()
    {
        return $this->clickState;
    }

    /**
     * @param String $state
     * @return self
     */
    private function setClickState($state)
    {
        if (self::STATE_OFF == $state || self::STATE_ON == $state) {
            $this->clickState = $state;
        }
        return $this;
    }

    /**
     * @return String
     */
    public function click()
    {
        if (self::STATE_ON == $this->getClickState()) {
            $this->setClickState(self::STATE_OFF);
        } else {
            $this->setClickState(self::STATE_ON);
        }
        return $this->getClickState();
    }

    /**
     * @param $text
     * @throws EmptyRefillException
     * @throws PenIsClosedException
     * @throws \Exception
     */
    public function write($text)
    {
        try {
            if ($this->getClickState() == self::STATE_ON) {
                parent::write($text);
            } else {
                throw new PenIsClosedException();
            }
        } catch (EmptyRefillException $e) {
            throw $e;
        }
    }

}