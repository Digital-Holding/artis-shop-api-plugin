<?php

declare(strict_types=1);

namespace DH\ArtisShopApiPlugin\Factory\Shop;

use DH\ArtisShopApiPlugin\View\Shop\ShopInfoView;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class ShopInfoViewFactory implements ShopInfoViewFactoryInterface
{
    /** @var RepositoryInterface $countryRepository */
    private $countryRepository;

    public function __construct(
        RepositoryInterface $countryRepository
    ) {
        $this->countryRepository = $countryRepository;
    }

    /** {@inheritdoc} */
    public function create(ChannelInterface $channel): ShopInfoView
    {
        /** @var ShopInfoView $shopInfoView */
        $shopInfoView = new ShopInfoView();

        $shopInfoView->channel = $channel->getCode();
        $shopInfoView->currency = $channel->getBaseCurrency()->getCode();
        $shopInfoView->locale = $channel->getDefaultLocale()->getCode();

        $countries = $this->countryRepository->findBy(['enabled' => true]);

        foreach ($countries as $country) {
            $shopInfoView->countryCodes[] = $country->getCode();
        }

        return $shopInfoView;
    }
}
