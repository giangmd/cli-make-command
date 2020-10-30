<?php

namespace ewci\CMC\Commands;

use ewci\CMC\Commands\BaseMakeCommand;
use CodeIgniter\CLI\CLI;

/**
 * Creates a new controller file.
 *
 * -n: Set the root namespace. Defaults to value of APP_NAMESPACE.
 * --restful: Extends from a RESTful resource. Choices are controller and presenter. Defaults to controller.
 * --force: Set this flag to overwrite existing files on destination.
 *
 * Eg:
 * php spark make:controller Api/TestController
 * php spark make:controller Api/TestController --restful
 * php spark make:controller Api/TestController --restful --force
 *
 * @packages App\Commands
 */
class ControllerMakeCommand extends BaseMakeCommand
{
    protected $defaultFolder = 'Controllers';

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
    protected $name = 'make:controller';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Create a new controller class.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'make:controller [class_name] [options]';

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'class_name' => 'The controller file name',
    ];

    /**
     * the Command's Options
     *
     * '--restful' => Extends from a RESTful resource.
     * '-n' => Set controller namespace
     * '--force' => Set this flag to overwrite existing files on destination.
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
        $stub = null;

        if (CLI::getOption('bare')) {
            $stub = '/stubs/controllers/controller.stub';
        } elseif (CLI::getOption('restful')) {
            $stub = '/stubs/controllers/controller.api.stub';
        }

        $stub = $stub ?? '/stubs/controllers/controller.plain.stub';

        return __DIR__ . $stub;
    }
}
