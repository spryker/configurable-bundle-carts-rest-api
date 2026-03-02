<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface ConfigurableBundleCartsRestApiToCartsRestApiFacadeInterface
{
    public function createQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer;

    public function findQuoteByUuid(QuoteTransfer $quoteTransfer): QuoteResponseTransfer;

    public function getQuoteCollection(QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): QuoteCollectionTransfer;
}
