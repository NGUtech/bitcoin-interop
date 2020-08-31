<?php declare(strict_types=1);
/**
 * This file is part of the ngutech/bitcoin-interop project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NGUtech\Bitcoin\ValueObject;

use Daikon\ValueObject\ValueObjectList;

/**
 * @type(NGUtech\Bitcoin\ValueObject\Output)
 */
final class OutputList extends ValueObjectList
{
    public function getTotal(): Bitcoin
    {
        $value = Bitcoin::zero();
        /** @var Output $output */
        foreach ($this as $output) {
            $value = $value->add($output->getValue());
        }
        return $value;
    }
}
