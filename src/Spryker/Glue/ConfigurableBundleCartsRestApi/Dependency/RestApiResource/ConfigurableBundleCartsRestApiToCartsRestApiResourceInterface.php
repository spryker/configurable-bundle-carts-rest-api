<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundleCartsRestApi\Dependency\RestApiResource;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface ConfigurableBundleCartsRestApiToCartsRestApiResourceInterface
{
    public function createGuestCartRestResponse(
        QuoteTransfer $quoteTransfer,
        RestRequestInterface $restRequest
    ): RestResponseInterface;

    public function createCartRestResponse(
        QuoteTransfer $quoteTransfer,
        RestRequestInterface $restRequest
    ): RestResponseInterface;
}
