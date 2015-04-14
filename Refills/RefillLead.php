<?php
 /*
  * This file is part of Hotels24.ua project (c) 2008-2015.
  */

namespace WritingInstruments\Refills;


use WritingInstruments\Exceptions\EmptyNebException;
use WritingInstruments\Exceptions\EmptyRefillLeadException;
use WritingInstruments\Exceptions\NebBrokenException;

class RefillLead {

    const PULL_OUT_STEP = 500;
    const MAX_UNBROKEN_NEB = 2500;

    /**
     * @var int $length
     */
    private $length;

    /**
     * @var int $neb
     */
    private $neb;

    /**
     * @return int
     */
    public function getNeb()
    {
        return $this->neb;
    }

    /**
     * @param int $neb
     * @return self
     */
    public function setNeb($neb)
    {
        $this->neb = $neb;
        return $this;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     * @return self
     */
    private function setLength($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     * @param int $length
     */
    public function __constructor ($length = 10000)
    {
        $this->setLength($length);
    }

    /**
     * @throws EmptyRefillLeadException
     */
    public function pullOut()
    {
        $length = $this->getLength();
        if ($length > 0) {
            if ($length > self::PULL_OUT_STEP) {
                $this->setNeb($this->getNeb() + self::PULL_OUT_STEP);
                $this->setLength($length - self::PULL_OUT_STEP);
            } else {
                $this->setNeb($this->getNeb() + $length);
                $this->setLength(0);
            }
        } else {
            throw new EmptyRefillLeadException();
        }
    }

    /**
     * @param String $text
     * @throws EmptyNebException
     * @throws NebBrokenException
     */
    public function write ($text)
    {
        $remain = $this->getNeb();
        if ($remain > self::MAX_UNBROKEN_NEB) {
            $this->setNeb(0);
            throw new NebBrokenException();
        } elseif ($remain > 0) {
            $strlen = strlen($text);
            if ($strlen <= $remain) {
                echo ($text);
                $this->setNeb($remain-$strlen);
            } else {
                $writeText = substr($text, 0, $remain);
                echo ($writeText);
                $this->setNeb(0);
                throw new EmptyNebException();
            }
        } else {
            throw new EmptyNebException();
        }
    }
}