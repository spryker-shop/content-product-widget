<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ContentProductWidget;

use Spryker\Shared\Twig\TwigFunctionProvider;
use Spryker\Yves\Kernel\AbstractFactory;
use SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToContentProductClientBridgeInterface;
use SprykerShop\Yves\ContentProductWidget\Dependency\Client\ContentProductWidgetToProductStorageClientBridgeInterface;
use SprykerShop\Yves\ContentProductWidget\Reader\ContentProductAbstractReader;
use SprykerShop\Yves\ContentProductWidget\Reader\ContentProductAbstractReaderInterface;
use SprykerShop\Yves\ContentProductWidget\Twig\ContentProductAbstractListTwigFunctionProvider;
use Twig\Environment;
use Twig\TwigFunction;

class ContentProductWidgetFactory extends AbstractFactory
{
    public function createContentProductAbstractListTwigFunctionProvider(Environment $twig, string $localeName): TwigFunctionProvider
    {
        return new ContentProductAbstractListTwigFunctionProvider(
            $twig,
            $localeName,
            $this->createContentProductAbstractReader(),
        );
    }

    public function createContentProductAbstractListTwigFunction(Environment $twig, string $localeName): TwigFunction
    {
        $functionProvider = $this->createContentProductAbstractListTwigFunctionProvider($twig, $localeName);

        return new TwigFunction(
            $functionProvider->getFunctionName(),
            $functionProvider->getFunction(),
            $functionProvider->getOptions(),
        );
    }

    public function createContentProductAbstractReader(): ContentProductAbstractReaderInterface
    {
        return new ContentProductAbstractReader(
            $this->getContentProductClient(),
            $this->getProductStorageClient(),
            $this->getContentProductAbstractCollectionExpanderPlugins(),
        );
    }

    /**
     * @return array<\SprykerShop\Yves\ContentProductWidget\Dependency\Plugin\ContentProductAbstractCollectionExpanderPluginInterface>
     */
    public function getContentProductAbstractCollectionExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ContentProductWidgetDependencyProvider::PLUGINS_CONTENT_PRODUCT_ABSTRACT_COLLECTION_EXPANDER);
    }

    public function getContentProductClient(): ContentProductWidgetToContentProductClientBridgeInterface
    {
        return $this->getProvidedDependency(ContentProductWidgetDependencyProvider::CLIENT_CONTENT_PRODUCT);
    }

    public function getProductStorageClient(): ContentProductWidgetToProductStorageClientBridgeInterface
    {
        return $this->getProvidedDependency(ContentProductWidgetDependencyProvider::CLIENT_PRODUCT_STORAGE);
    }
}
