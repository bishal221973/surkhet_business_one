<?php

namespace Database\Seeders;

use App\Models\MailFormat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MailFormat::create([
            'organization_id' => 1,
            'type' => 'employee_welcome_mail',
            'subject' => 'Welcome to the Team at {{company_name}}',
            'body' => 'Dear {{employee_name}},<br><br>Welcome to {{company_name}}! 🎉<br><br>Your journey with us officially begins on {{joining_date}}, and we’re confident that your skills and experience will make a valuable contribution to our organization.<br>🔐 Login Details<br><br>&nbsp; &nbsp; Email :&nbsp; {{email}}<br>&nbsp; &nbsp; Password : {{password}}<br><br>If you have any questions or need assistance, feel free to reach out to {{company_email}}.<br><br>Once again, welcome aboard! We look forward to working with you and wish you great success in your new role.<br><br>Warm regards,<br>{{company_name}}<br>{{company_address}}',
        ]);
        MailFormat::create([
            'organization_id' => 1,
            'type' => 'client_welcome_mail',
            'subject' => 'Welcome to {{company_name}}!',
            'body' => 'Dear {{client_name}},<br><br>

        Welcome to {{company_name}}! 🎉<br><br>

        We are thrilled to have you onboard and look forward to a great collaboration.<br><br>

        If you have any questions or need assistance, feel free to reach out to us at {{company_email}}.<br><br>

        Warm regards,<br>
        {{company_name}}<br>
        {{company_email}}<br>
        {{company_address}}',
        ]);
    }
}
