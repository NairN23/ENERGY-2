<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'deleted_email_original')) {
                $table->string('deleted_email_original')->nullable()->after('email');
            }
        });

        if (! Schema::hasColumn('users', 'deleted_at')) {
            return;
        }

        DB::table('users')
            ->whereNotNull('deleted_at')
            ->whereNull('deleted_email_original')
            ->orderBy('id')
            ->get(['id', 'email', 'deleted_at'])
            ->each(function ($user): void {
                $deletedAt = $user->deleted_at ? strtotime((string) $user->deleted_at) : time();

                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'deleted_email_original' => $user->email,
                        'email' => sprintf('deleted-user-%d-%d@energy.local', $user->id, $deletedAt),
                    ]);
            });
    }

    public function down(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'deleted_email_original')) {
            return;
        }

        DB::table('users')
            ->whereNotNull('deleted_email_original')
            ->orderBy('id')
            ->get(['id', 'email', 'deleted_email_original', 'deleted_at'])
            ->each(function ($user): void {
                $existingActiveUser = DB::table('users')
                    ->where('email', $user->deleted_email_original)
                    ->whereNull('deleted_at')
                    ->where('id', '!=', $user->id)
                    ->exists();

                if ($existingActiveUser) {
                    return;
                }

                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'email' => $user->deleted_email_original,
                        'deleted_email_original' => null,
                    ]);
            });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_email_original');
        });
    }
};