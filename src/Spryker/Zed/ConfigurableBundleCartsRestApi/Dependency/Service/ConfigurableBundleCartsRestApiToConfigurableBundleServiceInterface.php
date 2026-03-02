<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Service;

use Generated\Shared\Transfer\ConfiguredBundleTransfer;

interface ConfigurableBundleCartsRestApiToConfigurableBundleServiceInterface
{
    public function expandConfiguredBundleWithGroupKey(ConfiguredBundleTransfer $configuredBundleTransfer): ConfiguredBundleTransfer;
}
