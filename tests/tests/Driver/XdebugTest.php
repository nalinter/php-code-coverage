<?php declare(strict_types=1);
/*
 * This file is part of phpunit/php-code-coverage.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianBergmann\CodeCoverage;

use SebastianBergmann\CodeCoverage\Driver\Xdebug;
use SebastianBergmann\Environment\Runtime;

class XdebugTest extends TestCase
{
    protected function setUp(): void
    {
        $runtime = new Runtime;

        if (!$runtime->hasXdebug()) {
            $this->markTestSkipped('This test is only applicable to Xdebug');
        }

        if (!xdebug_code_coverage_started()) {
            $this->markTestSkipped('This test requires code coverage to be running');
        }
    }

    public function testFilterWorks(): void
    {
        $bankAccount = TEST_FILES_PATH . 'BankAccount.php';

        require $bankAccount;
        $this->assertArrayNotHasKey($bankAccount, \xdebug_get_code_coverage());
    }

    public function testDefaultValueOfDeadCodeDetection(): void
    {
        $driver = new Xdebug(new Filter());

        $this->assertTrue($driver->detectingDeadCode());
    }

    public function testEnablingDeadCodeDetection(): void
    {
        $driver = new Xdebug(new Filter());

        $driver->detectDeadCode(true);
        $this->assertTrue($driver->detectingDeadCode());
    }

    public function testDisablingDeadCodeDetection(): void
    {
        $driver = new Xdebug(new Filter());

        $driver->detectDeadCode(false);
        $this->assertFalse($driver->detectingDeadCode());
    }

    public function testEnablingBranchAndPathCoverage(): void
    {
        $driver = new Xdebug(new Filter());

        $driver->collectBranchAndPathCoverage(true);
        $this->assertTrue($driver->collectingBranchAndPathCoverage());
    }

    public function testDisablingBranchAndPathCoverage(): void
    {
        $driver = new Xdebug(new Filter());

        $driver->collectBranchAndPathCoverage(false);
        $this->assertFalse($driver->collectingBranchAndPathCoverage());
    }
}
