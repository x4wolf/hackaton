<?php
/*
 * This file is part of Hotels24.ua project (c) 2008-2015.
 */

namespace WritingInstruments;


use WritingInstruments\Exceptions\EmptyRefillLeadException;
use WritingInstruments\Refills\RefillLead;

class MechanicalPencil extends MechanicalPen
{

    /** @var RefillLead  */
    private $refillLead;

    /**
     * @param RefillLead $refillLead
     */
    public function __construct ($refillLead = null)
    {
        $this->changeRefill($refillLead);
    }

    /**
     * @param $text
     * @throws EmptyRefillLeadException
     * @throws \Exception
     */
    public function write ($text) {
        try {
            $this->refillLead->write($text);
        } catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * @param RefillLead $refillLead
     */
    public function changeRefill($refillLead = null)
    {
        if (is_null($refillLead)) {
            $this->refillLead = new RefillLead();
        } else {
            $this->refillLead = $refillLead;
        }
    }

    /**
     * @throws \Exception
     */
    public function click()
    {
        try {
            $this->refillLead->pullOut();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return string
     */
    public function getClickState() {
        return self::STATE_ON;
    }

}