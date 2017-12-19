<?php

class Tools extends CI_Controller {

    private $controller_suffix;

    public function __construct() {
        parent::__construct();

        // can only be called from the command line
        if (!$this->input->is_cli_request()) {
            exit('Direct access is not allowed. This is a command line tool, use the terminal');
        }

        $this->load->dbforge();

        // initiate faker
        $this->faker = Faker\Factory::create();
        $this->controller_suffix = $this->config->item('controller_suffix');

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

        $path = APPPATH . "database/migrations";

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

        $this->create_file($migration_template, $path,  $timestamp . "_" . "$name.php");

        echo "$path migration has successfully been created." . PHP_EOL;
    }

    protected function make_seed_file($name, $model) {
        $path = APPPATH . "database/seeds";

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

        $this->create_file($seed_template, $path,  "$name.php");

        echo "$path seeder has successfully been created." . PHP_EOL;
    }


    public function module($name, $path = '', $fillable = '')
    {
        $this->make_model_file($name, $path, $fillable);
        $this->make_controller_file($name, $path);
        $this->make_repository_file($name, $path, $fillable);
        $this->make_processor_file($name, $path);
        $this->make_service_file($name, $path, $fillable);
        $this->make_view_file($name, $path);
    }

    public function unmodule($table, $path = '')
    {
        $camelcase = ucwords($table, "_");
        $name = str_replace('_', '', $camelcase);
        $real_path = str_replace('-', '/', $path);

        $controllers = APPPATH . $real_path . "/controllers/" . ucwords(strtolower($camelcase)) . $this->controller_suffix . ".php";
        $models = APPPATH . $real_path . "/models/" .$name . "Model.php";
        $repositories = APPPATH . $real_path . "/repositories/" .$name . "Repository.php";
        $processors = APPPATH . $real_path . "/processors/" .$name . "Processor.php";
        $service = APPPATH . $real_path . "/services/" .$name . "Service.php";
        $view = APPPATH . $real_path . "/views/" . $table;

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

        if($this->delete_dir($view)) {
            echo $view . " has successfully been deleted." . PHP_EOL;
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

        $path = APPPATH . str_replace('-', '/', $path);

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

class $name extends BaseModel {

    protected \$table = '$table'; // Table name
    /* 
     * Defining Fillable Attributes On A Model
     */ 
    protected \$fillable = [ $join_fillable
    ];

}
";

        $this->create_file($model_template, $path,  "$name.php");

        echo "$path model has successfully been created." . PHP_EOL;
    }

    public function controller($table, $path = '-controllers')
    {
        $this->make_controller_file($table, $path);
    }

    protected function make_controller_file($table, $path) {
        $camelcase = ucwords($table, "_");
        $title = str_replace('_', ' ', $camelcase);
        $name = ucwords(strtolower($camelcase)) . $this->controller_suffix;
        $repo = str_replace('_', '', $camelcase) . 'Repository';

        $dir = '-controllers';
        if (substr($path, -1 * strlen($dir)) != $dir) {
            $path .= !empty($path) ? $dir : str_replace('-', '', $dir);
        } else {
            $path = $path != $dir ? $path : str_replace('-', '', $dir);
        }

        $path = APPPATH . str_replace('-', '/', $path);

        $controller_template = "<?php

class $name extends BaseController {

    private \$repo;

    function __construct() {
        parent::__construct([
            'title'   => '$title',
            'description'   => '$title Manajemen',
        ]);

        \$this->repo = new $repo();
    }

    public function getIndex() {
        \$this->serveView();
    }

    public function getRead() {
      \$input = \$this->input->get();
      \$return = \$this->repo->startProcess('read', \$input);
      \$this->serveJSON(\$return);
    }
    
    public function getAdd() {
        \$this->serveView();
    }

    public function postCreate() {
      \$input = \$this->input->post();
      \$return = \$this->repo->startProcess('create', \$input);
      \$this->serveJSON(\$return);
    }

    public function getEdit() {
        \$input = \$this->input->get();
        \$this->setViewData('data', \$this->repo->startProcess('get', \$input));
        \$this->serveView();
    }

    public function postUpdate() {
      \$input = \$this->input->post();
      \$return = \$this->repo->startProcess('update', \$input);
      \$this->serveJSON(\$return);
    }    

    public function postDelete() {
      \$input = \$this->input->post();
      \$return = \$this->repo->startProcess('delete', \$input);
      \$this->serveJSON(\$return);
    }

}
";

        $this->create_file($controller_template, $path,  "$name.php");

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

        $path = APPPATH . str_replace('-', '/', $path);

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
        \$this->data = [ 
            'id' => \$request('grid_id'),$join_fillable
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

        $this->create_file($repository_template, $path,  "$name.php");

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

        $path = APPPATH . str_replace('-', '/', $path);

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
                case 'read':
                    \$this->output = \$this->service->read(\$data);
                    break;
                case 'get':
                    \$this->output = \$this->service->get(\$data);
                    break;
                case 'update':
                    \$this->output = \$this->service->update(\$data);
                    break;
                case 'delete':
                    \$this->output = \$this->service->delete(\$data);
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

        $this->create_file($processor_template, $path,  "$name.php");

        echo "$path processor has successfully been created." . PHP_EOL;
    }

    public function service($table, $path = '-services', $fillable = '')
    {
        $this->make_service_file($table, $path, $fillable);
    }

    protected function make_service_file($table, $path, $fillable = '') {
        $path_module = str_replace('-services', '', $path);
        $module = str_replace('_', '-', str_replace('modules-', '', $path_module) . (!empty($path_module) ? '/' : '') .  $table);

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

        $path = APPPATH . str_replace('-', '/', $path);


        if (!empty($fillable)) {
            $split_fillable = explode('-', $fillable);
            $list_fillable = [];
            $list_fillable_get = [];
            $list_fillable_filter = [];
            $list_fillable_column = [];
            foreach ($split_fillable as $value) {
                $list_fillable[] = PHP_EOL . "            '$value' => \$data['$value']";
                $list_fillable_get[] = PHP_EOL . "                    '$value' => \$query->$value";
                $list_fillable_filter[] = PHP_EOL . "                if (\$data['$value'] != '') {
                    \$query->where('$value', \$data['$value']);
                }";
                $list_fillable_column[] = PHP_EOL . "            ->addColumn('$value', function(\$query) {
                return \$query->$value;
            })";
            }
            $join_fillable = implode(',', $list_fillable);
            $join_fillable_get = implode(',', $list_fillable_get);
            $join_fillable_filter = implode('', $list_fillable_filter);
            $join_fillable_column = implode('', $list_fillable_column);
        } else {
            $join_fillable = '';
            $join_fillable_get = '';
            $join_fillable_filter = '';
            $join_fillable_column = '';
        }

