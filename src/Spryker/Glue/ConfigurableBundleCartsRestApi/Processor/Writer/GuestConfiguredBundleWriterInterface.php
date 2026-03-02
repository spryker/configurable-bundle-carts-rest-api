<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundleCartsRestApi\Processor\Writer;

use Generated\Shared\Transfer\RestConfiguredBundlesAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface GuestConfiguredBundleWriterInterface
{
    public function addConfiguredBundle(
        RestRequestInterface $restRequest,
        RestConfiguredBundlesAttributesTransfer $restConfiguredBundlesAttributesTransfer
    ): RestResponseInterface;

    public function updateConfiguredBundleQuantity(
        RestRequestInterface $restRequest,
        RestConfiguredBundlesAttributesTransfer $restConfiguredBundlesAttributesTransfer
    ): RestResponseInterface;

    public function deleteConfiguredBundle(RestRequestInterface $restRequest): RestResponseInterface;
}
