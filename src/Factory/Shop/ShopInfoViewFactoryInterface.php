<?php

declare(strict_types=1);

namespace DH\ArtisShopApiPlugin\Factory\Shop;

use DH\ArtisShopApiPlugin\View\Shop\ShopInfoView;
use Sylius\Component\Core\Model\ChannelInterface;

interface ShopInfoViewFactoryInterface
{
    public function create(ChannelInterface $channel): ShopInfoView;
}
