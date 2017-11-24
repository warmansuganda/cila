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
        $result .= "php index.php tools migration \"file_name\"         Create new migration file\n";
        $result .= "php index.php tools migrate [\"version_number\"]    Run all migrations. The version number is optional.\n";
        $result .= "php index.php tools seeder \"file_name\"            Creates a new seed file.\n";
        $result .= "php index.php tools seed \"file_name\"              Run the specified seed file.\n";

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
                \$table->uuid('id');
                \$table->string('name')->unique();
                \$table->timestamps();

                \$table->primary('id');
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


    public function model($table, $path = 'models', $fillable = '')
    {
        $this->make_model_file($table, $path, $fillable);
    }


    protected function make_model_file($table, $path, $fillable) {
        $camelcase = ucwords($table, "_");
        $name = str_replace('_', '', $camelcase) . 'Model';

        $path = APPPATH . str_replace('-', '/', $path) . "/$name.php";

        $my_model = fopen($path, "w") or die("Unable to create seed file!");

        if (!empty($fillable)) {
            $split_fillable = explode('-', $fillable);
            $list_fillable = [];
            foreach ($split_fillable as $value) {
                $list_fillable[] = "'$value'";
            }
            $join_fillable = implode(',', $list_fillable);
        } else {
            $join_fillable = '';
        }

        $model_template = "<?php

use \Illuminate\Database\Eloquent\Model as Eloquent;

class $name extends Eloquent {

    use UuidTrait;

    public \$incrementing = false; // Indicates if the IDs are auto-incrementing.
    protected \$table = '$table'; // Table name
    protected \$fillable = [$join_fillable]; // Defining Fillable Attributes On A Model

}
";

        fwrite($my_model, $model_template);

        fclose($my_model);

        echo "$path model has successfully been created." . PHP_EOL;
    }

}