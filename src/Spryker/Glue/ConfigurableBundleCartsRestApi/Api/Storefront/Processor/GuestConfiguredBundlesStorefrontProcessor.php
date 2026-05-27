<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ConfigurableBundleCartsRestApi\Api\Storefront\Processor;

use Generated\Api\Storefront\GuestCartsStorefrontResource;
use Generated\Shared\Transfer\ConfigurableBundleTemplateSlotTransfer;
use Generated\Shared\Transfer\ConfigurableBundleTemplateTransfer;
use Generated\Shared\Transfer\ConfiguredBundleItemTransfer;
use Generated\Shared\Transfer\ConfiguredBundleTransfer;
use Generated\Shared\Transfer\CreateConfiguredBundleRequestTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\UpdateConfiguredBundleRequestTransfer;

class GuestConfiguredBundlesStorefrontProcessor extends AbstractConfiguredBundlesStorefrontProcessor
{
    /**
     * @uses \Spryker\Shared\PersistentCart\PersistentCartConfig::PERSISTENT_CART_ANONYMOUS_PREFIX
     */
    protected const string ANONYMOUS_CUSTOMER_REFERENCE_PREFIX = 'anonymous:';

    /**
     * @param \Generated\Api\Storefront\GuestConfiguredBundlesStorefrontResource $data
     *
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     *
     * @return \Generated\Api\Storefront\GuestCartsStorefrontResource
     */
    protected function processPost(mixed $data): mixed
    {
        $anonymousCustomerReference = $this->getAnonymousCustomerReference();
        // Cart UUID is not validated upfront — legacy addConfiguredBundle passed it through as-is.
        // An invalid/empty cart UUID is detected later by the PersistentCart service (returns 4001).
        $cartUuid = (string)($this->getUriVariables()[static::KEY_CART_ID] ?? '');
        $restConfiguredBundlesAttributesTransfer = $this->buildAttributesFromData($data);

        if (!is_int($restConfiguredBundlesAttributesTransfer->getQuantity()) || $restConfiguredBundlesAttributesTransfer->getQuantity() <= 0) {
            throw $this->exceptionFactory->createWrongQuantityException();
        }

        $configurableBundleTemplateStorageTransfer = $this->configurableBundleStorageClient->findConfigurableBundleTemplateStorageByUuid(
            $restConfiguredBundlesAttributesTransfer->getTemplateUuidOrFail(),
            $this->getLocale()->getLocaleNameOrFail(),
        );

        if ($configurableBundleTemplateStorageTransfer === null) {
            throw $this->exceptionFactory->createTemplateNotFoundException();
        }

        $customerTransfer = (new CustomerTransfer())
            ->setCustomerReference($anonymousCustomerReference);

        $quoteTransfer = (new QuoteTransfer())
            ->setCustomer($customerTransfer)
            ->setCustomerReference($anonymousCustomerReference)
            ->setUuid($cartUuid);

        $configurableBundleTemplateTransfer = (new ConfigurableBundleTemplateTransfer())->fromArray(
            $configurableBundleTemplateStorageTransfer->toArray(),
            true,
        );

        $createConfiguredBundleRequestTransfer = (new CreateConfiguredBundleRequestTransfer())
            ->setQuote($quoteTransfer)
            ->setConfiguredBundle(
                (new ConfiguredBundleTransfer())
                    ->setTemplate($configurableBundleTemplateTransfer)
                    ->setQuantity($restConfiguredBundlesAttributesTransfer->getQuantity()),
            );

        foreach ($restConfiguredBundlesAttributesTransfer->getItems() as $restConfiguredBundleItemsAttributesTransfer) {
            $configuredBundleItemTransfer = (new ConfiguredBundleItemTransfer())
                ->setSlot((new ConfigurableBundleTemplateSlotTransfer())->setUuid($restConfiguredBundleItemsAttributesTransfer->getSlotUuid()));

            $itemTransfer = (new ItemTransfer())
                ->fromArray($restConfiguredBundleItemsAttributesTransfer->toArray(), true)
                ->setConfiguredBundleItem($configuredBundleItemTransfer);

            $createConfiguredBundleRequestTransfer->addItem($itemTransfer);
        }

        $quoteResponseTransfer = $this->configurableBundleCartsRestApiClient->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);

