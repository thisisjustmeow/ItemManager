<?php
declare(strict_types=1);

namespace meow\ItemManager\form;

use pocketmine\form\Form;
use pocketmine\item\Item;
use pocketmine\player\Player;

class EditItemInfoF implements Form
{
    public function __construct(private Item $item)
    {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'type' => 'custom_form',
            'title' => '아이템 정보수정',
            'content' => [
                [
                    'type' => 'label',
                    'text' => '아이템의 정보를 변경합니다' . "\n\n" . '§c변경할 정보만 입력해주세요. 기입되지 않은 부분은 변경되지 않습니다.'
                ],
                [
                    'type' => 'input',
                    'text' => '아이템 이름 설정',
                    'placeholder' => $this->item->hasCustomName() ? $this->item->getCustomName() : $this->item->getName()
                ],
                [
                    'type' => 'input',
                    'text' => '아이템 로어 설정, (n)으로 줄변경',
                    'placeholder' => implode('(n)', $this->item->getLore())
                ]
            ]
        ];
    }

    public function handleResponse(Player $player, $data): void
    {
        if($data === null) return;
        if(isset($data[1])){
            $this->item->setCustomName($data[1]);
        }
        if(isset($data[2])){
            $this->item->setLore(explode('(n)', $data[2]));
        }
        $player->getInventory()->setItemInHand($this->item);
        $player->sendMessage('변경사항이 적용되었습니다.');
    }
}