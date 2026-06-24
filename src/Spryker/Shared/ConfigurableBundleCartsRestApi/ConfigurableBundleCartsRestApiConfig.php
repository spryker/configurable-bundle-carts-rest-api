<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\ConfigurableBundleCartsRestApi;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class ConfigurableBundleCartsRestApiConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @uses \Spryker\Shared\CartsRestApi\CartsRestApiConfig::ERROR_IDENTIFIER_UNAUTHORIZED_CART_ACTION
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_UNAUTHORIZED_CART_ACTION = 'ERROR_IDENTIFIER_UNAUTHORIZED_CART_ACTION';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_FAILED_CART_ID_MISSING = 'ERROR_IDENTIFIER_FAILED_CART_ID_MISSING';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND = 'ERROR_IDENTIFIER_CONFIGURABLE_BUNDLE_TEMPLATE_NOT_FOUND';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_CONFIGURED_BUNDLE_WRONG_QUANTITY = 'ERROR_IDENTIFIER_CONFIGURED_BUNDLE_WRONG_QUANTITY';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_CONFIGURED_BUNDLE_NOT_FOUND = 'ERROR_IDENTIFIER_CONFIGURED_BUNDLE_NOT_FOUND';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_FAILED_ADDING_CONFIGURED_BUNDLE = 'ERROR_IDENTIFIER_FAILED_ADDING_CONFIGURED_BUNDLE';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_FAILED_UPDATING_CONFIGURED_BUNDLE = 'ERROR_IDENTIFIER_FAILED_UPDATING_CONFIGURED_BUNDLE';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_FAILED_REMOVING_CONFIGURED_BUNDLE = 'ERROR_IDENTIFIER_FAILED_REMOVING_CONFIGURED_BUNDLE';
}
