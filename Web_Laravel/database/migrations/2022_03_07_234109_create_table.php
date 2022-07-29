<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class CreateTable extends Migration
{
    public function up()
    {
        $backup = __DIR__ . '/../ediagnostics.sql';
        DB::unprepared(file_get_contents($backup));

        // DB::table('admin')
        //     ->insert([
        //         'email'     => 'admin@gmail.com',
        //         'nama_dsn'  => 'Jahrulnr',
        //         'noHP'      => '082218594993',
        //         'password'  => bcrypt('admin'),
        //         'hak_akses' => 'admin'
        //     ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('mahasiswa');
    }
}

