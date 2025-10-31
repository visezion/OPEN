<?php

namespace Workdo\Churchly\Events;

use Illuminate\Queue\SerializesModels;

class CreateMember
{
    use SerializesModels;

    public $request;
    public $member;

    public function __construct($request, $member)
    {
        $this->request = $request;
        $this->member = $member;
    }

    public function broadcastOn()
    {
        return [];
    }
}
