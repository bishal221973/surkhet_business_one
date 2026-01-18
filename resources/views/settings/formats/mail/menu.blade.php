{{-- <div class="w-full" style="width: 100%;overflow:auto">
    <a href="{{ route('employee.welcome.mail.format') }}?format=employee_welcome_mail" class="btn menu-format {{ request()->format == 'employee_welcome_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Welcome Employee Mail</a>
    <a href="{{ route('employee.welcome.mail.format') }}?format=client_welcome_mail" class="btn menu-format {{ request()->format == 'client_welcome_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Welcome Client Mail</a>
    <a href="{{ route('employee.welcome.mail.format') }}?format=invoice_created_mail" class="btn menu-format {{ request()->format == 'invoice_created_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Invoice Created Mail</a>
    <a href="{{ route('employee.welcome.mail.format') }}?format=payment_received_mail" class="btn menu-format {{ request()->format == 'payment_received_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Payment Received</a>
    <a href="{{ route('employee.welcome.mail.format') }}?format=overdues_mail" class="btn menu-format {{ request()->format == 'overdues_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Overdues</a>
</div> --}}
<div class="w-full" style="overflow-x: auto; white-space: nowrap; padding-bottom: 5px;">
    <a href="{{ route('employee.welcome.mail.format') }}?format=employee_welcome_mail" class="btn menu-format {{ request()->format == 'employee_welcome_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px; display: inline-block; margin-right: 5px;">Welcome Employee Mail</a>

    <a href="{{ route('employee.welcome.mail.format') }}?format=client_welcome_mail" class="btn menu-format {{ request()->format == 'client_welcome_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px; display: inline-block; margin-right: 5px;">Welcome Client Mail</a>

    <a href="{{ route('employee.welcome.mail.format') }}?format=invoice_created_mail" class="btn menu-format {{ request()->format == 'invoice_created_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px; display: inline-block; margin-right: 5px;">Invoice Created Mail</a>

    <a href="{{ route('employee.welcome.mail.format') }}?format=payment_received_mail" class="btn menu-format {{ request()->format == 'payment_received_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px; display: inline-block; margin-right: 5px;">Payment Received</a>

    <a href="{{ route('employee.welcome.mail.format') }}?format=upcoming_due_mail" class="btn menu-format {{ request()->format == 'upcoming_due_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px; display: inline-block; margin-right: 5px;">Upcomming Dues</a>
    <a href="{{ route('employee.welcome.mail.format') }}?format=overdues_mail" class="btn menu-format {{ request()->format == 'overdues_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px; display: inline-block; margin-right: 5px;">Overdues</a>
</div>
