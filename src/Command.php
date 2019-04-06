<?php

namespace Sanchescom\Utility;

use Sanchescom\Utility\Contracts\UtilityInterface;

/**
 * Class Command.
 */
class Command
{
    /**
     * @var UtilityInterface
     */
    protected $utility;

    /**
     * @var string
     */
    protected $command;

    /**
     * @var string
     */
    protected $argument;

    /**
     * @var array
     */
    protected $options;

    /**
     * Command constructor.
     *
     * @param UtilityInterface $utility
     * @param string $command
     * @param string $argument
     * @param array $options
     */
    public function __construct(UtilityInterface $utility, string $command, string $argument, array $options = [])
    {
        $this->utility = $utility;
        $this->command = $command;
        $this->argument = $argument;
        $this->options = $options;
    }

    /**
     * @param UtilityInterface $utility
     * @param string $command
     * @param string $argument
     * @param array $options
     * @return Command
     */
    public static function make(UtilityInterface $utility, string $command, string $argument, array $options = [])
    {
        return new self($utility, $command, $argument, $options);
    }

    /**
     * @return string
     */
    protected function extractArgument()
    {
        return strtolower(implode(' ', preg_split('/(?=[A-Z])/', $this->argument)));
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
