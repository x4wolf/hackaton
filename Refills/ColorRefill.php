<?php
 /*
  * This file is part of Hotels24.ua project (c) 2008-2015.
  */

namespace WritingInstruments\Refills;


use WritingInstruments\Exceptions\EmptyRefillException;

class ColorRefill extends Refill
{
    /**
     * @var int
     */
    private $color;

    /**
     * @return int
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param int $color
     * @param int $amount
     */
    public function __constructor ($color = 0, $amount = 10000)
    {
        $this->color = $color;
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
            try {
                echo('<color = ' . $this->getColor() . '>'); //я хочу цвет устанавливать так :)
                parent::write($text);
            } catch (EmptyRefillException $e) {
                throw $e;
            } finally {
                echo ('</color>');
            }
        }
   }

}