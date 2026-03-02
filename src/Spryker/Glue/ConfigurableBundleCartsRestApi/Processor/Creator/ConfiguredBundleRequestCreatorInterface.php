<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundleCartsRestApi\Processor\Creator;

use Generated\Shared\Transfer\CreateConfiguredBundleRequestTransfer;
use Generated\Shared\Transfer\RestConfiguredBundlesAttributesTransfer;
use Generated\Shared\Transfer\UpdateConfiguredBundleRequestTransfer;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface ConfiguredBundleRequestCreatorInterface
{
    public function createCreateConfiguredBundleRequest(
        RestRequestInterface $restRequest,
        RestConfiguredBundlesAttributesTransfer $restConfiguredBundlesAttributesTransfer
    ): ?CreateConfiguredBundleRequestTransfer;

    public function createUpdateConfiguredBundleRequest(RestRequestInterface $restRequest): UpdateConfiguredBundleRequestTransfer;
}
