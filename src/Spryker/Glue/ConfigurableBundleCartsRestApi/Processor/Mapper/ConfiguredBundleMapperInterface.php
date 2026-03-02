<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundleCartsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\CreateConfiguredBundleRequestTransfer;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\RestConfiguredBundlesAttributesTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;

interface ConfiguredBundleMapperInterface
{
    public function mapRestConfiguredBundlesAttributesToCreateConfiguredBundleRequest(
        RestConfiguredBundlesAttributesTransfer $restConfiguredBundlesAttributesTransfer,
        CreateConfiguredBundleRequestTransfer $createConfiguredBundleRequestTransfer
    ): CreateConfiguredBundleRequestTransfer;

    public function mapQuoteErrorTransferToRestErrorMessageTransfer(
        QuoteErrorTransfer $quoteErrorTransfer,
        RestErrorMessageTransfer $restErrorMessageTransfer
    ): RestErrorMessageTransfer;
}
