<?php

/*
 * This file is part of the PHINT package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace Ahc\Phint\Console;

use Ahc\Cli\Input\Command;
use Ahc\Cli\IO\Interactor;
use Ahc\Phint\Util\Composer;
use Ahc\Phint\Util\Git;
use Ahc\Phint\Util\Path;

abstract class BaseCommand extends Command
{
    /** @var string Full path of log file */
    protected $_logFile;

    public function __construct()
    {
        $logFile = @\tempnam(\sys_get_temp_dir(), 'PHT') ?: '';

        $this->_logFile  = $logFile;
        $this->_pathUtil = new Path;
        $this->_git      = new Git(null, $logFile);
        $this->_composer = new Composer(null, $logFile);

        $this->defaults();
        $this->onConstruct();
    }

    protected function onConstruct()
    {
        // ;)
    }

    protected function promptAll(Interactor $io, array $promptConfig)
    {
        $template = ['default' => null, 'choices' => [], 'retry' => 1, 'extra' => '', 'restore' => false];

        foreach ($this->missingOptions($promptConfig) as $name => $option) {
            $config  = ($promptConfig[$name] ?? []) + $template;
            $default = ($config['default'] ?? $option->default()) ?: null;

            if ($config['choices']) {
                $value = $io->choice($option->desc(), $config['choices'], $default);
            } else {
                $value = $io->prompt($option->desc() . $config['extra'], $default, null, $config['retry']);
            }

            if ($config['restore']) {
                $value = $config['choices'][$value] ?? $value;
            }

            $this->set($name, $value);
        }
    }

    protected function missingOptions(array $config)
    {
        return \array_filter($this->userOptions(), function ($name) use ($config) {
            return false !== ($config[$name] ?? null) && \in_array($this->$name, [null, []], true);
        }, \ARRAY_FILTER_USE_KEY);
    }

    protected function getCachePath(): string
    {
        if (!\Phar::running(false)) {
            return __DIR__ . '/../../.cache';
        }

        return $this->_pathUtil->getPhintPath('.cache');
    }

    protected function logging(string $mode = 'start')
    {
        if (!$logFile = $this->_logFile) {
            return;
        }

        if ('end' === $mode) {
            $this->app()->io()->comment("Check detailed logs at $logFile", true);
        } else {
            $this->app()->io()->comment("Logging to $logFile", true);
        }
    }
}
