<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ConfigurableBundleCartsRestApi;

use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\Glue\Kernel\AbstractBundleConfig;
use Spryker\Shared\ConfigurableBundleCartsRestApi\ConfigurableBundleCartsRestApiConfig as ConfigurableBundleCartsRestApiSharedConfig;
use Symfony\Component\HttpFoundation\Response;

class ConfigurableBundleCartsRestApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_CONFIGURED_BUNDLES = 'configured-bundles';

    /**
     * @var string
     */
    public const RESOURCE_GUEST_CONFIGURED_BUNDLES = 'guest-configured-bundles';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESOURCE_CARTS
     *
     * @var string
     */
    public const RESOURCE_CARTS = 'carts';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESOURCE_GUEST_CARTS
     *
     * @var string
     */
    public const RESOURCE_GUEST_CARTS = 'guest-carts';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESPONSE_CODE_CART_ID_MISSING
     *
     * @var string
     */
    public const RESPONSE_CODE_CART_ID_MISSING = '104';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::RESPONSE_CODE_UNAUTHORIZED_CART_ACTION
     *
     * @var string
     */
    public const RESPONSE_CODE_UNAUTHORIZED_CART_ACTION = '115';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CONFIGURED_BUNDLE_VALIDATION = '4001';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND = '4002';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CONFIGURED_BUNDLE_WRONG_QUANTITY = '4003';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CONFIGURED_BUNDLE_NOT_FOUND = '4004';

    /**
     * @var string
     */
    public const RESPONSE_CODE_FAILED_ADDING_CONFIGURED_BUNDLE = '4005';

    /**
     * @var string
     */
    public const RESPONSE_CODE_FAILED_UPDATING_CONFIGURED_BUNDLE = '4006';

    /**
     * @var string
     */
    public const RESPONSE_CODE_FAILED_REMOVING_CONFIGURED_BUNDLE = '4007';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::EXCEPTION_MESSAGE_CART_ID_MISSING
     *
     * @var string
     */
    public const RESPONSE_DETAILS_CART_ID_MISSING = 'Cart uuid is missing.';

    /**
     * @uses \Spryker\Glue\CartsRestApi\CartsRestApiConfig::EXCEPTION_MESSAGE_UNAUTHORIZED_CART_ACTION
     *
     * @var string
     */
    public const RESPONSE_DETAILS_UNAUTHORIZED_CART_ACTION = 'Unauthorized cart action.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_CONFIGURED_BUNDLE_VALIDATION = 'There was a problem adding or updating the configured bundle.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND = 'Configurable bundle template not found.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_CONFIGURED_BUNDLE_WRONG_QUANTITY = 'The quantity of the configured bundle should be more than zero.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_CONFIGURED_BUNDLE_NOT_FOUND = 'Configured bundle with provided group key not found in cart.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_FAILED_ADDING_CONFIGURED_BUNDLE = 'The configured bundle could not be added.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_FAILED_UPDATING_CONFIGURED_BUNDLE = 'The configured bundle could not be updated.';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_FAILED_REMOVING_CONFIGURED_BUNDLE = 'The configured bundle could not be removed.';

    /**
     * @api
     *
     * @return array<string, array<string, mixed>>
     */
    public function getErrorIdentifierToRestErrorMapping(): array
    {
        return [
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_FAILED_CART_ID_MISSING => [
                RestErrorMessageTransfer::CODE => static::RESPONSE_CODE_CART_ID_MISSING,
                RestErrorMessageTransfer::STATUS => Response::HTTP_BAD_REQUEST,
                RestErrorMessageTransfer::DETAIL => static::RESPONSE_DETAILS_CART_ID_MISSING,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_UNAUTHORIZED_CART_ACTION => [
                RestErrorMessageTransfer::CODE => static::RESPONSE_CODE_UNAUTHORIZED_CART_ACTION,
                RestErrorMessageTransfer::STATUS => Response::HTTP_FORBIDDEN,
                RestErrorMessageTransfer::DETAIL => static::RESPONSE_DETAILS_UNAUTHORIZED_CART_ACTION,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND => [
                RestErrorMessageTransfer::CODE => static::RESPONSE_CODE_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND,
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                RestErrorMessageTransfer::DETAIL => static::RESPONSE_DETAILS_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_CONFIGURED_BUNDLE_WRONG_QUANTITY => [
                RestErrorMessageTransfer::CODE => static::RESPONSE_CODE_CONFIGURED_BUNDLE_WRONG_QUANTITY,
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                RestErrorMessageTransfer::DETAIL => static::RESPONSE_DETAILS_CONFIGURED_BUNDLE_WRONG_QUANTITY,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_CONFIGURED_BUNDLE_NOT_FOUND => [
                RestErrorMessageTransfer::CODE => static::RESPONSE_CODE_CONFIGURED_BUNDLE_NOT_FOUND,
                RestErrorMessageTransfer::STATUS => Response::HTTP_BAD_REQUEST,
                RestErrorMessageTransfer::DETAIL => static::RESPONSE_DETAILS_CONFIGURED_BUNDLE_NOT_FOUND,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_FAILED_ADDING_CONFIGURED_BUNDLE => [
                RestErrorMessageTransfer::CODE => static::RESPONSE_CODE_FAILED_ADDING_CONFIGURED_BUNDLE,
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                RestErrorMessageTransfer::DETAIL => static::RESPONSE_DETAILS_FAILED_ADDING_CONFIGURED_BUNDLE,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_FAILED_UPDATING_CONFIGURED_BUNDLE => [
                RestErrorMessageTransfer::CODE => static::RESPONSE_CODE_FAILED_UPDATING_CONFIGURED_BUNDLE,
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                RestErrorMessageTransfer::DETAIL => static::RESPONSE_DETAILS_FAILED_UPDATING_CONFIGURED_BUNDLE,
            ],
            ConfigurableBundleCartsRestApiSharedConfig::ERROR_IDENTIFIER_FAILED_REMOVING_CONFIGURED_BUNDLE => [
                RestErrorMessageTransfer::CODE => static::RESPONSE_CODE_FAILED_REMOVING_CONFIGURED_BUNDLE,
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                RestErrorMessageTransfer::DETAIL => static::RESPONSE_DETAILS_FAILED_REMOVING_CONFIGURED_BUNDLE,
            ],
        ];
    }
}
