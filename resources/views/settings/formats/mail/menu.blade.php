<div class="w-full">
    <a href="{{ route('employee.welcome.mail.format') }}?format=employee_welcome_mail" class="btn menu-format {{ request()->format == 'employee_welcome_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Welcome Employee Mail</a>
    <a href="{{ route('employee.welcome.mail.format') }}?format=client_welcome_mail" class="btn menu-format {{ request()->format == 'client_welcome_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Welcome Client Mail</a>
    <a href="{{ route('employee.welcome.mail.format') }}?format=invoice_created_mail" class="btn menu-format {{ request()->format == 'invoice_created_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Invoice Created Mail</a>
    <a href="{{ route('employee.welcome.mail.format') }}?format=payment_received_mail" class="btn menu-format {{ request()->format == 'payment_received_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Payment Received</a>
</div>
