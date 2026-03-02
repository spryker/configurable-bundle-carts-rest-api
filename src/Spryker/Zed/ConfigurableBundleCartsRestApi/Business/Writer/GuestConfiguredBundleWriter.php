<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ConfigurableBundleCartsRestApi\Business\Writer;

use Generated\Shared\Transfer\CreateConfiguredBundleRequestTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\PersistentCartChangeTransfer;
use Generated\Shared\Transfer\QuoteCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuoteErrorTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\ConfigurableBundleCartsRestApi\ConfigurableBundleCartsRestApiConfig as ConfigurableBundleCartsRestApiSharedConfig;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Business\Checker\QuotePermissionCheckerInterface;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Business\Mapper\ConfiguredBundleMapperInterface;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToCartsRestApiFacadeInterface;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToPersistentCartFacadeInterface;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToStoreFacadeInterface;

class GuestConfiguredBundleWriter implements GuestConfiguredBundleWriterInterface
{
    /**
     * @var \Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToPersistentCartFacadeInterface
     */
    protected $persistentCartFacade;

    /**
     * @var \Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToCartsRestApiFacadeInterface
     */
    protected $cartsRestApiFacade;

    /**
     * @var \Spryker\Zed\ConfigurableBundleCartsRestApi\Business\Mapper\ConfiguredBundleMapperInterface
     */
    protected $configuredBundleMapper;

    /**
     * @var \Spryker\Zed\ConfigurableBundleCartsRestApi\Business\Checker\QuotePermissionCheckerInterface
     */
    protected $quotePermissionChecker;

    /**
     * @var \Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToStoreFacadeInterface
     */
    protected $storeFacade;

    public function __construct(
        ConfigurableBundleCartsRestApiToPersistentCartFacadeInterface $persistentCartFacade,
        ConfigurableBundleCartsRestApiToCartsRestApiFacadeInterface $cartsRestApiFacade,
        ConfiguredBundleMapperInterface $configuredBundleMapper,
        QuotePermissionCheckerInterface $quotePermissionChecker,
        ConfigurableBundleCartsRestApiToStoreFacadeInterface $storeFacade
    ) {
        $this->persistentCartFacade = $persistentCartFacade;
        $this->cartsRestApiFacade = $cartsRestApiFacade;
        $this->configuredBundleMapper = $configuredBundleMapper;
        $this->quotePermissionChecker = $quotePermissionChecker;
        $this->storeFacade = $storeFacade;
    }

    public function addConfiguredBundleToGuestCart(
        CreateConfiguredBundleRequestTransfer $createConfiguredBundleRequestTransfer
    ): QuoteResponseTransfer {
        $this->assertRequiredCreateRequestProperties($createConfiguredBundleRequestTransfer);
        $quoteResponseTransfer = $this->setCustomerQuoteUuid($createConfiguredBundleRequestTransfer->getQuoteOrFail());

        if (!$quoteResponseTransfer->getIsSuccessful()) {
            return $quoteResponseTransfer;
        }

        if (!$this->quotePermissionChecker->checkQuoteWritePermission($quoteResponseTransfer->getQuoteTransferOrFail())) {
            return $this->addQuoteErrorToResponse($quoteResponseTransfer, ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_UNAUTHORIZED_CART_ACTION);
        }

        $persistentCartChangeTransfer = $this->configuredBundleMapper->mapCreateConfiguredBundleRequestToPersistentCartChange(
            $createConfiguredBundleRequestTransfer,
            (new PersistentCartChangeTransfer())->fromArray($quoteResponseTransfer->getQuoteTransferOrFail()->toArray(), true),
        );

        $quoteResponseTransfer = $this->persistentCartFacade->add($persistentCartChangeTransfer);

        if (!$quoteResponseTransfer->getIsSuccessful()) {
            $quoteResponseTransfer = $this->addQuoteErrorToResponse($quoteResponseTransfer, ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_FAILED_ADDING_CONFIGURED_BUNDLE);
        }

        return $quoteResponseTransfer;
    }

    protected function setCustomerQuoteUuid(QuoteTransfer $quoteTransfer): QuoteResponseTransfer
    {
        $quoteResponseTransfer = (new QuoteResponseTransfer())
            ->setQuoteTransfer($quoteTransfer)
            ->setIsSuccessful(true);

        if ($quoteTransfer->getUuid()) {
            return $this->cartsRestApiFacade->findQuoteByUuid($quoteTransfer);
        }

        $quoteCriteriaFilterTransfer = (new QuoteCriteriaFilterTransfer())
            ->setCustomerReference($quoteTransfer->getCustomerOrFail()->getCustomerReference());

        $customerQuoteTransfers = $this->cartsRestApiFacade
            ->getQuoteCollection($quoteCriteriaFilterTransfer)
            ->getQuotes();

        if (!$customerQuoteTransfers->count()) {
            return $this->createGuestQuote($quoteResponseTransfer);
        }

        /** @var \Generated\Shared\Transfer\QuoteTransfer $customerQuoteTransfer */
        $customerQuoteTransfer = $customerQuoteTransfers->offsetGet(0);

        $quoteResponseTransfer->getQuoteTransferOrFail()
            ->setUuid($customerQuoteTransfer->getUuid())
            ->setIdQuote($customerQuoteTransfer->getIdQuote());

        return $quoteResponseTransfer;
    }

    protected function createGuestQuote(QuoteResponseTransfer $quoteResponseTransfer): QuoteResponseTransfer
    {
        $currentStore = $this->storeFacade->getCurrentStore();

        $quoteTransfer = $quoteResponseTransfer->getQuoteTransferOrFail()
            ->setStore($currentStore)
            ->setCurrency((new CurrencyTransfer())->setCode($currentStore->getDefaultCurrencyIsoCode()));

        return $this->cartsRestApiFacade->createQuote($quoteTransfer);
    }

    protected function assertRequiredCreateRequestProperties(CreateConfiguredBundleRequestTransfer $createConfiguredBundleRequestTransfer): void
    {
        $createConfiguredBundleRequestTransfer
            ->requireQuote()
            ->getQuoteOrFail()
                ->requireCustomer()
                ->requireCustomerReference()
                ->getCustomerOrFail()
                    ->requireCustomerReference();

        $createConfiguredBundleRequestTransfer
            ->requireItems()
            ->requireConfiguredBundle()
            ->getConfiguredBundleOrFail()
                ->requireQuantity()
                ->requireTemplate()
                ->getTemplateOrFail()
                    ->requireUuid()
                    ->requireName();
    }

    protected function addQuoteErrorToResponse(QuoteResponseTransfer $quoteResponseTransfer, string $errorIdentifier): QuoteResponseTransfer
    {
        return $quoteResponseTransfer
            ->setIsSuccessful(false)
            ->addError((new QuoteErrorTransfer())->setErrorIdentifier($errorIdentifier));
    }
}
