<?php

namespace ewci\CMC\Commands;

use ewci\CMC\Commands\BaseMakeCommand;
use CodeIgniter\CLI\CLI;

/**
 * Creates a new command file.
 *
 * @packages App\Commands
 */
class ModelMakeCommand extends BaseMakeCommand
{
    protected $defaultFolder = 'Models';

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
    protected $name = 'make:model';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Create a new model class.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'make:model [class_name] [options]';

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'class_name' => 'The model file name',
    ];

    /**
     * the Command's Options
     * '--dbgroup' => Database group to use. Defaults to default.,
     * '--entity' => 'Set this flag to use an entity class as the return type.',
     * '--table' => 'Supply a different table name. Defaults to the pluralized class name.',
     * '-n' => 'Set the root namespace. Defaults to value of APP_NAMESPACE.',
     * '--force' => 'Set this flag to overwrite existing files on destination.'
     *
     * @var array
     */
    protected $options = [
        'dbgroup' => 'default',
        'entity' => 'array',
        'table' => null,
    ];

    public function run(array $params = [])
    {
        $params = $this->handleParams($params);
        $this->handle($params);
    }

    protected function getStub()
    {
        $stub = '/stubs/model.stub';

        return __DIR__ . $stub;
    }
}
