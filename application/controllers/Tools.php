<?php

class Tools extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // can only be called from the command line
        if (!$this->input->is_cli_request()) {
            exit('Direct access is not allowed. This is a command line tool, use the terminal');
        }

        $this->load->dbforge();

        // initiate faker
        $this->faker = Faker\Factory::create();
    }

    public function message($to = 'World') {
        echo "Hello {$to}!" . PHP_EOL;
    }

    public function help() {
        $result = "The following are the available command line interface commands\n\n";
        $result .= "php index.php tools migration \"file_name\"                  Create new migration file\n";
        $result .= "php index.php tools migrate [\"version_number\"]             Run all migrations. The version number is optional.\n";
        $result .= "php index.php tools seeder \"file_name\"                     Creates a new seed file.\n";
        $result .= "php index.php tools seed \"file_name\"                       Run the specified seed file.\n";
        $result .= "php index.php tools module \"name\" \"path\" \"fillable\"        Creates a new module file.\n";
        $result .= "php index.php tools model \"name\" \"path\" \"fillable\"         Creates a new model file.\n";
        $result .= "php index.php tools controller \"name\" \"path\"               Creates a new controller file.\n";
        $result .= "php index.php tools repository \"name\" \"path\" \"fillable\"    Creates a new repository file.\n";
        $result .= "php index.php tools processor \"name\" \"path\"                Creates a new processor file.\n";
        $result .= "php index.php tools service \"name\" \"path\" \"fillable\"       Creates a new service file.\n";

        echo $result . PHP_EOL;
    }

    public function migration($name) {
        $this->make_migration_file($name);
    }

    public function migrate($version = null) {
        $this->load->library('migration');

        if ($version != null) {
            if ($this->migration->version($version) === FALSE) {
                show_error($this->migration->error_string());
            } else {
                echo "Migrations run successfully" . PHP_EOL;
            }

            return;
        }

        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "Migrations run successfully" . PHP_EOL;
        }
    }

    public function seeder($name, $model) {
        $this->make_seed_file($name, $model);
    }

    public function seed($name) {
        $seeder = new Seeder();
        $seeder->call($name);
    }

    protected function make_migration_file($name) {
        $date = new DateTime();
        $timestamp = $date->format('YmdHis');

        $table_name = strtolower($name);

        $path = APPPATH . "database/migrations/$timestamp" . "_" . "$name.php";

        $my_migration = fopen($path, "w") or die("Unable to create migration file!");

        $migration_template = "<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration_$name extends CI_Migration {

    public function up() {
        if (!Capsule::schema()->hasTable('$table_name')) {
            Capsule::schema()->create('$table_name', function (\$table) {
                \$table->uuid('id')->primary();
                \$table->string('name')->unique();
                \$table->string('description')->nullable();
                \$table->timestamps();
            });
        }
    }

    public function down() {
        if (Capsule::schema()->hasTable('$table_name')) {
            Capsule::schema()->drop('$table_name');
        }
    }

}";

        fwrite($my_migration, $migration_template);

        fclose($my_migration);

        echo "$path migration has successfully been created." . PHP_EOL;
    }

    protected function make_seed_file($name, $model) {
        $path = APPPATH . "database/seeds/$name.php";

        $my_seed = fopen($path, "w") or die("Unable to create seed file!");

        $seed_template = "<?php

class $name extends Seeder {

    public function run() {
        $model::truncate();

        //seed records manually
        \$data = [
            'name' => 'admin',
            'password' => '9871'
        ];
        $model::create(\$data);

        //seed many records using faker
        \$limit = 33;
        echo \"seeding \$limit user accounts\";

        for (\$i = 0; \$i < \$limit; \$i++) {
            echo \".\";

            \$data = array(
                'name' => \$this->faker->unique()->userName,
                'password' => '1234',
            );

            $model::create(\$data);
        }

        echo PHP_EOL;
    }
}
";

        fwrite($my_seed, $seed_template);

        fclose($my_seed);

        echo "$path seeder has successfully been created." . PHP_EOL;
    }


    public function module($name, $path = '', $fillable = '')
    {
        $this->make_model_file($name, $path, $fillable);
        $this->make_controller_file($name, $path);
        $this->make_repository_file($name, $path, $fillable);
        $this->make_processor_file($name, $path);
        $this->make_service_file($name, $path, $fillable);
    }

    public function unmodule($table, $path = '')
    {
        $camelcase = ucwords($table, "_");
        $name = str_replace('_', '', $camelcase);
        $real_path = str_replace('-', '/', $path);

        $controllers = APPPATH . $real_path . "/controllers/" .$name . ".php";
        $models = APPPATH . $real_path . "/models/" .$name . "Model.php";
        $repositories = APPPATH . $real_path . "/repositories/" .$name . "Repository.php";
        $processors = APPPATH . $real_path . "/processors/" .$name . "Processor.php";
        $service = APPPATH . $real_path . "/services/" .$name . "Service.php";

        if (file_exists($controllers)) {
            unlink($controllers);
            echo $controllers . " has successfully been deleted." . PHP_EOL;
        }

        if (file_exists($models)) {
            unlink($models);
            echo $models . " has successfully been deleted." . PHP_EOL;
        }

        if (file_exists($repositories)) {
            unlink($repositories);
            echo $repositories . " has successfully been deleted." . PHP_EOL;
        }

        if (file_exists($processors)) {
            unlink($processors);
            echo $processors . " has successfully been deleted." . PHP_EOL;
        }

        if (file_exists($service)) {
            unlink($service);
            echo $service . " has successfully been deleted." . PHP_EOL;
        }
    }

    public function model($table, $path = '-models', $fillable = '')
    {
        $this->make_model_file($table, $path, $fillable);
    }


    protected function make_model_file($table, $path, $fillable) {
        $camelcase = ucwords($table, "_");
        $name = str_replace('_', '', $camelcase) . 'Model';

        $dir = '-models';
        if (substr($path, -1 * strlen($dir)) != $dir) {
            $path .= !empty($path) ? $dir : str_replace('-', '', $dir);
        } else {
            $path = $path != $dir ? $path : str_replace('-', '', $dir);
        }

        $path = APPPATH . str_replace('-', '/', $path) . "/$name.php";

        $my_model = fopen($path, "w") or die("Unable to create seed file!");

        if (!empty($fillable)) {
            $split_fillable = explode('-', $fillable);
            $list_fillable = [];
            foreach ($split_fillable as $value) {
                $list_fillable[] = PHP_EOL . "        '$value'";
            }
            $join_fillable = implode(',', $list_fillable);
        } else {
            $join_fillable = '';
        }

        $model_template = "<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class $name extends Eloquent {

    use UuidTrait;

    public \$incrementing = false;
    protected \$table = '$table'; // Table name
    /* 
     * Defining Fillable Attributes On A Model
     */ 
    protected \$fillable = [ $join_fillable
    ];

}
";

        fwrite($my_model, $model_template);

        fclose($my_model);

        echo "$path model has successfully been created." . PHP_EOL;
    }

    public function controller($table, $path = '-controllers')
    {
        $this->make_controller_file($table, $path);
    }

    protected function make_controller_file($table, $path) {
        $camelcase = ucwords($table, "_");
        $title = str_replace('_', ' ', $camelcase);
        $name = str_replace('_', '', $camelcase);
        $repo = str_replace('_', '', $camelcase) . 'Repository';

        $dir = '-controllers';
        if (substr($path, -1 * strlen($dir)) != $dir) {
            $path .= !empty($path) ? $dir : str_replace('-', '', $dir);
        } else {
            $path = $path != $dir ? $path : str_replace('-', '', $dir);
        }

        $path = APPPATH . str_replace('-', '/', $path) . "/$name.php";

        $my_controller = fopen($path, "w") or die("Unable to create seed file!");

        $controller_template = "<?php

class $name extends BaseController {

    private \$repo;

    function __construct() {
        parent::__construct([
            'title'   => '$title',
        ]);

        \$this->repo = new $repo();
    }

    public function index() {
        \$data = \$this->getViewData();
        \$this->slice->view(\$data['module'] . \"/index\", \$data);
    }

    public function create() {
      \$input = \$this->input->post();
      \$return = \$this->repo->startProcess('create', \$input);
      \$this->serveJSON(\$return);
    }

}
";

        fwrite($my_controller, $controller_template);

        fclose($my_controller);

        echo "$path controller has successfully been created." . PHP_EOL;
    }


    public function repository($table, $path = '-repositories', $fillable = '')
    {
        $this->make_repository_file($table, $path, $fillable);
    }


    protected function make_repository_file($table, $path, $fillable) {
        $camelcase = ucwords($table, "_");
        $name = str_replace('_', '', $camelcase) . 'Repository';
        $processor = str_replace('_', '', $camelcase) . 'Processor';

        $dir = '-repositories';
        if (substr($path, -1 * strlen($dir)) != $dir) {
            $path .= !empty($path) ? $dir : str_replace('-', '', $dir);
        } else {
            $path = $path != $dir ? $path : str_replace('-', '', $dir);
        }

        $path = APPPATH . str_replace('-', '/', $path) . "/$name.php";

        $my_repository = fopen($path, "w") or die("Unable to create seed file!");

        if (!empty($fillable)) {
            $split_fillable = explode('-', $fillable);
            $list_fillable = [];
            $list_rules = [];
            foreach ($split_fillable as $value) {
                $list_fillable[] = PHP_EOL . "            '$value'   => \$request('$value')";
                $list_rules[] = PHP_EOL . "                [
                    'field' => '$value',
                    'label' => '$value',
                    'rules' => 'required'
                ]";
            }
            $join_fillable = implode(',', $list_fillable);
            $join_rules = implode(',', $list_rules);
        } else {
            $join_fillable = '';
            $join_rules = '';
        }

        $repository_template = "<?php

class $name extends BaseRepository {

    public function __construct() {
        parent::__construct();
        \$this->processor = new $processor();
    }

    public function getInput(\$request) {
        \$this->data = [ $join_fillable
        ];

    }

    public function setValidationRules() {
        switch (\$this->operation_type) {
        case 'create':
            \$this->rules = [ $join_rules
            ];

            break;
        default:
            \$this->rules = [];
        }

    }
}
";

        fwrite($my_repository, $repository_template);

        fclose($my_repository);

        echo "$path model has successfully been created." . PHP_EOL;
    }


    public function processor($table, $path = '-processors')
    {
        $this->make_processor_file($table, $path);
    }

    protected function make_processor_file($table, $path) {
        $camelcase = ucwords($table, "_");
        $title = str_replace('_', ' ', $camelcase);
        $name = str_replace('_', '', $camelcase) . 'Processor';
        $service = str_replace('_', '', $camelcase) . 'Service';

        $dir = '-processors';
        if (substr($path, -1 * strlen($dir)) != $dir) {
            $path .= !empty($path) ? $dir : str_replace('-', '', $dir);
        } else {
            $path = $path != $dir ? $path : str_replace('-', '', $dir);
        }

        $path = APPPATH . str_replace('-', '/', $path) . "/$name.php";

        $my_processor = fopen($path, "w") or die("Unable to create seed file!");

        $processor_template = "<?php

class $name extends BaseProcessor {

    private \$service;

    public function __construct()
    {
        parent::__construct();
        \$this->service = new $service();
    }

    public function setProcessor(string \$operation_type, array \$data)
    {
        try {
            switch (\$operation_type) {
                case 'create':
                    \$this->output = \$this->service->create(\$data);
                    break;
            }

            return true;
        } catch (Exception \$e) {
            \$this->output = \$e;
            return false;
        }
    }

}
";

        fwrite($my_processor, $processor_template);

        fclose($my_processor);

        echo "$path processor has successfully been created." . PHP_EOL;
    }

    public function service($table, $path = '-services', $fillable = '')
    {
        $this->make_service_file($table, $path, $fillable);
    }

    protected function make_service_file($table, $path, $fillable = '') {
        $camelcase = ucwords($table, "_");
        $title = str_replace('_', ' ', $camelcase);
        $name = str_replace('_', '', $camelcase) . 'Service';
        $model = str_replace('_', '', $camelcase) . 'Model';

        $dir = '-services';
        if (substr($path, -1 * strlen($dir)) != $dir) {
            $path .= !empty($path) ? $dir : str_replace('-', '', $dir);
        } else {
            $path = $path != $dir ? $path : str_replace('-', '', $dir);
        }

        $path = APPPATH . str_replace('-', '/', $path) . "/$name.php";


        if (!empty($fillable)) {
            $split_fillable = explode('-', $fillable);
            $list_fillable = [];
            foreach ($split_fillable as $value) {
                $list_fillable[] = PHP_EOL . "            '$value' => \$data['$value']";
            }
            $join_fillable = implode(',', $list_fillable);
        } else {
            $join_fillable = '';
        }

        $my_service = fopen($path, "w") or die("Unable to create seed file!");

        $service_template = "<?php

class $name extends BaseService {

    private \$model;
    
    function __construct() {
        parent::__construct();
        \$this->model = new $model();
    }

    public function create(array \$data) {
        \$query = \$this->model->create([ $join_fillable
        ]);

        if (\$query) {   
            \$result = [
                '_id' => \$query->id,
                'messages' => [200, 'Created successfully.', '']
            ];
        } else {
            \$result = [
                'messages' => [500, 'Created failed.', '']
            ];
        }

        return \$result;
    }

}
";

        fwrite($my_service, $service_template);

        fclose($my_service);

        echo "$path service has successfully been created." . PHP_EOL;
    }

}
