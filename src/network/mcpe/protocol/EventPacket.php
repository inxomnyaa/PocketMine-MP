<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\serializer\NetworkBinaryStream;

class EventPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::EVENT_PACKET;

	public const TYPE_ACHIEVEMENT_AWARDED = 0;
	public const TYPE_ENTITY_INTERACT = 1;
	public const TYPE_PORTAL_BUILT = 2;
	public const TYPE_PORTAL_USED = 3;
	public const TYPE_MOB_KILLED = 4;
	public const TYPE_CAULDRON_USED = 5;
	public const TYPE_PLAYER_DEATH = 6;
	public const TYPE_BOSS_KILLED = 7;
	public const TYPE_AGENT_COMMAND = 8;
	public const TYPE_AGENT_CREATED = 9;
	public const TYPE_PATTERN_REMOVED = 10; //???
	public const TYPE_COMMANED_EXECUTED = 11;
	public const TYPE_FISH_BUCKETED = 12;
	public const TYPE_MOB_BORN = 13;
	public const TYPE_PET_DIED = 14;
	public const TYPE_CAULDRON_BLOCK_USED = 15;
	public const TYPE_COMPOSTER_BLOCK_USED = 16;
	public const TYPE_BELL_BLOCK_USED = 17;

	/** @var int */
	public $playerRuntimeId;
	/** @var int */
	public $eventData;
	/** @var int */
	public $type;

	protected function decodePayload(NetworkBinaryStream $in) : void{
		$this->playerRuntimeId = $in->getEntityRuntimeId();
		$this->eventData = $in->getVarInt();
		$this->type = $in->getByte();

		//TODO: nice confusing mess
	}

	protected function encodePayload(NetworkBinaryStream $out) : void{
		$out->putEntityRuntimeId($this->playerRuntimeId);
		$out->putVarInt($this->eventData);
		$out->putByte($this->type);

		//TODO: also nice confusing mess
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleEvent($this);
	}
}
