<?php

namespace Sanchescom\Utility;

use Sanchescom\Utility\Exceptions\CommandException;

/**
 * Class Command.
 */
class Command
{
    /** @var string */
    private const UTILITY = 'netsh';

    /** @var string */
    private $argument;

    /** @var string */
    private $command;

    /** @var array */
    private $options;

    /** @var array */
    private $andCommands = [];

    /**
     * Command constructor.
     *
     * @param string $argument
     * @param string $command
     * @param array $options
     */
    protected function __construct(string $argument, string $command, array $options = [])
    {
        $this->argument = $argument;
        $this->command = $command;
        $this->options = $options;
    }

    /**
     * @param string $argument
     * @param string $command
     * @param array $options
     *
     * @return Command
     */
    public static function make(string $argument, string $command, array $options = [])
    {
        return new self($argument, $command, $options);
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
    public function getArgument()
    {
        return $this->argument;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->extractCommand();
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->implodeOptions();
    }

    /**
     * @param Command ...$commands
     *
     * @return Command
     */
    public function and(Command ...$commands)
    {
        $this->andCommands = array_merge($this->andCommands, $commands);

        return $this;
    }

    /**
     * @param bool $stdErr
     *
     * @return string
     */
    public function exec($stdErr = true)
    {
        $command = $this->__toString();

        if ($stdErr) {
            $command .= ' 2>&1';
        }

        exec($command, $output, $code);

        if (count($output) === 0) {
            $output = $code;
        } else {
            $output = implode(PHP_EOL, $output);
        }

        if ($code !== 0) {
            throw new CommandException($command, $output, $code);
        }

        return $output;
    }

    /**
     * @return string
     */
    protected function extractCommand()
    {
        return strtolower(implode(' ', preg_split('/(?=[A-Z])/', $this->command)));
    }

    /**
     * @return array
     */
    protected function implodeOptions()
    {
        $options = [];

        foreach ($this->options as $option => $value) {
            if (!is_null($value)) {
                $options[] = sprintf("%s=%s", $option, $value);
            }
        }

        return $options;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $command = trim(
            implode(' ', array_merge([
                $this->getUtility(),
                $this->getArgument(),
                $this->getCommand(),
            ], $this->getOptions()))
        );

        foreach ($this->andCommands as $andCommand) {
            $command .= ' && '.$andCommand;
        }

        return $command;
    }
}
