<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ConfigurableBundleCartsRestApi;

use Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToCartsRestApiFacadeBridge;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToPersistentCartFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\ConfigurableBundleCartsRestApi\ConfigurableBundleCartsRestApiConfig getConfig()
 */
class ConfigurableBundleCartsRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_PERSISTENT_CART = 'FACADE_PERSISTENT_CART';
    public const FACADE_CARTS_REST_API = 'FACADE_CARTS_REST_API';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addPersistentCartFacade($container);
        $container = $this->addCartsRestApiFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPersistentCartFacade(Container $container): Container
    {
        $container->set(static::FACADE_PERSISTENT_CART, function (Container $container) {
            return new ConfigurableBundleCartsRestApiToPersistentCartFacadeBridge($container->getLocator()->persistentCart()->facade());
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCartsRestApiFacade(Container $container): Container
    {
        $container->set(static::FACADE_CARTS_REST_API, function (Container $container) {
            return new ConfigurableBundleCartsRestApiToCartsRestApiFacadeBridge($container->getLocator()->cartsRestApi()->facade());
        });

        return $container;
    }
}