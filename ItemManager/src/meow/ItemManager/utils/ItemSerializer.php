<?php

declare(strict_types=1);

namespace meow\ItemManager\utils;

use pocketmine\item\Item;
use pocketmine\nbt\BigEndianNbtSerializer;
use pocketmine\nbt\TreeRoot;

use RuntimeException;

use function zlib_decode;
use function zlib_encode;
use const ZLIB_ENCODING_GZIP;

final class ItemSerializer{

    private static BigEndianNbtSerializer $serializer;

    public static function init() : void{
        self::$serializer = new BigEndianNbtSerializer();
    }

    public static function serialize(Item $item) : string{
        $res = zlib_encode(self::$serializer->write(new TreeRoot($item->nbtSerialize())), ZLIB_ENCODING_GZIP);
        if($res === false){
            throw new RuntimeException();
        }
        return $res;
    }

    public static function deserialize(string $string) : Item{
        return Item::nbtDeserialize(self::$serializer->read(zlib_decode($string))->mustGetCompoundTag());
    }
}