<?php declare(strict_types=1);
/*
 * This file is part of phpunit/php-code-coverage.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\CodeCoverage\Driver;

use SebastianBergmann\CodeCoverage\BranchAndPathCoverageNotSupportedException;
use SebastianBergmann\CodeCoverage\DeadCodeDetectionNotSupportedException;
use SebastianBergmann\CodeCoverage\RawCodeCoverageData;

/**
 * @internal This class is not covered by the backward compatibility promise for phpunit/php-code-coverage
 */
abstract class Driver
{
    /**
     * @var int
     *
     * @see http://xdebug.org/docs/code_coverage
     */
    public const LINE_NOT_EXECUTABLE = -2;

    /**
     * @var int
     *
     * @see http://xdebug.org/docs/code_coverage
     */
    public const LINE_NOT_EXECUTED = -1;

    /**
     * @var int
     *
     * @see http://xdebug.org/docs/code_coverage
     */
    public const LINE_EXECUTED = 1;

    /**
     * @var int
     *
     * @see http://xdebug.org/docs/code_coverage
     */
    public const BRANCH_NOT_HIT = 0;

    /**
     * @var int
     *
     * @see http://xdebug.org/docs/code_coverage
     */
    public const BRANCH_HIT = 1;

    /**
     * @var bool
     */
    private $collectBranchAndPathCoverage = false;

    /**
     * @var bool
     */
    private $detectDeadCode = false;

    public function canCollectBranchAndPathCoverage(): bool
    {
        return false;
    }

    public function collectsBranchAndPathCoverage(): bool
    {
        return $this->collectBranchAndPathCoverage;
    }

    /**
     * @throws BranchAndPathCoverageNotSupportedException
     */
    public function enableBranchAndPathCoverage(): void
    {
        if (!$this->canCollectBranchAndPathCoverage()) {
            throw new BranchAndPathCoverageNotSupportedException(
                \sprintf(
                    'The %s driver does not support branch and path coverage',
                    $this->name()
                )
            );
        }

        $this->collectBranchAndPathCoverage = true;
    }

    public function disableBranchAndPathCoverage(): void
    {
        $this->collectBranchAndPathCoverage = false;
    }

    public function canDetectDeadCode(): bool
    {
        return false;
    }

    public function detectsDeadCode(): bool
    {
        return $this->detectDeadCode;
    }

    /**
     * @throws DeadCodeDetectionNotSupportedException
     */
    public function enableDeadCodeDetection(): void
    {
        if (!$this->canDetectDeadCode()) {
            throw new DeadCodeDetectionNotSupportedException(
                \sprintf(
                    'The %s driver does not support dead code detection',
                    $this->name()
                )
            );
        }

        $this->detectDeadCode = true;
    }

    public function disableDeadCodeDetection(): void
    {
        $this->detectDeadCode = false;
    }

    abstract public function name(): string;

    abstract public function start(): void;

    abstract public function stop(): RawCodeCoverageData;
}
