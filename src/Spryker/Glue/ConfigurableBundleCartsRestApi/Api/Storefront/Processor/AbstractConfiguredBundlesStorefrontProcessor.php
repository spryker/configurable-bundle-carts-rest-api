<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ConfigurableBundleCartsRestApi\Api\Storefront\Processor;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestConfiguredBundlesAttributesTransfer;
use Spryker\ApiPlatform\State\Processor\AbstractStorefrontProcessor;
use Spryker\Client\ConfigurableBundleCartsRestApi\ConfigurableBundleCartsRestApiClientInterface;
use Spryker\Client\ConfigurableBundleStorage\ConfigurableBundleStorageClientInterface;
use Spryker\Glue\CartsRestApi\Api\Storefront\Mapper\StorefrontCartMapperInterface;
use Spryker\Glue\ConfigurableBundleCartsRestApi\Api\Storefront\Exception\ConfigurableBundleCartsExceptionFactory;
use Spryker\Service\Serializer\SerializerServiceInterface;

abstract class AbstractConfiguredBundlesStorefrontProcessor extends AbstractStorefrontProcessor
{
    protected const string KEY_CART_ID = 'cartId';

    protected const string KEY_GROUP_KEY = 'groupKey';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID
     */
    protected const string HEADER_ANONYMOUS_CUSTOMER_UNIQUE_ID = 'X-Anonymous-Customer-Unique-Id';

    public function __construct(
        protected ConfigurableBundleCartsRestApiClientInterface $configurableBundleCartsRestApiClient,
        protected ConfigurableBundleStorageClientInterface $configurableBundleStorageClient,
        protected StorefrontCartMapperInterface $cartMapper,
        protected SerializerServiceInterface $serializer,
        protected ConfigurableBundleCartsExceptionFactory $exceptionFactory,
    ) {
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function resolveCartUuid(): string
    {
        $cartUuid = $this->getUriVariables()[static::KEY_CART_ID] ?? null;

        if (!is_string($cartUuid) || $cartUuid === '') {
            throw $this->exceptionFactory->createMissingCartUuidException();
        }

        return $cartUuid;
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function resolveGroupKey(): string
    {
        $groupKey = $this->getUriVariables()[static::KEY_GROUP_KEY] ?? null;

        if (!is_string($groupKey) || $groupKey === '') {
            throw $this->exceptionFactory->createMissingGroupKeyException();
        }

        return $groupKey;
    }

    /**
     * @return array<string, mixed>
     */
    protected function buildCartResourceData(QuoteTransfer $quoteTransfer): array
    {
        $restCartsAttributesTransfer = $this->cartMapper->mapQuoteTransferToRestCartsAttributesTransfer($quoteTransfer);

        return [
            'uuid' => $quoteTransfer->getUuid(),
            ...$restCartsAttributesTransfer->toArray(true, true),
            'voucherDiscounts' => iterator_to_array($quoteTransfer->getVoucherDiscounts()),
            'cartRuleDiscounts' => iterator_to_array($quoteTransfer->getCartRuleDiscounts()),
            'promotionItems' => iterator_to_array($quoteTransfer->getPromotionItems()),
            'giftCards' => iterator_to_array($quoteTransfer->getGiftCards()),
            'bundleItems' => iterator_to_array($quoteTransfer->getBundleItems()),
            'items' => iterator_to_array($quoteTransfer->getItems()),
        ];
    }

    protected function buildAttributesFromData(mixed $data): RestConfiguredBundlesAttributesTransfer
    {
        $payload = get_object_vars($data);

        if (array_key_exists('quantity', $payload) && !is_int($payload['quantity'])) {
            unset($payload['quantity']);
        }

        return (new RestConfiguredBundlesAttributesTransfer())->fromArray(
            array_filter($payload, static fn ($value): bool => $value !== null),
            true,
        );
    }
}
