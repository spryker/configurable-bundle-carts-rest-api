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

class ConfigurableBundleCartsRestApiToCartsRestApiFacadeBridge implements ConfigurableBundleCartsRestApiToCartsRestApiFacadeInterface
{
    /**
     * @var \Spryker\Zed\CartsRestApi\Business\CartsRestApiFacadeInterface
     */
    protected $cartsRestApiFacade;

    /**
     * @param \Spryker\Zed\CartsRestApi\Business\CartsRestApiFacadeInterface $cartsRestApiFacade
     */
    public function __construct($cartsRestApiFacade)
    {
        $this->cartsRestApiFacade = $cartsRestApiFacade;
    }

    public function createQuote(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        return $this->cartsRestApiFacade->createQuote($quoteTransfer);
    }

    public function findQuoteByUuid(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        return $this->cartsRestApiFacade->findQuoteByUuid($quoteTransfer);
    }

    public function getQuoteCollection(QuoteCriteriaFilterTransfer $quoteCriteriaFilterTransfer): QuoteCollectionTransfer
    {
        return $this->cartsRestApiFacade->getQuoteCollection($quoteCriteriaFilterTransfer);
    }
}
