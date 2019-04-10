<?php

namespace Sanchescom\Utility;

use Sanchescom\Utility\Contracts\UtilityInterface;

/**
 * Class Command.
 */
class Command
{
    /** @var string */
    private const UTILITY = 'networksetup';

    /** @var string */
    private $command;

    /** @var string */
    private $method;

    /** @var array */
    private $options;

    /**
     * Command constructor.
     *
     * @param string $command
     * @param string $method
     * @param array $options
     */
    protected function __construct(string $command, string $method, array $options = [])
    {
        $this->command = $command;
        $this->method = $method;
        $this->options = $options;
    }

    /**
     * @param string $command
     * @param string $method
     * @param array $options
     *
     * @return Command
     */
    public static function make(string $command, string $method, array $options = [])
    {
        return new self($command, $method, $options);
    }

    /**
     * @return string
     */
    public function getUtility()
    {
        return self::UTILITY;
    }

    /**
     * @return string
     */
    protected function extractArgument()
    {
        return strtolower(implode(' ', preg_split('/(?=[A-Z])/', $this->method)));
    }

    /**
     * @return array
     */
    protected function implodeOptions()
    {
        return array_map(
            function ($value, $option) {
                if ($value) {
                    return sprintf("%s='%s'", $option, $value);
                }
            },
            $this->options,
            array_keys($this->options)
        );
    }

    /**
     * @return string
     */
    protected function implodeCommand()
    {
        return trim(
            implode(' ', array_merge([
                $this->utility,
                $this->command,
                $this->extractArgument(),
            ], $this->implodeOptions()))
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->implodeCommand();
    }
}
