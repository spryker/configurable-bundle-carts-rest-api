<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ConfigurableBundleCartsRestApi\Business\Writer;

use Generated\Shared\Transfer\CreateConfiguredBundleRequestTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\UpdateConfiguredBundleRequestTransfer;

interface ConfiguredBundleWriterInterface
{
    public function addConfiguredBundle(
        CreateConfiguredBundleRequestTransfer $createConfiguredBundleRequestTransfer
    ): QuoteResponseTransfer;

    public function updateConfiguredBundleQuantity(
        UpdateConfiguredBundleRequestTransfer $updateConfiguredBundleRequestTransfer
    ): QuoteResponseTransfer;

    public function removeConfiguredBundle(
        UpdateConfiguredBundleRequestTransfer $updateConfiguredBundleRequestTransfer
    ): QuoteResponseTransfer;
}
