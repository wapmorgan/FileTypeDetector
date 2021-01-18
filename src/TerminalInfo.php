<?php declare(strict_types = 1);

namespace wapmorgan\FileTypeDetector;

use function assert;
use function explode;
use function fstat;
use function function_exists;
use function posix_isatty;
use function shell_exec;
use function strncasecmp;
use function trim;
use const PHP_OS;
use const STDIN;
use const STDOUT;

class TerminalInfo
{
    private const WIDTH = 1;
    private const HEIGHT = 2;


    public static function isInteractive(): bool
    {
        if (strncasecmp(PHP_OS, 'win', 3) === 0) {
            // windows has no test for that
            return true;
        }

        if (function_exists('posix_isatty')) {
            return posix_isatty(STDOUT);
        }

        // test with fstat()
        $mode = fstat(STDIN);

        return ($mode['mode'] & 0170000) === 0020000; // charater flag (input iteractive)
    }


    public static function getWidth(): string
    {
        if (strncasecmp(PHP_OS, 'win', 3) === 0) {
            return self::getWindowsTerminalSize(self::WIDTH);
        }

        return self::getUnixTerminalSize(self::WIDTH);
    }


    protected static function getWindowsTerminalSize(int $param): string
    {
        $shellExec = shell_exec('mode');
        assert($shellExec !== null);

        $output = explode("\n", $shellExec);
        $line = explode(':', trim($param === self::WIDTH ? $output[4] : $output[3]));

        return trim($line[1]);
    }


    protected static function getUnixTerminalSize(int $param): string
    {
        $shellExec = shell_exec('tput ' . ($param === self::WIDTH ? 'cols' : 'linus'));
        assert($shellExec !== null);

        return trim($shellExec);
    }


    public static function getHeight(): string
    {
        if (strncasecmp(PHP_OS, 'win', 3) === 0) {
            return self::getWindowsTerminalSize(self::HEIGHT);
        }

        return self::getUnixTerminalSize(self::HEIGHT);
    }
}
