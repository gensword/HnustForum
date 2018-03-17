<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendMessage extends Command
{
    protected $signature = 'chat:message {message}';

    protected $description = 'Send chat message.';

    public function handle()
    {
        // Fire off an event, just randomly grabbing the first user for now
        $message =  $this->argument('message');
        $channle = 'pmessage';
        event(new \App\Events\SendMsg($message, $channle));
    }
}