        $service_template = "<?php

class $name extends BaseService {
    
    function __construct() {
        parent::__construct();
    }

    public function create(array \$data) {
        return $model::createOne([ $join_fillable
        ]);
    }

    public function read(array \$data) {
        \$query = $model::data();
        \$options = [
            'module'  => '$module',
            'encrypt' => \$this->encrypt
        ];

        return \$this->datatables->of(\$query)
            ->filter(function(\$query) use (\$data) { $join_fillable_filter
                return \$query;
            }) 
            ->addColumn('checkbox', function(\$query) use (\$options) {
                return form_checkbox('id[]', \$options['encrypt']->encode(\$query->id), FALSE, ['class' => 'checkbox-id']);
            }) $join_fillable_column
            ->addColumn('action', function(\$query) use (\$options) {
                \$action[] = anchor(\$options['module'] . '/edit?grid_id=' . \$options['encrypt']->encode(\$query->id), '<i class=\"fa fa-edit\"></i> Edit', [
                    'class' => 'btn btn-warning btn-xs',
                    'rel' => 'tooltip',
                    'title' => 'Edit'
                ]);
                \$action[] = anchor(\$options['module'] . '/delete', '<i class=\"fa fa-trash\"></i> Delete',[
                    'class' => 'btn btn-danger btn-xs btn-delete',
                    'data-grid' => \$options['encrypt']->encode(\$query->id)
                ]);
                return implode(' ', \$action);
            })
            ->make();
    }

    public function get(array \$data)
    {
        \$id = \$data['id'];

        if (!empty(\$id)) {
            \$query = $model::find(\$this->encrypt->decode(\$id));
            if (\$query) {
                return [
                    'id' => \$this->encrypt->encode(\$query->id), $join_fillable_get
                ];
            }
        }

        return NULL;
    }

    public function update(array \$data) {
        return $model::updateOne(\$this->encrypt->decode(\$data['id']), [ $join_fillable
        ]);
    }

    public function delete(array \$data) {
        if (is_array(\$data['id'])) {
            \$id = [];
            foreach (\$data['id'] as \$value) {
                \$id[] = \$this->encrypt->decode(\$value);
            }

            return BaseModel::transaction(function() use (\$id) {
                return $model::deleteMany(\$id);
            });    
        } else {
            \$id = \$this->encrypt->decode(\$data['id']);
            return $model::deleteOne(\$id);
        }
    }

}
";

