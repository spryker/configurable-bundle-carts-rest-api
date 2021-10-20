<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundleCartsRestApi\Processor\RestResponseBuilder;

use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\ConfigurableBundleCartsRestApi\Processor\Mapper\ConfiguredBundleMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

class ConfiguredBundleRestResponseBuilder implements ConfiguredBundleRestResponseBuilderInterface
{
    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilder;

    /**
     * @var \Spryker\Glue\ConfigurableBundleCartsRestApi\Processor\Mapper\ConfiguredBundleMapperInterface
     */
    protected $configuredBundleMapper;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \Spryker\Glue\ConfigurableBundleCartsRestApi\Processor\Mapper\ConfiguredBundleMapperInterface $configuredBundleMapper
     */
    public function __construct(
        RestResourceBuilderInterface $restResourceBuilder,
        ConfiguredBundleMapperInterface $configuredBundleMapper
    ) {
        $this->restResourceBuilder = $restResourceBuilder;
        $this->configuredBundleMapper = $configuredBundleMapper;
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createRestResponse(): RestResponseInterface
    {
        return $this->restResourceBuilder->createRestResponse();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteResponseTransfer $quoteResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createFailedResponse(QuoteResponseTransfer $quoteResponseTransfer): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        foreach ($quoteResponseTransfer->getErrors() as $quoteErrorTransfer) {
            $restResponse->addError(
                $this->configuredBundleMapper->mapQuoteErrorTransferToRestErrorMessageTransfer(
                    $quoteErrorTransfer,
                    new RestErrorMessageTransfer(),
                ),
            );
        }

        return $restResponse;
    }
}
