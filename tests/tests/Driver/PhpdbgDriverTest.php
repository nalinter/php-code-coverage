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
use SebastianBergmann\CodeCoverage\TestCase;

final class PhpdbgDriverTest extends TestCase
{
    protected function setUp(): void
    {
        if (\PHP_SAPI !== 'phpdbg') {
            $this->markTestSkipped('This test requires the PHPDBG commandline interpreter');
        }
    }

    public function testDefaultValueOfDeadCodeDetection(): void
    {
        $driver = new PhpdbgDriver;

        $this->assertFalse($driver->detectsDeadCode());
    }

    public function testEnablingDeadCodeDetection(): void
    {
        $this->expectException(DeadCodeDetectionNotSupportedException::class);

        $driver = new PhpdbgDriver;

        $driver->enableDeadCodeDetection();
    }

    public function testDisablingDeadCodeDetection(): void
    {
        $driver = new PhpdbgDriver;

        $driver->disableDeadCodeDetection();

        $this->assertFalse($driver->detectsDeadCode());
    }

    public function testEnablingBranchAndPathCoverage(): void
    {
        $this->expectException(BranchAndPathCoverageNotSupportedException::class);

        $driver = new PhpdbgDriver;

        $driver->enableBranchAndPathCoverage();

        $this->assertTrue($driver->collectsBranchAndPathCoverage());
    }

    public function testDisablingBranchAndPathCoverage(): void
    {
        $driver = new PhpdbgDriver;

        $driver->disableBranchAndPathCoverage();

        $this->assertFalse($driver->collectsBranchAndPathCoverage());
    }
}
