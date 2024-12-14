<?php
declare(strict_types=1);

namespace meow\ItemManager\command;

use meow\ItemManager\form\EditItemInfoF;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;

class EditItemInfoC extends Command
{
    public function __construct()
    {
        parent::__construct('ei', '아이템 정보 수정', '/ie', ['아이템정보수정', 'edititem']);
        $this->setPermission(DefaultPermissionNames::GROUP_OPERATOR);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player || !$this->testPermission($sender)) return;
        if($sender->getInventory()->getItemInHand()->isNull()){
            $sender->sendMessage('공기의 정보는 변경할 수 없습니다.');
            return;
        }
        $sender->sendForm(new EditItemInfoF($sender->getInventory()->getItemInHand()));
    }
}