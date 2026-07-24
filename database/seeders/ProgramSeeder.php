<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            'Aruga at Kalinga para sa mga Bata sa Barangay',
            'Buklod Paglaom para sa CICL',
            'Cash Transfer Cash Voucher for Affected Families in Emergencies',
            'Community Action and Resources for Accessible and Better Living Environment',
            'Comprehensive Delivery of Reintegration Services for Deportees and Irregular OFWs',
            'Comprehensive Intervention Against Gender-based Violence',
            'Counseling Service for Rehabilitation of Perpetrators of Domestic Violence',
            'Family Drug Abuse Prevention Program',
            'Gender Responsive Case Management',
            'Home Care Support for Senior Citizens',
            'Modified Social Stress Model',
            'Music and Arts Therapy Program',
            'Psychosocial Care and Support for Persons Living with HIV',
            'Reporting System and Prevention Program on Elder Abuse Cases (RESPPEC)',
            'Sama-Bajau Localized Intervention and Learning Approach for Holistic Development (SALINLAHI)',
            'Sheltered Workshop for Persons with Disability and Older Person',
            'SHIELD Against Child Labor',
            'Special Drug Education Center',
            'Team Balikatan Rescue in Emergency (TEAMBRE)',
            'Women Friendly Space (WFS)',
            'Yakap Bayan Program for RPWUDs',
        ];

        foreach ($programs as $index => $program) {
            $admin = User::where('email', 'jpzamora@dswd.gov.ph')->first();
            Program::firstOrCreate(
                
                ['program' => $program],
                [
                    'program_id' => 'PRG-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'created_by' => $admin->id,
                    'created_at' => Carbon::now()->toDateString(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}