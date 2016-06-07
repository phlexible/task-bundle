<?php
/**
 * phlexible
 *
 * @copyright 2007-2013 brainbits GmbH (http://www.brainbits.net)
 * @license   proprietary
 */

namespace Phlexible\Bundle\TaskBundle\Tests;

use Phlexible\Bundle\TaskBundle\PhlexibleTaskBundle;

/**
 * Task bundle test
 *
 * @author Stephan Wentz <sw@brainbits.net>
 */
class PhlexibleTaskBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testBundle()
    {
        $bundle = new PhlexibleTaskBundle();

        $this->assertSame('PhlexibleTaskBundle', $bundle->getName());
    }
}
