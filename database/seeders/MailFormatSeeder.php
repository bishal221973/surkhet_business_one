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



        MailFormat::create([
            'organization_id' => 1,
            'type' => 'invoice_created_mail',
            'subject' => 'New Invoice from {{company_name}}',
            'body' => '
        Dear {{client_name}},<br><br>

        A new invoice has been generated for you by {{company_name}}.<br><br>

        <strong>Invoice Details:</strong><br>
        &nbsp;&nbsp; Invoice Number: {{invoice_number}}<br>
        &nbsp;&nbsp; Invoice Date: {{invoice_date}}<br>
        &nbsp;&nbsp; Due Date: {{due_date}}<br>
        &nbsp;&nbsp; Amount: {{amount}}<br><br>

        You can view your invoice and make payment using the link below:<br>
        <a href="{{invoice_link}}">View Invoice</a><br><br>

        If you have any questions regarding this invoice, please reach out to us at {{company_email}}.<br><br>

        Warm regards,<br>
        {{company_name}}<br>
        {{company_email}}<br>
        {{company_address}}
    ',


        ]);

        MailFormat::create([
            'organization_id' => 1,
            'type' => 'payment_received_mail',
            'subject' => 'Payment Received for Invoice #{{invoice_number}} from {{company_name}}',
            'body' => '
        Dear {{client_name}},<br><br>

        We are pleased to inform you that we have received your payment for the following invoice:<br><br>

        <strong>Invoice Details:</strong><br>
        &nbsp;&nbsp; Invoice Number: {{invoice_number}}<br>
        &nbsp;&nbsp; Invoice Date: {{invoice_date}}<br>
        &nbsp;&nbsp; Payment Date: {{payment_date}}<br>
        &nbsp;&nbsp; Amount Paid: {{amount}}<br><br>

        Thank you for your prompt payment! If you have any questions regarding this payment or your invoice, please feel free to contact us at {{company_email}}.<br><br>

        Warm regards,<br>
        {{company_name}}<br>
        {{company_email}}<br>
        {{company_address}}
    ',


        ]);

        MailFormat::create([
            'organization_id' => 1,
            'type' => 'upcoming_due_mail',
            'subject' => 'Upcoming Payment Due for Invoice #{{invoice_number}} from {{company_name}}',
            'body' => '
        Dear {{client_name}},<br><br>

        This is a friendly reminder that the following invoice is approaching its due date:<br><br>

        <strong>Invoice Details:</strong><br>
        &nbsp;&nbsp; Invoice Number: {{invoice_number}}<br>
        &nbsp;&nbsp; Invoice Date: {{invoice_date}}<br>
        &nbsp;&nbsp; Due Date: {{due_date}}<br>
        &nbsp;&nbsp; Amount Due: {{amount}}<br><br>

        We kindly request you to make the payment by the due date to avoid any late fees.<br><br>

        If you have already made the payment, please disregard this notice. For any questions, feel free to contact us at {{company_email}}.<br><br>

        Warm regards,<br>
        {{company_name}}<br>
        {{company_email}}<br>
        {{company_address}}
    ',


        ]);

        MailFormat::create([
            'organization_id' => 1,
            'type' => 'overdues_mail',
            'subject' => 'Overdue Payment Reminder for Invoice #{{invoice_number}} from {{company_name}}',
            'body' => '
        Dear {{client_name}},<br><br>

        Our records indicate that the following invoice is past its due date:<br><br>

        <strong>Invoice Details:</strong><br>
        &nbsp;&nbsp; Invoice Number: {{invoice_number}}<br>
        &nbsp;&nbsp; Invoice Date: {{invoice_date}}<br>
        &nbsp;&nbsp; Due Date: {{due_date}}<br>
        &nbsp;&nbsp; Amount Due: {{amount}}<br><br>

        We kindly request that you make the payment at your earliest convenience to avoid further late fees or interruptions in service.<br><br>

        If you have already made the payment, please disregard this notice. For any questions or assistance, feel free to contact us at {{company_email}}.<br><br>

        Warm regards,<br>
        {{company_name}}<br>
        {{company_email}}<br>
        {{company_address}}
    ',
        ]);

    }
}
