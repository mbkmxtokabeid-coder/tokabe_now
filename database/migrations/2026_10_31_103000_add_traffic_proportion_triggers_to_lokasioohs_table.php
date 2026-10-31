<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_lokasioohs_traffic_before_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_lokasioohs_traffic_before_update');

        DB::unprepared("
            CREATE TRIGGER trg_lokasioohs_traffic_before_insert
            BEFORE INSERT ON lokasioohs
            FOR EACH ROW
            SET
                @v_clean_total = REGEXP_REPLACE(IFNULL(NEW.daily_total_traffic, ''), '[^0-9]', ''),
                @v_clean_motor = REGEXP_REPLACE(IFNULL(NEW.motor, ''), '[^0-9]', ''),
                @v_clean_mobil = REGEXP_REPLACE(IFNULL(NEW.mobil, ''), '[^0-9]', ''),
                @v_total = IF(@v_clean_total != '', CAST(@v_clean_total AS UNSIGNED), 0),
                @v_motor = IF(@v_clean_motor != '', CAST(@v_clean_motor AS UNSIGNED), 0),
                @v_mobil = IF(@v_clean_mobil != '', CAST(@v_clean_mobil AS UNSIGNED), 0),
                @is_motor_empty = (NEW.motor IS NULL OR TRIM(NEW.motor) = '' OR TRIM(NEW.motor) = '-'),
                @is_mobil_empty = (NEW.mobil IS NULL OR TRIM(NEW.mobil) = '' OR TRIM(NEW.mobil) = '-'),
                @is_total_empty = (NEW.daily_total_traffic IS NULL OR TRIM(NEW.daily_total_traffic) = '' OR TRIM(NEW.daily_total_traffic) = '-'),
                @use_dot_total = (IFNULL(NEW.daily_total_traffic, '') LIKE '%.%'),
                @use_dot_mm = (IFNULL(NEW.motor, '') LIKE '%.%' OR IFNULL(NEW.mobil, '') LIKE '%.%'),
                NEW.motor = CASE
                    WHEN NOT @is_total_empty AND @is_motor_empty AND @is_mobil_empty AND @v_total > 0 THEN
                        CONCAT('± ', IF(@use_dot_total, REPLACE(FORMAT(ROUND(@v_total * 0.80, 0), 0), ',', '.'), CAST(ROUND(@v_total * 0.80, 0) AS CHAR)))
                    WHEN NOT @is_motor_empty AND NEW.motor NOT LIKE '%±%' THEN
                        CONCAT('± ', TRIM(REPLACE(NEW.motor, '+-', '')))
                    ELSE NEW.motor
                END,
                NEW.mobil = CASE
                    WHEN NOT @is_total_empty AND @is_motor_empty AND @is_mobil_empty AND @v_total > 0 THEN
                        CONCAT('± ', IF(@use_dot_total, REPLACE(FORMAT(@v_total - ROUND(@v_total * 0.80, 0), 0), ',', '.'), CAST(@v_total - ROUND(@v_total * 0.80, 0) AS CHAR)))
                    WHEN NOT @is_mobil_empty AND NEW.mobil NOT LIKE '%±%' THEN
                        CONCAT('± ', TRIM(REPLACE(NEW.mobil, '+-', '')))
                    ELSE NEW.mobil
                END,
                NEW.daily_total_traffic = CASE
                    WHEN @is_total_empty AND (NOT @is_motor_empty OR NOT @is_mobil_empty) AND (@v_motor + @v_mobil) > 0 THEN
                        CONCAT('± ', IF(@use_dot_mm, REPLACE(FORMAT(@v_motor + @v_mobil, 0), ',', '.'), CAST(@v_motor + @v_mobil AS CHAR)))
                    WHEN NOT @is_total_empty AND NEW.daily_total_traffic NOT LIKE '%±%' THEN
                        CONCAT('± ', TRIM(REPLACE(NEW.daily_total_traffic, '+-', '')))
                    ELSE NEW.daily_total_traffic
                END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_lokasioohs_traffic_before_update
            BEFORE UPDATE ON lokasioohs
            FOR EACH ROW
            SET
                @v_clean_total = REGEXP_REPLACE(IFNULL(NEW.daily_total_traffic, ''), '[^0-9]', ''),
                @v_clean_motor = REGEXP_REPLACE(IFNULL(NEW.motor, ''), '[^0-9]', ''),
                @v_clean_mobil = REGEXP_REPLACE(IFNULL(NEW.mobil, ''), '[^0-9]', ''),
                @v_total = IF(@v_clean_total != '', CAST(@v_clean_total AS UNSIGNED), 0),
                @v_motor = IF(@v_clean_motor != '', CAST(@v_clean_motor AS UNSIGNED), 0),
                @v_mobil = IF(@v_clean_mobil != '', CAST(@v_clean_mobil AS UNSIGNED), 0),
                @is_motor_empty = (NEW.motor IS NULL OR TRIM(NEW.motor) = '' OR TRIM(NEW.motor) = '-'),
                @is_mobil_empty = (NEW.mobil IS NULL OR TRIM(NEW.mobil) = '' OR TRIM(NEW.mobil) = '-'),
                @is_total_empty = (NEW.daily_total_traffic IS NULL OR TRIM(NEW.daily_total_traffic) = '' OR TRIM(NEW.daily_total_traffic) = '-'),
                @mm_changed = ((IFNULL(NEW.motor, '') <> IFNULL(OLD.motor, '') OR IFNULL(NEW.mobil, '') <> IFNULL(OLD.mobil, '')) AND IFNULL(NEW.daily_total_traffic, '') = IFNULL(OLD.daily_total_traffic, '')),
                @total_changed = (IFNULL(NEW.daily_total_traffic, '') <> IFNULL(OLD.daily_total_traffic, '') AND IFNULL(NEW.motor, '') = IFNULL(OLD.motor, '') AND IFNULL(NEW.mobil, '') = IFNULL(OLD.mobil, '')),
                @calc_from_mm = ((NOT @is_motor_empty OR NOT @is_mobil_empty) AND (@is_total_empty OR @mm_changed)),
                @calc_from_total = (NOT @calc_from_mm AND NOT @is_total_empty AND ((@is_motor_empty AND @is_mobil_empty) OR @total_changed)),
                @use_dot_total = (IFNULL(NEW.daily_total_traffic, '') LIKE '%.%'),
                @use_dot_mm = (IFNULL(NEW.motor, '') LIKE '%.%' OR IFNULL(NEW.mobil, '') LIKE '%.%'),
                NEW.motor = CASE
                    WHEN @calc_from_total AND @v_total > 0 THEN
                        CONCAT('± ', IF(@use_dot_total, REPLACE(FORMAT(ROUND(@v_total * 0.80, 0), 0), ',', '.'), CAST(ROUND(@v_total * 0.80, 0) AS CHAR)))
                    WHEN NOT @is_motor_empty AND NEW.motor NOT LIKE '%±%' THEN
                        CONCAT('± ', TRIM(REPLACE(NEW.motor, '+-', '')))
                    ELSE NEW.motor
                END,
                NEW.mobil = CASE
                    WHEN @calc_from_total AND @v_total > 0 THEN
                        CONCAT('± ', IF(@use_dot_total, REPLACE(FORMAT(@v_total - ROUND(@v_total * 0.80, 0), 0), ',', '.'), CAST(@v_total - ROUND(@v_total * 0.80, 0) AS CHAR)))
                    WHEN NOT @is_mobil_empty AND NEW.mobil NOT LIKE '%±%' THEN
                        CONCAT('± ', TRIM(REPLACE(NEW.mobil, '+-', '')))
                    ELSE NEW.mobil
                END,
                NEW.daily_total_traffic = CASE
                    WHEN @calc_from_mm AND (@v_motor + @v_mobil) > 0 THEN
                        CONCAT('± ', IF(@use_dot_mm, REPLACE(FORMAT(@v_motor + @v_mobil, 0), ',', '.'), CAST(@v_motor + @v_mobil AS CHAR)))
                    WHEN NOT @is_total_empty AND NEW.daily_total_traffic NOT LIKE '%±%' THEN
                        CONCAT('± ', TRIM(REPLACE(NEW.daily_total_traffic, '+-', '')))
                    ELSE NEW.daily_total_traffic
                END
        ");

        DB::statement("UPDATE lokasioohs SET updated_at = updated_at");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_lokasioohs_traffic_before_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_lokasioohs_traffic_before_update');
    }
};
