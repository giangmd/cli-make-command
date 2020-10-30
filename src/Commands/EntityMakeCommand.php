<?php

namespace ewci\CMC\Commands;

use ewci\CMC\Commands\BaseMakeCommand;
use CodeIgniter\CLI\CLI;

/**
 * Creates a new command file.
 *
 * @packages App\Commands
 */
class EntityMakeCommand extends BaseMakeCommand
{
    protected $defaultFolder = 'Entities';

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
    protected $name = 'make:entity';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Create a new entity class.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'make:entity [class_name] [options]';

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
     *
     * @var array
     */
    protected $options = [
        //
    ];

    public function run(array $params = [])
    {
        $params = $this->handleParams($params);
        $this->handle($params);
    }

    protected function getStub()
    {
        $stub = '/stubs/entity.stub';

        return __DIR__ . $stub;
    }
}
