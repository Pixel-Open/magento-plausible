<?php
/**
 * Copyright (C) 2023 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Plausible\CustomerData;

use PixelOpen\Plausible\Session\Goals;
use Magento\Customer\CustomerData\SectionSourceInterface;

class Plausible implements SectionSourceInterface
{
    protected Goals $goals;

    /**
     * @param Goals $goals
     */
    public function __construct(
        Goals $goals
    ) {
        $this->goals = $goals;
    }

    /**
     * @return mixed[]
     */
    public function getSectionData(): array
    {
        return [
            'goals' => $this->goals->get(true)
        ];
    }
}
