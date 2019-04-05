<?php

namespace Sanchescom\Utility\Netsh;

use Sanchescom\Utility\Contracts\UtilityInterface;

/**
 * Class Utility.
 */
class Utility implements UtilityInterface
{
    /**
     * @var string
     */
    protected $name = 'netsh';

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
