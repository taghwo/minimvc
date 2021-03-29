<?php
namespace App\Core\Bus;

class Command
{
    protected $commandBag;
    protected $command;
    public function register($command, $callback)
    {
        $this->commandBag[$command] = $callback;
    }


    public function getCommand($command)
    {
        return  $this->commandBag[$command]??null;
    }

    public function fire($argv)
    {

        if (isset($argv[1])) {
            $this->command = $this->getCommand($argv[1]);
        }

        if($this->command === null){
            $this->command = $this->getCommand("help");
        }

        call_user_func($this->command, $argv);
    }
}
