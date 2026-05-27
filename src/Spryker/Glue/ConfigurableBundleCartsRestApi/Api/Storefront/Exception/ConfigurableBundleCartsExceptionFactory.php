<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ConfigurableBundleCartsRestApi\Api\Storefront\Exception;

use Generated\Shared\Transfer\QuoteResponseTransfer;
use Spryker\ApiPlatform\Exception\GlueApiException;
use Spryker\Glue\CartsRestApi\CartsRestApiConfig;
use Spryker\Glue\ConfigurableBundleCartsRestApi\ConfigurableBundleCartsRestApiConfig;
use Spryker\Shared\ConfigurableBundleCartsRestApi\ConfigurableBundleCartsRestApiConfig as ConfigurableBundleCartsRestApiSharedConfig;
use Symfony\Component\HttpFoundation\Response;

class ConfigurableBundleCartsExceptionFactory
{
    public function createMissingCartUuidException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_BAD_REQUEST,
            ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_CART_ID_MISSING,
            ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_CART_ID_MISSING,
        );
    }

    public function createMissingGroupKeyException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_BAD_REQUEST,
            ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_CONFIGURED_BUNDLE_NOT_FOUND,
            ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_CONFIGURED_BUNDLE_NOT_FOUND,
        );
    }

    public function createMissingAnonymousCustomerIdException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_BAD_REQUEST,
            CartsRestApiConfig::RESPONSE_CODE_ANONYMOUS_CUSTOMER_UNIQUE_ID_EMPTY,
            CartsRestApiConfig::EXCEPTION_MESSAGE_ANONYMOUS_CUSTOMER_UNIQUE_ID_EMPTY,
        );
    }

    public function createWrongQuantityException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_CONFIGURED_BUNDLE_WRONG_QUANTITY,
            ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_CONFIGURED_BUNDLE_WRONG_QUANTITY,
        );
    }

    public function createTemplateNotFoundException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND,
            ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND,
        );
    }

    public function createExceptionFromQuoteResponse(QuoteResponseTransfer $quoteResponseTransfer): GlueApiException
    {
        $errorMapping = $this->buildErrorIdentifierToExceptionMapping();

        foreach ($quoteResponseTransfer->getErrors() as $quoteErrorTransfer) {
            $errorIdentifier = $quoteErrorTransfer->getErrorIdentifier();

            if ($errorIdentifier !== null && isset($errorMapping[$errorIdentifier])) {
                [$status, $code, $detail] = $errorMapping[$errorIdentifier];

                return new GlueApiException($status, $code, $detail);
            }

            // First error with no recognised identifier mirrors the legacy fallback that
            // returned code 4001 with the original error message (e.g. product-not-found
            // errors from PersistentCart that carry no ConfigurableBundle error identifier).
            return new GlueApiException(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_CONFIGURED_BUNDLE_VALIDATION,
                $quoteErrorTransfer->getMessage() ?? ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_CONFIGURED_BUNDLE_VALIDATION,
            );
        }

        return new GlueApiException(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_CONFIGURED_BUNDLE_VALIDATION,
            ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_CONFIGURED_BUNDLE_VALIDATION,
        );
    }

    /**
     * @return array<string, array{int, string, string}>
     */
    protected function buildErrorIdentifierToExceptionMapping(): array
    {
        return [
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_FAILED_CART_ID_MISSING => [
                Response::HTTP_BAD_REQUEST,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_CART_ID_MISSING,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_CART_ID_MISSING,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_UNAUTHORIZED_CART_ACTION => [
                Response::HTTP_FORBIDDEN,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_UNAUTHORIZED_CART_ACTION,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_UNAUTHORIZED_CART_ACTION,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND => [
                Response::HTTP_UNPROCESSABLE_ENTITY,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_CONFIGURED_BUNDLE_WRONG_QUANTITY => [
                Response::HTTP_UNPROCESSABLE_ENTITY,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_CONFIGURED_BUNDLE_WRONG_QUANTITY,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_CONFIGURED_BUNDLE_WRONG_QUANTITY,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_CONFIGURED_BUNDLE_NOT_FOUND => [
                Response::HTTP_BAD_REQUEST,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_CONFIGURED_BUNDLE_NOT_FOUND,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_CONFIGURED_BUNDLE_NOT_FOUND,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_FAILED_ADDING_CONFIGURED_BUNDLE => [
                Response::HTTP_UNPROCESSABLE_ENTITY,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_FAILED_ADDING_CONFIGURED_BUNDLE,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_FAILED_ADDING_CONFIGURED_BUNDLE,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_FAILED_UPDATING_CONFIGURED_BUNDLE => [
                Response::HTTP_UNPROCESSABLE_ENTITY,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_FAILED_UPDATING_CONFIGURED_BUNDLE,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_FAILED_UPDATING_CONFIGURED_BUNDLE,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_FAILED_REMOVING_CONFIGURED_BUNDLE => [
                Response::HTTP_UNPROCESSABLE_ENTITY,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_CODE_FAILED_REMOVING_CONFIGURED_BUNDLE,
                ConfigurableBundleCartsRestApiConfig::RESPONSE_DETAILS_FAILED_REMOVING_CONFIGURED_BUNDLE,
            ],
        ];
    }
}
