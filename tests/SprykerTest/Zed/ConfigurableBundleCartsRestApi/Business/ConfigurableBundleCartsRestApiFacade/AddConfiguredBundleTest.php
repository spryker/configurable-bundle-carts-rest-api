<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ConfigurableBundleCartsRestApi\Business\ConfigurableBundleCartsRestApiFacade;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Business\Checker\QuotePermissionChecker;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Business\ConfigurableBundleCartsRestApiBusinessFactory;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToPersistentCartFacadeBridge;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ConfigurableBundleCartsRestApi
 * @group Business
 * @group ConfigurableBundleCartsRestApiFacade
 * @group AddConfiguredBundleTest
 * Add your own group annotations below this line
 */
class AddConfiguredBundleTest extends Unit
{
    /**
     * @var string
     */
    protected const FAKE_QUOTE_UUID = 'FAKE_QUOTE_UUID';

    /**
     * @uses \Spryker\Shared\CartsRestApi\CartsRestApiConfig::ERROR_IDENTIFIER_UNAUTHORIZED_CART_ACTION
     *
     * @var string
     */
    protected const ERROR_IDENTIFIER_UNAUTHORIZED_CART_ACTION = 'ERROR_IDENTIFIER_UNAUTHORIZED_CART_ACTION';

    /**
     * @uses \Spryker\Shared\ConfigurableBundleCartsRestApi\ConfigurableBundleCartsRestApiConfig::ERROR_IDENTIFIER_FAILED_ADDING_CONFIGURED_BUNDLE
     *
     * @var string
     */
    protected const ERROR_IDENTIFIER_FAILED_ADDING_CONFIGURED_BUNDLE = 'ERROR_IDENTIFIER_FAILED_ADDING_CONFIGURED_BUNDLE';

    /**
     * @var \SprykerTest\Zed\ConfigurableBundleCartsRestApi\ConfigurableBundleCartsRestApiBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddConfiguredBundleAddsConfiguredBundleToPersistentCart(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();

        // Act
        $quoteResponseTransfer = $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);

        // Assert
        $this->assertTrue($quoteResponseTransfer->getIsSuccessful());
        $this->assertCount(2, $quoteResponseTransfer->getQuoteTransfer()->getItems());

        $this->assertNotNull($quoteResponseTransfer->getQuoteTransfer()->getItems()->offsetGet(0)->getConfiguredBundle());
        $this->assertNotNull($quoteResponseTransfer->getQuoteTransfer()->getItems()->offsetGet(1)->getConfiguredBundle());
        $this->assertNotNull($quoteResponseTransfer->getQuoteTransfer()->getItems()->offsetGet(0)->getConfiguredBundleItem());
        $this->assertNotNull($quoteResponseTransfer->getQuoteTransfer()->getItems()->offsetGet(1)->getConfiguredBundleItem());
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyQuoteField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->setQuote(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyQuoteUuidField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()->setUuid(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyCustomerField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()->setCustomer(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyQuoteCustomerReferenceField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()->setCustomerReference(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyCustomerReferenceField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()->getCustomer()->setCustomerReference(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyItemsField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->setItems(new ArrayObject());

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyConfiguredBundleField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->setConfiguredBundle(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyQuantityField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getConfiguredBundle()->setQuantity(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyTemplateField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getConfiguredBundle()->setTemplate(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyTemplateUuidField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getConfiguredBundle()->getTemplate()->setUuid(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleThrowsExceptionWithEmptyTemplateNameField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getConfiguredBundle()->getTemplate()->setName(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleAddsConfiguredBundleToFakePersistentCart(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()->setUuid(static::FAKE_QUOTE_UUID);

        // Act
        $quoteResponseTransfer = $this->tester->getFacade()->addConfiguredBundle($createConfiguredBundleRequestTransfer);

        // Assert
        $this->assertFalse($quoteResponseTransfer->getIsSuccessful());
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleAddsConfiguredBundleToPersistentCartWithoutWritePermissions(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();

        /** @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ConfigurableBundleCartsRestApi\Business\ConfigurableBundleCartsRestApiBusinessFactory $configurableBundleCartsRestApiBusinessFactoryMock */
        $configurableBundleCartsRestApiBusinessFactoryMock = $this->getMockBuilder(ConfigurableBundleCartsRestApiBusinessFactory::class)
            ->onlyMethods(['createQuotePermissionChecker'])
            ->getMock();

        $configurableBundleCartsRestApiBusinessFactoryMock
            ->method('createQuotePermissionChecker')
            ->willReturn($this->getQuotePermissionCheckerMock());

        // Act
        $quoteResponseTransfer = $this->tester->getFacadeMock($configurableBundleCartsRestApiBusinessFactoryMock)
            ->addConfiguredBundle($createConfiguredBundleRequestTransfer);

        // Assert
        $this->assertFalse($quoteResponseTransfer->getIsSuccessful());
        $this->assertSame(
            static::ERROR_IDENTIFIER_UNAUTHORIZED_CART_ACTION,
            $quoteResponseTransfer->getErrors()[0]->getErrorIdentifier(),
        );
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleAddsConfiguredBundleToPersistentCartWithErrorDuringPersistentFacadeCall(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();

        /** @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ConfigurableBundleCartsRestApi\Business\ConfigurableBundleCartsRestApiBusinessFactory $configurableBundleCartsRestApiBusinessFactoryMock */
        $configurableBundleCartsRestApiBusinessFactoryMock = $this->getMockBuilder(ConfigurableBundleCartsRestApiBusinessFactory::class)
            ->onlyMethods(['getPersistentCartFacade'])
            ->getMock();

        $configurableBundleCartsRestApiBusinessFactoryMock
            ->method('getPersistentCartFacade')
            ->willReturn($this->getConfigurableBundleCartsRestApiToPersistentCartFacadeBridgeMock());

        // Act
        $quoteResponseTransfer = $this->tester->getFacadeMock($configurableBundleCartsRestApiBusinessFactoryMock)
            ->addConfiguredBundle($createConfiguredBundleRequestTransfer);

        // Assert
        $this->assertFalse($quoteResponseTransfer->getIsSuccessful());
        $this->assertSame(
            static::ERROR_IDENTIFIER_FAILED_ADDING_CONFIGURED_BUNDLE,
            $quoteResponseTransfer->getErrors()[0]->getErrorIdentifier(),
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ConfigurableBundleCartsRestApi\Business\Checker\QuotePermissionChecker
     */
    protected function getQuotePermissionCheckerMock(): QuotePermissionChecker
    {
        $quotePermissionCheckerMock = $this->getMockBuilder(QuotePermissionChecker::class)
            ->onlyMethods(['checkQuoteWritePermission'])
            ->disableOriginalConstructor()
            ->getMock();

        $quotePermissionCheckerMock
            ->method('checkQuoteWritePermission')
            ->willReturn(false);

        return $quotePermissionCheckerMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToPersistentCartFacadeBridge
     */
    protected function getConfigurableBundleCartsRestApiToPersistentCartFacadeBridgeMock(): ConfigurableBundleCartsRestApiToPersistentCartFacadeBridge
    {
        $configurableBundleCartsRestApiToPersistentCartFacadeBridgeMock = $this->getMockBuilder(ConfigurableBundleCartsRestApiToPersistentCartFacadeBridge::class)
            ->onlyMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $configurableBundleCartsRestApiToPersistentCartFacadeBridgeMock
            ->method('add')
            ->willReturn((new QuoteResponseTransfer())->setIsSuccessful(false));

        return $configurableBundleCartsRestApiToPersistentCartFacadeBridgeMock;
    }
}
