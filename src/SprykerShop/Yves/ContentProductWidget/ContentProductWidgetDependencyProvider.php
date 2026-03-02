<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ContentProductWidget;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToContentProductClientBridge;
use SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToProductStorageClientBridge;

class ContentProductWidgetDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_PRODUCT_STORAGE = 'CLIENT_PRODUCT_STORAGE';

    /**
     * @var string
     */
    public const CLIENT_CONTENT_PRODUCT = 'CLIENT_CONTENT_PRODUCT';

    public function provideDependencies(Container $container): Container
    {
        $container = $this->addContentProductClient($container);
        $container = $this->addProductStorageClient($container);

        return $container;
    }

    protected function addContentProductClient(Container $container): Container
    {
        $container->set(static::CLIENT_CONTENT_PRODUCT, function (Container $container) {
            return new ContentProductWidgetToContentProductClientBridge($container->getLocator()->contentProduct()->client());
        });

        return $container;
    }

    protected function addProductStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_PRODUCT_STORAGE, function (Container $container) {
            return new ContentProductWidgetToProductStorageClientBridge($container->getLocator()->productStorage()->client());
        });

        return $container;
    }
}
