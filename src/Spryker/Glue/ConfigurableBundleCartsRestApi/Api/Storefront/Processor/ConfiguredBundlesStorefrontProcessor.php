<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ConfigurableBundleCartsRestApi\Api\Storefront\Processor;

use Generated\Api\Storefront\CartsStorefrontResource;
use Generated\Shared\Transfer\ConfigurableBundleTemplateSlotTransfer;
use Generated\Shared\Transfer\ConfigurableBundleTemplateTransfer;
use Generated\Shared\Transfer\ConfiguredBundleItemTransfer;
use Generated\Shared\Transfer\ConfiguredBundleTransfer;
use Generated\Shared\Transfer\CreateConfiguredBundleRequestTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\UpdateConfiguredBundleRequestTransfer;

class ConfiguredBundlesStorefrontProcessor extends AbstractConfiguredBundlesStorefrontProcessor
{
    /**
     * @param \Generated\Api\Storefront\ConfiguredBundlesStorefrontResource $data
     *
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     *
     * @return \Generated\Api\Storefront\CartsStorefrontResource
     */
    protected function processPost(mixed $data): mixed
    {
        $cartUuid = $this->resolveCartUuid();
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

        $customerTransfer = $this->getCustomer();

        $quoteTransfer = (new QuoteTransfer())
            ->setCustomer($customerTransfer)
            ->setCustomerReference($customerTransfer->getCustomerReferenceOrFail())
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

        $quoteResponseTransfer = $this->configurableBundleCartsRestApiClient->addConfiguredBundle($createConfiguredBundleRequestTransfer);

        if (!$quoteResponseTransfer->getIsSuccessful()) {
            throw $this->exceptionFactory->createExceptionFromQuoteResponse($quoteResponseTransfer);
        }

        return $this->mapQuoteTransferToCartsResource($quoteResponseTransfer->getQuoteTransferOrFail());
    }

    /**
     * @param \Generated\Api\Storefront\ConfiguredBundlesStorefrontResource $data
     *
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     *
     * @return \Generated\Api\Storefront\CartsStorefrontResource
     */
    protected function processPatch(mixed $data): mixed
    {
        $cartUuid = $this->resolveCartUuid();
        $groupKey = $this->resolveGroupKey();
        $restConfiguredBundlesAttributesTransfer = $this->buildAttributesFromData($data);

        if (!is_int($restConfiguredBundlesAttributesTransfer->getQuantity()) || $restConfiguredBundlesAttributesTransfer->getQuantity() <= 0) {
            throw $this->exceptionFactory->createWrongQuantityException();
        }

        $customerTransfer = $this->getCustomer();

        $quoteTransfer = (new QuoteTransfer())
            ->setCustomer($customerTransfer)
            ->setCustomerReference($customerTransfer->getCustomerReferenceOrFail())
            ->setUuid($cartUuid);

        $updateConfiguredBundleRequestTransfer = (new UpdateConfiguredBundleRequestTransfer())
            ->setQuote($quoteTransfer)
            ->setGroupKey($groupKey)
            ->setQuantity($restConfiguredBundlesAttributesTransfer->getQuantity());

        $quoteResponseTransfer = $this->configurableBundleCartsRestApiClient->updateConfiguredBundleQuantity($updateConfiguredBundleRequestTransfer);

        if (!$quoteResponseTransfer->getIsSuccessful()) {
            throw $this->exceptionFactory->createExceptionFromQuoteResponse($quoteResponseTransfer);
        }

        return $this->mapQuoteTransferToCartsResource($quoteResponseTransfer->getQuoteTransferOrFail());
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function processDelete(): mixed
    {
        $cartUuid = $this->resolveCartUuid();
        $groupKey = $this->resolveGroupKey();

        $customerTransfer = $this->getCustomer();

        $quoteTransfer = (new QuoteTransfer())
            ->setCustomer($customerTransfer)
            ->setCustomerReference($customerTransfer->getCustomerReferenceOrFail())
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

    protected function mapQuoteTransferToCartsResource(QuoteTransfer $quoteTransfer): CartsStorefrontResource
    {
        return $this->serializer->denormalize(
            $this->buildCartResourceData($quoteTransfer),
            CartsStorefrontResource::class,
        );
    }
}
