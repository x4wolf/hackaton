<?php
 /*
  * This file is part of Hotels24.ua project (c) 2008-2015.
  */

namespace WritingInstruments;


use WritingInstruments\Exceptions\EmptyRefillException;
use WritingInstruments\Exceptions\PenIsClosedException;
use WritingInstruments\Exceptions\RefillNumberInPenIsBigException;
use WritingInstruments\Refills\ColorRefill;

class MechanicalMultiColorPen extends MechanicalPencil {
    const STATE_ON = 'on';
    const STATE_OFF = 'off';

    const COLOR_QUANTITY = 7;

    /**
     * @var ColorRefill
     */
    private $currentRefill;

    /**
     * @return ColorRefill
     */
    public function getCurrentRefill()
    {
        return $this->currentRefill;
    }

    /**
     * @param ColorRefill $currentRefill
     * @return self
     */
    public function setCurrentRefill($currentRefill)
    {
        $this->currentRefill = $currentRefill;
        return $this;
    }

    /**
     * @var array
     */
    private $refills = [];

    /**
     * @param ColorRefill $refill
     */
    public function __construct($refill = null)
    {
        $this->clickState = self::STATE_OFF;
        $this->changeRefill(0, $refill);
    }

    /**
     * @return String
     */
    public function getClickState()
    {
        return $this->clickState;
    }

    /**
     * @return int
     */
    public function getCurrentColor()
    {
        if (isset ($this->currentRefill)) {
            return $this->currentRefill->getColor();
        } else {
            return null;
        }
    }

    /**
     * @param ColorRefill $refill
     * @return self
     */
    private function setClickState($refill = null)
    {
        if (is_null($refill)) {
            $this->clickState = self::STATE_OFF;
        } else {
            $this->clickState = self::STATE_ON;
            $this->setCurrentRefill($refill);
        }
        return $this;
    }

    /**
     * @param int $refillNumber
     * @return String
     * @throws RefillNumberInPenIsBigException
     */
    public function click($refillNumber)
    {
        if ($refillNumber < self::COLOR_QUANTITY) {
            if (isset($this->refills[$refillNumber])) {
                $nextRefill = $this->refills[$refillNumber];
                if ($nextRefill == $this->currentRefill) {
                    $this->setClickState();
                } else {
                    $this->setClickState($nextRefill);
                }
            } else {
                $this->setClickState();
            }
        } else {
            throw new RefillNumberInPenIsBigException();
        }

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
                $this->getCurrentRefill()->write($text);
            } else {
                throw new PenIsClosedException();
            }
        } catch (EmptyRefillException $e) {
            throw $e;
        }
    }

    /**
     * @param int $refillNumber
     * @param ColorRefill $refill
     * @throws RefillNumberInPenIsBigException
     */
    public function changeRefill($refillNumber, $refill = null)
    {
        if ($refillNumber < self::COLOR_QUANTITY) {
            if (is_null($refill)) {
                $this->refills[$refillNumber] = new ColorRefill();
            } else {
                $this->refills[$refillNumber] = $refill;
            }
        } else {
            throw new RefillNumberInPenIsBigException();
        }
    }

    /**
     * @return ColorRefill[]
     */
    public function getRefills ()
    {
        return $this->refills;
    }
}