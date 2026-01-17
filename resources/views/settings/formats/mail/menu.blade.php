<div class="w-full">
    <a href="{{ route('employee.welcome.mail.format') }}?format=employee_welcome_mail" class="btn menu-format {{ request()->format == 'employee_welcome_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Welcome Employee Mail</a>
    <a href="{{ route('employee.welcome.mail.format') }}?format=client_welcome_mail" class="btn menu-format {{ request()->format == 'client_welcome_mail' ? 'active' : 'btn-secondary' }}" style="font-size: 13px">Welcome Client Mail</a>
</div>
