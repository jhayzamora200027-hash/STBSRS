<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add missing columns only if they don't already exist
        if (!Schema::hasColumn('ticket_comments', 'ticket_id')) {
            Schema::table('ticket_comments', function (Blueprint $table) {
                $table->foreignId('ticket_id')
                    ->constrained('tickets')
                    ->cascadeOnDelete()
                    ->after('id');
            });
        }

        if (!Schema::hasColumn('ticket_comments', 'user_id')) {
            Schema::table('ticket_comments', function (Blueprint $table) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete()
                    ->after('ticket_id');
            });
        }

        if (!Schema::hasColumn('ticket_comments', 'guest_name')) {
            Schema::table('ticket_comments', function (Blueprint $table) {
                $table->string('guest_name')->nullable()->after('user_id');
            });
        }

        if (!Schema::hasColumn('ticket_comments', 'guest_email')) {
            Schema::table('ticket_comments', function (Blueprint $table) {
                $table->string('guest_email')->nullable()->after('guest_name');
            });
        }

        if (!Schema::hasColumn('ticket_comments', 'comment')) {
            Schema::table('ticket_comments', function (Blueprint $table) {
                $table->longText('comment')->after('guest_email');
            });
        }

        if (!Schema::hasColumn('ticket_comments', 'parent_id')) {
            Schema::table('ticket_comments', function (Blueprint $table) {
                // add as unsignedBigInteger first, then add foreign key to same table
                $table->unsignedBigInteger('parent_id')->nullable()->after('comment');
            });

            // Add foreign key for parent_id in a separate step
            Schema::table('ticket_comments', function (Blueprint $table) {
                $table->foreign('parent_id')
                    ->references('id')
                    ->on('ticket_comments')
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('ticket_comments', function (Blueprint $table) {
            if (Schema::hasColumn('ticket_comments', 'parent_id')) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                // attempt to drop foreign if exists
                try { $table->dropForeign(['parent_id']); } catch (\Exception $e) {}
            }

            if (Schema::hasColumn('ticket_comments', 'comment')) {
                $table->dropColumn('comment');
            }
            if (Schema::hasColumn('ticket_comments', 'guest_email')) {
                $table->dropColumn('guest_email');
            }
            if (Schema::hasColumn('ticket_comments', 'guest_name')) {
                $table->dropColumn('guest_name');
            }
            if (Schema::hasColumn('ticket_comments', 'user_id')) {
                try { $table->dropForeign(['user_id']); } catch (\Exception $e) {}
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('ticket_comments', 'ticket_id')) {
                try { $table->dropForeign(['ticket_id']); } catch (\Exception $e) {}
                $table->dropColumn('ticket_id');
            }
            if (Schema::hasColumn('ticket_comments', 'parent_id')) {
                $table->dropColumn('parent_id');
            }
        });
    }
};
