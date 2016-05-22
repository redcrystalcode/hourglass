<?php

namespace Hourglass\Console\Commands;

use Illuminate\Console\Command;

class ModelFactory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:factory {model} {attributes?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a model using Model Factories';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $attributes = $this->parseAttributes($this->argument('attributes', []));
        $class = '\Hourglass\Models\\' . ucwords(camel_case($this->argument('model')));
        $model = factory($class)->create($attributes);
        var_dump($model);
        $this->info(substr($class, 1) . ' created!');
    }

    /**
     * @param array $attributes
     *
     * @return array
     */
    private function parseAttributes(array $attributes)
    {
        $parsed = [];
        foreach ($attributes as $attr) {
            list($key, $val) = explode('=', $attr);
            $parsed[$key] = $this->parseAttributeValue($val);
        }
        return $parsed;
    }

    /**
     * @param mixed $val
     *
     * @return mixed
     */
    private function parseAttributeValue($val)
    {
        if (is_numeric($val)) {
            return ($val == intval($val)) ? intval($val) : floatval($val);
        }

        if ($val === 'true') {
            return true;
        }
        if ($val === 'false') {
            return false;
        }

        return $val;
    }
}
