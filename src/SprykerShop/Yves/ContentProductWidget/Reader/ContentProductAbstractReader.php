<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ContentProductWidget\Reader;

use SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToContentProductClientBridgeInterface;
use SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToProductStorageClientBridgeInterface;

class ContentProductAbstractReader implements ContentProductAbstractReaderInterface
{
    /**
     * @param \SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToContentProductClientBridgeInterface $contentProductClient
     * @param \SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToProductStorageClientBridgeInterface $productStorageClient
     * @param array<\SprykerShop\Yves\ContentProductWidget\Dependency\Plugin\ContentProductAbstractCollectionExpanderPluginInterface> $productAbstractCollectionExpanderPlugins
     */
    public function __construct(
        protected ContentProductWidgetToContentProductClientBridgeInterface $contentProductClient,
        protected ContentProductWidgetToProductStorageClientBridgeInterface $productStorageClient,
        protected array $productAbstractCollectionExpanderPlugins
    ) {
    }

    /**
     * @param string $contentKey
     * @param string $localeName
     *
     * @return array<\Generated\Shared\Transfer\ProductViewTransfer>|null
     */
    public function findProductAbstractCollection(string $contentKey, string $localeName): ?array
    {
        $contentProductAbstractListTypeTransfer = $this->contentProductClient->executeProductAbstractListTypeByKey($contentKey, $localeName);

        if ($contentProductAbstractListTypeTransfer === null) {
            return null;
        }

        $productViewTransferCollection = $this
            ->productStorageClient
            ->getProductAbstractViewTransfers($contentProductAbstractListTypeTransfer->getIdProductAbstracts(), $localeName);

        return $this->expandProductViewTransfers($productViewTransferCollection);
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductViewTransfer> $productViewTransferCollection
     *
     * @return array<\Generated\Shared\Transfer\ProductViewTransfer>
     */
    protected function expandProductViewTransfers(array $productViewTransferCollection): array
    {
        foreach ($this->productAbstractCollectionExpanderPlugins as $collectionExpanderPlugin) {
            $productViewTransferCollection = $collectionExpanderPlugin->expand($productViewTransferCollection);
        }

        return $productViewTransferCollection;
    }
}
