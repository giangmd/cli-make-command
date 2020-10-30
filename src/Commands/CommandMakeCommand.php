<?php

namespace ewci\CMC\Commands;

use ewci\CMC\Commands\BaseMakeCommand;

/**
 * Creates a new command file.
 *
 * Eg:
 * php spark make:command TestCommandLine --command make:test --group generator --type basic --force
 *
 * Read more in $options below
 *
 * @packages App\Commands
 */
class CommandMakeCommand extends BaseMakeCommand
{
    protected $defaultFolder = 'Commands';

    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'make';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'make:command';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Create a new command class.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'make:command [class_name] [options]';

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'class_name' => 'The command file name',
    ];

    /**
     * the Command's Options
     * '--command' => 'The command name to run in spark. Defaults to command:name',
     * '--group' => 'The group/namespace of the command. Defaults to CodeIgniter for basic commands,
     *              and Generators for generator commands.',
     * '--type' => 'The type of command, whether a basic command or a generator command. Defaults to basic',
     * '-n' => 'Set the root namespace. Defaults to value of APP_NAMESPACE.',
     * '--force' => 'Set this flag to overwrite existing files on destination.'
     *
     * @var array
     */
    protected $options = [
        'command' => 'command:name',
        'group' => 'Generators',
        'type' => 'basic'
    ];

    public function run(array $params = [])
    {
        $params = $this->handleParams($params);
        $this->handle($params);
    }

    protected function getStub()
    {
        $stub = null;

        // TODO
        // Check condition for other type

        $stub = $stub ?? '/stubs/commands/command.stub';

        return __DIR__ . $stub;
    }
}
