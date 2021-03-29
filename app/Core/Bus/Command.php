<?php
namespace App\Core\Bus;

use Closure;

class Command
{
    /**
     * Hold all commands taht have been registered
     *
     * @var array
     */
    protected $commandBag;

    /**
     *
     * @var string
     */
    protected $command;

    /**
     * Regsister a new command
     *
     * @param string $command
     * @param Closure $callback
     * @return void
     */
    public function register(string $command, Closure $callback)
    {
        $this->commandBag[$command] = $callback;
    }


    /**
     * Get command
     *
     * @param string $command
     * @return Callback | boolean
     */
    public function getCommand(string $command)
    {
        return  $this->commandBag[$command]??null;
    }

    /**
     * Undocumented function
     *
     * @param array $argv
     * @return void
     */
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
