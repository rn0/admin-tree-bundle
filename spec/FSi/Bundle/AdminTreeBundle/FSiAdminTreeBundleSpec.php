<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\FSi\Bundle\AdminTreeBundle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FSiAdminTreeBundleSpec extends ObjectBehavior
{
    function it_is_bundle()
    {
        $this->shouldHaveType('Symfony\Component\HttpKernel\Bundle\Bundle');
    }
}
