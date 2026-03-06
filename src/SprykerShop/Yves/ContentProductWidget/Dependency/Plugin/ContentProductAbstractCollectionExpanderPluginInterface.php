<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types = 1);

namespace SprykerShop\Yves\ContentProductWidget\Dependency\Plugin;

interface ContentProductAbstractCollectionExpanderPluginInterface
{
    /**
     * Specification:
     * - Expands the product abstract view collection with additional data.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\ProductViewTransfer> $productViewTransfers
     *
     * @return array<\Generated\Shared\Transfer\ProductViewTransfer>
     */
    public function expand(array $productViewTransfers): array;
}
