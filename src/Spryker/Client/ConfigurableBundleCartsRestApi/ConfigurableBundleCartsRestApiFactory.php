<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ConfigurableBundleCartsRestApi;

use Spryker\Client\ConfigurableBundleCartsRestApi\Dependency\Client\ConfigurableBundleCartsRestApiToZedRequestClientInterface;
use Spryker\Client\ConfigurableBundleCartsRestApi\Zed\ConfigurableBundleCartsRestApiZedStub;
use Spryker\Client\ConfigurableBundleCartsRestApi\Zed\ConfigurableBundleCartsRestApiZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class ConfigurableBundleCartsRestApiFactory extends AbstractFactory
{
    public function createConfigurableBundleCartsRestApiZedStub(): ConfigurableBundleCartsRestApiZedStubInterface
    {
        return new ConfigurableBundleCartsRestApiZedStub($this->getZedRequestClient());
    }

    public function getZedRequestClient(): ConfigurableBundleCartsRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(ConfigurableBundleCartsRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
