<?php
/**
 * Code generated using IdeaGroup
 * Help: lehung.hut@gmail.com
 * Cms is open-sourced software licensed under the MIT license.
 * Developed by: Lehungdev IT Solutions
 * Developer Website: http://ideagroup.vn
 */

namespace Lehungdev\Cms\Commands;

use Illuminate\Console\Command;

use Lehungdev\Cms\CodeGenerator;

/**
 * Class Migration
 * @package Lehungdev\Cms\Commands
 *
 * Command to generation new sample migration file or complete migration file from DB Context
 * if '--generate' parameter is used after command, it generate migration from database.
 */
class Migration extends Command
{
    // The command signature.
    protected $signature = 'la:migration {table} {--generate}';
    
    // The command description.
    protected $description = 'Generate Migrations for Cms';
    
    /**
     * Generate a Migration file either sample or from DB Context
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument('table');
        $generateFromTable = $this->option('generate');
        if($generateFromTable) {
            $generateFromTable = true;
        }
        CodeGenerator::generateMigration($table, $generateFromTable, $this);
    }
}