        if (!$quoteResponseTransfer->getIsSuccessful()) {
            throw $this->exceptionFactory->createExceptionFromQuoteResponse($quoteResponseTransfer);
        }

        return $this->mapQuoteTransferToGuestCartsResource($quoteResponseTransfer->getQuoteTransferOrFail());
    }

    /**
     * @param \Generated\Api\Storefront\GuestConfiguredBundlesStorefrontResource $data
     *
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     *
     * @return \Generated\Api\Storefront\GuestCartsStorefrontResource
     */
    protected function processPatch(mixed $data): mixed
    {
        $cartUuid = $this->resolveCartUuid();
        $groupKey = $this->resolveGroupKey();
        $anonymousCustomerReference = $this->getAnonymousCustomerReference();
        $restConfiguredBundlesAttributesTransfer = $this->buildAttributesFromData($data);

        if (!is_int($restConfiguredBundlesAttributesTransfer->getQuantity()) || $restConfiguredBundlesAttributesTransfer->getQuantity() <= 0) {
            throw $this->exceptionFactory->createWrongQuantityException();
        }

        $customerTransfer = (new CustomerTransfer())
            ->setCustomerReference($anonymousCustomerReference);

        $quoteTransfer = (new QuoteTransfer())
            ->setCustomer($customerTransfer)
            ->setCustomerReference($anonymousCustomerReference)
            ->setUuid($cartUuid);

        $updateConfiguredBundleRequestTransfer = (new UpdateConfiguredBundleRequestTransfer())
            ->setQuote($quoteTransfer)
            ->setGroupKey($groupKey)
            ->setQuantity($restConfiguredBundlesAttributesTransfer->getQuantity());

        $quoteResponseTransfer = $this->configurableBundleCartsRestApiClient->updateConfiguredBundleQuantity($updateConfiguredBundleRequestTransfer);

        if (!$quoteResponseTransfer->getIsSuccessful()) {
            throw $this->exceptionFactory->createExceptionFromQuoteResponse($quoteResponseTransfer);
        }

        return $this->mapQuoteTransferToGuestCartsResource($quoteResponseTransfer->getQuoteTransferOrFail());
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function processDelete(): mixed
    {
        $cartUuid = $this->resolveCartUuid();
        $groupKey = $this->resolveGroupKey();
        $anonymousCustomerReference = $this->getAnonymousCustomerReference();

        $customerTransfer = (new CustomerTransfer())
            ->setCustomerReference($anonymousCustomerReference);

        $quoteTransfer = (new QuoteTransfer())
            ->setCustomer($customerTransfer)
            ->setCustomerReference($anonymousCustomerReference)
            ->setUuid($cartUuid);

        $updateConfiguredBundleRequestTransfer = (new UpdateConfiguredBundleRequestTransfer())
            ->setQuote($quoteTransfer)
            ->setGroupKey($groupKey);

        $quoteResponseTransfer = $this->configurableBundleCartsRestApiClient->removeConfiguredBundle($updateConfiguredBundleRequestTransfer);

        if (!$quoteResponseTransfer->getIsSuccessful()) {
            throw $this->exceptionFactory->createExceptionFromQuoteResponse($quoteResponseTransfer);
        }

        return null;
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function getAnonymousCustomerReference(): string
    {
        $anonymousCustomerUniqueId = $this->getRequest()->headers->get(
            static::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID,
        );

        if ($anonymousCustomerUniqueId === null || $anonymousCustomerUniqueId === '') {
            throw $this->exceptionFactory->createMissingAnonymousCustomerIdException();
        }

        return static::ANONYMOUS_CUSTOMER_REFERENCE_PREFIX . $anonymousCustomerUniqueId;
    }

    protected function mapQuoteTransferToGuestCartsResource(QuoteTransfer $quoteTransfer): GuestCartsStorefrontResource
    {
        return $this->serializer->denormalize(
            $this->buildCartResourceData($quoteTransfer),
            GuestCartsStorefrontResource::class,
        );
    }
}
