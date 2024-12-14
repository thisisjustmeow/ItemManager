<?php
declare(strict_types=1);

namespace meow\ItemManager;

use meow\ItemManager\command\EditItemInfoC;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

use meow\ItemManager\utils\ItemSerializer;

use JsonException;

class ItemManager extends PluginBase
{
    use SingletonTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        ItemSerializer::init();

        $this->getServer()->getCommandMap()->registerAll('ItemManager', [
            new EditItemInfoC()
        ]);
    }

    /**
     * @throws JsonException
     */
    public function serializeItem(?Item $item): string
    {
        if($item === null || $item->getCount() === 0) return ' ';
        return mb_convert_encoding(ItemSerializer::serialize($item), 'UTF-8', 'ISO-8859-1');
    }

    public function deserializeItem(string $data): Item
    {
        if($data === ' ') return VanillaItems::AIR();
        return ItemSerializer::deserialize(mb_convert_encoding($data, 'ISO-8859-1', 'UTF-8'));
    }
}