<?php

namespace Domain\Interfaces;

interface EventService
{
    public function publish(Event $event): void;

}
