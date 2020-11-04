<?php

class TicketHistory implements JsonSerializable
{
  public function __construct()
  {
    $ticketStatusList = Ticket::getStatusList();
    $this->status_text = $ticketStatusList[$this->status];
  }

  public function jsonSerialize()
  {
    return $this;
  }
}
