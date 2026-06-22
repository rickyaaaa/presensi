<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan model User ada

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Jika tabel users belum ada, buat dengan struktur standar (termasuk kolom untuk Filament, seperti role)
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->softDeletes();
                $table->string('password');
                // $table->string('role')->default('user'); // Tambahkan kolom role untuk Filament
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Tambahkan user default dengan role admin (sesuai Filament v4)
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@primacom.com',
            'password' => Hash::make('primacom'), // Ganti dengan password aman atau dari env
            // 'role' => 'admin', // Sesuai dengan Filament untuk akses admin panel
            'email_verified_at' => now(),
            'deleted_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus user yang ditambahkan saat rollback
        DB::table('users')
            ->where('email', 'admin@primacom.com')
            ->delete();
        // Jika tabel users dibuat di sini, drop juga (opsional)
        // Schema::dropIfExists('users');
    }
};
