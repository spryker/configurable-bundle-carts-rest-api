<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ConfigurableBundleCartsRestApi\Business\Mapper;

use Generated\Shared\Transfer\CreateConfiguredBundleRequestTransfer;
use Generated\Shared\Transfer\PersistentCartChangeTransfer;
use Generated\Shared\Transfer\UpdateConfiguredBundleRequestTransfer;

interface ConfiguredBundleMapperInterface
{
    public function mapCreateConfiguredBundleRequestToPersistentCartChange(
        CreateConfiguredBundleRequestTransfer $createConfiguredBundleRequestTransfer,
        PersistentCartChangeTransfer $persistentCartChangeTransfer
    ): PersistentCartChangeTransfer;

    public function mapUpdateConfiguredBundleRequestToPersistentCartChange(
        UpdateConfiguredBundleRequestTransfer $updateConfiguredBundleRequestTransfer,
        PersistentCartChangeTransfer $persistentCartChangeTransfer
    ): PersistentCartChangeTransfer;
}
