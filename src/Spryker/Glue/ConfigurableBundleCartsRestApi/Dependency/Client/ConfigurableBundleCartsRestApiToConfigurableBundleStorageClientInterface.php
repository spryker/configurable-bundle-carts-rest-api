<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundleCartsRestApi\Dependency\Client;

use Generated\Shared\Transfer\ConfigurableBundleTemplateStorageTransfer;

interface ConfigurableBundleCartsRestApiToConfigurableBundleStorageClientInterface
{
    public function findConfigurableBundleTemplateStorageByUuid(
        string $configurableBundleTemplateUuid,
        string $localeName
    ): ?ConfigurableBundleTemplateStorageTransfer;
}
