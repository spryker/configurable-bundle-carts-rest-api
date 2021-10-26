<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ConfigurableBundleCartsRestApi\Business\ConfigurableBundleCartsRestApiFacade;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteResponseTransfer;
use Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Business\Checker\QuotePermissionChecker;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Business\ConfigurableBundleCartsRestApiBusinessFactory;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToCartsRestApiFacadeBridge;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToCartsRestApiFacadeInterface;
use Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToPersistentCartFacadeBridge;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ConfigurableBundleCartsRestApi
 * @group Business
 * @group ConfigurableBundleCartsRestApiFacade
 * @group AddConfiguredBundleToGuestCartTest
 * Add your own group annotations below this line
 */
class AddConfiguredBundleToGuestCartTest extends Unit
{
    /**
     * @var string
     */
    protected const FAKE_QUOTE_UUID = 'FAKE_QUOTE_UUID';

    /**
     * @var string
     */
    protected const FAKE_CUSTOMER_REFERENCE = 'FAKE_CUSTOMER_REFERENCE';

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
    public function testAddConfiguredBundleToGuestCartAddsConfiguredBundleToPersistentCart(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();

        // Act
        $quoteResponseTransfer = $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);

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
    public function testAddConfiguredBundleToGuestCartThrowsExceptionWithEmptyQuoteField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->setQuote(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartAddsConfiguredBundleToPersistentCartWithoutQuoteUuid(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()
            ->setUuid(null)
            ->setIdQuote(null);

        // Act
        $quoteResponseTransfer = $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);

        // Assert
        $this->assertTrue($quoteResponseTransfer->getIsSuccessful());
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartAddsConfiguredBundleToPersistentCartWithoutQuoteUuidForNewCustomer(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()
            ->setIdQuote(null)
            ->setUuid(null)
            ->setCustomerReference(static::FAKE_CUSTOMER_REFERENCE)
            ->setCustomer((new CustomerTransfer())->setCustomerReference(static::FAKE_CUSTOMER_REFERENCE));

        // Act
        $quoteResponseTransfer = $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);

        // Assert
        $this->assertTrue($quoteResponseTransfer->getIsSuccessful());
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartAddsConfiguredBundleToPersistentCartWithoutQuoteUuidWhenCartCreationIsNotSuccessful(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()
            ->setIdQuote(null)
            ->setUuid(null)
            ->setCustomerReference(static::FAKE_CUSTOMER_REFERENCE)
            ->setCustomer((new CustomerTransfer())->setCustomerReference(static::FAKE_CUSTOMER_REFERENCE));

        /** @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ConfigurableBundleCartsRestApi\Business\ConfigurableBundleCartsRestApiBusinessFactory $configurableBundleCartsRestApiBusinessFactoryMock */
        $configurableBundleCartsRestApiBusinessFactoryMock = $this->getMockBuilder(ConfigurableBundleCartsRestApiBusinessFactory::class)
            ->onlyMethods(['getCartsRestApiFacade'])
            ->getMock();

        $configurableBundleCartsRestApiBusinessFactoryMock
            ->method('getCartsRestApiFacade')
            ->willReturn($this->getConfigurableBundleCartsRestApiToCartsRestApiFacadeBridgeMock());

        // Act
        $quoteResponseTransfer = $this->tester->getFacadeMock($configurableBundleCartsRestApiBusinessFactoryMock)
            ->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);

        // Assert
        $this->assertFalse($quoteResponseTransfer->getIsSuccessful());
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartThrowsExceptionWithEmptyCustomerField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()->setCustomer(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartThrowsExceptionWithEmptyQuoteCustomerReferenceField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()->setCustomerReference(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartThrowsExceptionWithEmptyCustomerReferenceField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()->getCustomer()->setCustomerReference(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartThrowsExceptionWithEmptyItemsField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->setItems(new ArrayObject());

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartThrowsExceptionWithEmptyConfiguredBundleField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->setConfiguredBundle(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartThrowsExceptionWithEmptyQuantityField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getConfiguredBundle()->setQuantity(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartThrowsExceptionWithEmptyTemplateField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getConfiguredBundle()->setTemplate(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartThrowsExceptionWithEmptyTemplateUuidField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getConfiguredBundle()->getTemplate()->setUuid(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartThrowsExceptionWithEmptyTemplateNameField(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getConfiguredBundle()->getTemplate()->setName(null);

        // Assert
        $this->expectException(RequiredTransferPropertyException::class);

        // Act
        $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartAddsConfiguredBundleToFakePersistentCart(): void
    {
        // Arrange
        $createConfiguredBundleRequestTransfer = $this->tester->buildCreateConfiguredBundleRequest();
        $createConfiguredBundleRequestTransfer->getQuote()->setUuid(static::FAKE_QUOTE_UUID);

        // Act
        $quoteResponseTransfer = $this->tester->getFacade()->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);

        // Assert
        $this->assertFalse($quoteResponseTransfer->getIsSuccessful());
    }

    /**
     * @return void
     */
    public function testAddConfiguredBundleToGuestCartAddsConfiguredBundleToPersistentCartWithoutWritePermissions(): void
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
            ->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);

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
    public function testAddConfiguredBundleToGuestCartAddsConfiguredBundleToPersistentCartWithErrorDuringPersistentFacadeCall(): void
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
            ->addConfiguredBundleToGuestCart($createConfiguredBundleRequestTransfer);

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

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\ConfigurableBundleCartsRestApi\Dependency\Facade\ConfigurableBundleCartsRestApiToCartsRestApiFacadeInterface
     */
    protected function getConfigurableBundleCartsRestApiToCartsRestApiFacadeBridgeMock(): ConfigurableBundleCartsRestApiToCartsRestApiFacadeInterface
    {
        $configurableBundleCartsRestApiToCartsRestApiFacadeBridgeMock = $this->getMockBuilder(ConfigurableBundleCartsRestApiToCartsRestApiFacadeBridge::class)
            ->onlyMethods(['createQuote', 'getQuoteCollection'])
            ->disableOriginalConstructor()
            ->getMock();

        $configurableBundleCartsRestApiToCartsRestApiFacadeBridgeMock
            ->method('createQuote')
            ->willReturn((new QuoteResponseTransfer())->setIsSuccessful(false));

        $configurableBundleCartsRestApiToCartsRestApiFacadeBridgeMock
            ->method('getQuoteCollection')
            ->willReturn(new QuoteCollectionTransfer());

        return $configurableBundleCartsRestApiToCartsRestApiFacadeBridgeMock;
    }
}
