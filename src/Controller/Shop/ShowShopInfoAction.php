<?php

declare(strict_types=1);

namespace DH\ArtisShopApiPlugin\Controller\Shop;

use DH\ArtisShopApiPlugin\Factory\Shop\ShopInfoViewFactoryInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Context\ChannelNotFoundException;
use Sylius\Component\Core\Model\ChannelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ShowShopInfoAction
{
    /** @var ViewHandlerInterface */
    private $viewHandler;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var ShopInfoViewFactoryInterface */
    private $shopInfoViewFactory;

    public function __construct(
        ViewHandlerInterface $viewHandler,
        ChannelContextInterface $channelContext,
        ShopInfoViewFactoryInterface $shopInfoViewFactory
    ) {
        $this->viewHandler = $viewHandler;
        $this->channelContext = $channelContext;
        $this->shopInfoViewFactory = $shopInfoViewFactory;
    }

    public function __invoke(Request $request): Response
    {
        try {
            /** @var ChannelInterface $channel */
            $channel = $this->channelContext->getChannel();

            return $this->viewHandler->handle(View::create($this->shopInfoViewFactory->create($channel), Response::HTTP_OK));
        } catch (ChannelNotFoundException $exception) {
            throw new NotFoundHttpException('Channel has not been found.');
        } catch (\InvalidArgumentException $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }
    }
}
