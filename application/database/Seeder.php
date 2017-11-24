<?php
/**
 * 『CodeIgniter徹底入門』のサンプルアプリケーションをCodeIgniter 3.0にアップデート
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    BSD 3-Clause License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/codeigniter-tettei-apps
 */

class Seeder
{
	public function __construct()
	{

	}

	/**
	 * Run another seeder
	 * 
	 * @param string $seeder Seeder classname
	 */
	public function call($seeder)
	{
		$obj = new $seeder;
		$obj->run();

		echo 'Runing "' . $seeder . '" successfull.' . PHP_EOL;
	}

}