        $this->create_file($service_template, $path,  "$name.php");


        echo "$path service has successfully been created." . PHP_EOL;
    }

    public function view($table, $path = '-views', $fillable = '')
    {
        $this->make_view_file($table, $path, $fillable);
    }

    protected function make_view_file($table, $path, $fillable = '') {
        $name = $table;

        $dir = '-views';
        if (substr($path, -1 * strlen($dir)) != $dir) {
            $path .= !empty($path) ? $dir : str_replace('-', '', $dir);
        } else {
            $path = $path != $dir ? $path : str_replace('-', '', $dir);
        }

        $path = APPPATH . str_replace('-', '/', $path) . "/$name";

        if( is_dir($path) === false )
        {
            mkdir($path);
        }

        if (!empty($fillable)) {
            $split_fillable = explode('-', $fillable);
            $list_fillable = [];
            $list_fillable_column = [];
            $list_fillable_filter = [];
            $list_fillable_add = [];
            $list_fillable_edit = [];
            foreach ($split_fillable as $value) {
                $label = str_replace('_', ' ', ucwords($value, '_'));
                $list_fillable[] = "'$label'";
                $list_fillable_column[] = PHP_EOL . "          {data: '$value', name:'$value'},";
                $list_fillable_filter[] = PHP_EOL . "              <div class=\"col-md-6\">
                <div class=\"form-group\">
                  <label class=\"col-md-3 control-label\">$label</label>
                  <div class=\"col-md-9\">
                    {{ form_input('$value', '', ['class' => 'form-control filter-select']) }}
                  </div>
                </div>
              </div>";
                $list_fillable_add[] = PHP_EOL . "            <div class=\"form-group\">
              <label for=\"name\" class=\"col-sm-2 control-label\"> $label <sup class=\"text-red\">*</sup></label>
              <div class=\"col-sm-5\">
                {{ form_input('$value', '', ['class' => 'form-control']) }}
              </div>
            </div>";
            $list_fillable_edit[] = PHP_EOL . "            <div class=\"form-group\">
              <label for=\"name\" class=\"col-sm-2 control-label\"> $label <sup class=\"text-red\">*</sup></label>
              <div class=\"col-sm-5\">
                {{ form_input('$value', \$data['$value'], ['class' => 'form-control']) }}
              </div>
            </div>";
            }

            $join_fillable = implode(', ', $list_fillable);
            $join_fillable_column = implode('', $list_fillable_column);
            $join_fillable_filter = implode('', $list_fillable_filter);
            $join_fillable_add = implode('', $list_fillable_add);
            $join_fillable_edit = implode('', $list_fillable_edit);
        } else {
            $join_fillable = '';
            $join_fillable_column = '';
            $join_fillable_filter = '';
            $join_fillable_add = '';
            $join_fillable_edit = '';
        }

        $view_index = file_get_contents(APPPATH . 'views/templates/index.slice.php');
        $this->create_file($this->contentReplace($view_index,[
            '<<<form-filter>>>' => $join_fillable_filter,
            '<<<table-header>>>' => $join_fillable,
            '<<<table-column>>>' => $join_fillable_column,
        ]), $path, 'index.slice.php');
        $view_add = file_get_contents(APPPATH . 'views/templates/add.slice.php');
        $this->create_file($this->contentReplace($view_add,[
            '<<<form-add>>>' => $join_fillable_add,
        ]), $path, 'add.slice.php');
        $view_edit = file_get_contents(APPPATH . 'views/templates/edit.slice.php');
        $this->create_file($this->contentReplace($view_edit,[
            '<<<form-edit>>>' => $join_fillable_edit,
        ]), $path, 'edit.slice.php');

        echo "$path view has successfully been created." . PHP_EOL;
    }

    private function contentReplace($str, array $search)
    {
        foreach ($search as $key => $value) {
            $str = str_replace($key, $value, $str);
        }
        return $str;
    }

    protected function create_file($content = '', $path ='', $filename = 'unknown')
    {
        $my_view = fopen($path . '/' . $filename, "w") or die("Unable to create seed file!");
        fwrite($my_view, $content);
        fclose($my_view);
    }

    protected function delete_dir($path)
    {
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));

            foreach ($files as $file)
            {
                $this->delete_dir(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        }

        else if (is_file($path) === true)
        {
            return unlink($path);
        }

        return false;
    }

}
