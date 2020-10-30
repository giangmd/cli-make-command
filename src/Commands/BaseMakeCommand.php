<?php

namespace ewci\CMC\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

abstract class BaseMakeCommand extends BaseCommand
{
    protected $classDependencies = [
        'entity' => 'Entities',
        'filter' => 'Filters',
        'model' => 'Models'
    ];

    protected $homePath = APPPATH;
    protected $defaultFolder = null; //abstract variable
    protected $options = []; //abstract variable

    protected function handle(array $params)
    {
        // Name
        $name = $params['name'];

        // Namespace
        $ns = $this->getNamespace();

        // Path
        $directoryPath = $params['directory_path'];
        $path = $directoryPath . '/' . $name . '.php';

        // Class name should be pascal case now (camel case with upper first letter)
        $name = pascalize($name);

        // Template
        $replace = $this->extraOptions();
        $replace['ns'] = str_replace(DIRECTORY_SEPARATOR, '\\', $params['full_ns']);
        $replace['name'] = $name;
        $template = $this->buildTemplate($replace);

        // Build class
        $this->buildClass($directoryPath, $path, $template);

        // Complete
        $ns = rtrim(str_replace('\\', DIRECTORY_SEPARATOR, $ns), '\\') . DIRECTORY_SEPARATOR;
        CLI::write('Created file: ' . CLI::color(str_replace($this->homePath, $ns, $path), 'green'));
    }

    //================================
    //Define handle function
    //================================

    protected function handleParams(array $params)
    {
        helper('inflector');
        $recursiveParams = $this->parsePathRecursive(array_shift($params));
        if (empty($recursiveParams['name'])) {
            $recursiveParams['name'] = CLI::prompt(lang('Command.make.nameFile'), null, 'required');
        }

        return $this->prepareRecursiveParams($recursiveParams);
    }

    protected function extraOptions()
    {
        $options = array_merge($this->options, CLI::getOptions());

        foreach ($options as $k => $v) {
            if (strtolower($k) === 'group') {
                $options[$k] = ucfirst($v);
            }

            $this->alertDependencyClass(strtolower($k), $v);
            $options[$k] = $this->prepareDependencyClass(strtolower($k), $v);
        }

        return $this->options = $options;
    }

    protected function alertDependencyClass($t, $c)
    {
        if (isset($this->classDependencies[strtolower($t)])) {
            $path = $this->homePath
                . DIRECTORY_SEPARATOR .
                $this->classDependencies[strtolower($t)]
                . DIRECTORY_SEPARATOR .
                $c
                . '.php';

            if (! $this->alreadyExists($path)) {
                CLI::write(
                    CLI::color("The class {$c} from {$t} had not exists yet. 
Please try to create it before for using.", 'yellow')
                );
            }
        }
    }

    protected function prepareDependencyClass($t, $c)
    {
        if (! isset($this->classDependencies[strtolower($t)])) {
            return $c;
        }

        return $this->getNamespace()
            . '\\' .
            $this->classDependencies[strtolower($t)]
            . '\\' .
            $c;
    }

    protected function alreadyExists($path)
    {
        return file_exists($path);
    }

    protected function makeDirectory($path)
    {
        if (! is_dir($path)) {
            mkdir($path, 0775, true);
        }
    }

    protected function parsePathRecursive($text)
    {
        $str = explode(DIRECTORY_SEPARATOR, $text);

        $res = [
            'directory' => null,
            'name' => null
        ];

        if (! empty($str)) {
            $tmp = [];
            foreach ($str as $i => $s) {
                $tmp[] = $s;
            }

            $res['name'] = array_pop($tmp);
            $res['directory'] = implode(DIRECTORY_SEPARATOR, $tmp);
        }

        return $res;
    }

    protected function prepareRecursiveParams(array $recursiveParams)
    {
        $directoryPath = $this->homePath . $this->defaultFolder;
        $fullNs = $this->getNamespace() . DIRECTORY_SEPARATOR . $this->defaultFolder;
        if (! empty($recursiveParams['directory'])) {
            $directoryPath .= DIRECTORY_SEPARATOR . $recursiveParams['directory'];
            $fullNs .= DIRECTORY_SEPARATOR . $recursiveParams['directory'];
        }

        $recursiveParams['directory_path'] = $directoryPath;
        $recursiveParams['full_ns'] = $fullNs;

        return $recursiveParams;
    }

    protected function buildTemplate(array $replace)
    {
        $template = $this->getTemplate($this->getStub());

        if (! empty($replace)) {
            foreach ($replace as $k => $v) {
                $template = str_replace('{' . $k . '}', $v, $template);
            }
        }

        return $template;
    }

    protected function buildClass(string $directory, string $path, string $template)
    {
        helper('filesystem');
        if (! CLI::getOption('force') && $this->alreadyExists($path)) {
            CLI::error($path . ' already exists!');
            return;
        }

        // Directory
        $this->makeDirectory($directory);

        // Write file with permission
        if (! write_file($path, $template)) {
            CLI::error(lang('Command.make.writeError', [$path]));
            return;
        }
    }

    //================================
    //Define get value function
    //================================

    protected function getDefaultNamespace()
    {
        return defined('APP_NAMESPACE') ? APP_NAMESPACE : 'App';
    }

    protected function getNamespace()
    {
        $ns = $params['-n'] ?? CLI::getOption('n');

        if (! empty($ns)) {
            // Check valid ns
            while (strstr($ns, '/')) {
                $ns = CLI::prompt(
                    CLI::color("Namespace cannot be separated by '/', Please retype ", "blue")
                );
            }

            // Get all namespaces
            $namespaces = Services::autoloader()->getNamespace();

            foreach ($namespaces as $namespace => $path) {
                if ($namespace === $ns) {
                    $this->homePath = realpath(reset($path)) . DIRECTORY_SEPARATOR;
                    break;
                }
            }
        } else {
            $ns = defined('APP_NAMESPACE') ? APP_NAMESPACE : 'App';
        }

        return $ns;
    }

    protected function getTemplate($filePath)
    {
        $handle = fopen($filePath, "r");
        $template = fread($handle, filesize($filePath));
        fclose($handle);

        if (! $template) {
            CLI::error("Template loading error.");
            exit();
        }

        return $template;
    }

    //================================
    //Define abstract function
    //================================
    abstract protected function getStub();
}
