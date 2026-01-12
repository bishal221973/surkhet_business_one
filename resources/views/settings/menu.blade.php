<div class="col-md-3  mb-3" >
    <div class="list-group bg-warning shadow1">
        <a href="{{ route('organization.setting') }}" class="setting-menu list-group-item list-group-item-action {{Route::currentRouteName() == 'organization.setting' ? 'active' : ''}}">
            Organization Settings
        </a>
        <a href="{{ route('email.setting') }}" class="setting-menu list-group-item list-group-item-action {{ Route::currentRouteName() == 'email.setting' ? 'active' : '' }}">Email Settings</a>
        <a href="{{ route('user.my.profile') }}" class="setting-menu list-group-item list-group-item-action {{ Route::currentRouteName() == 'user.my.profile' ? 'active' : '' }}">User Account Settings</a>
        <a href="{{ route('fiscalyear.index') }}" class="setting-menu list-group-item list-group-item-action {{ Route::currentRouteName() == 'fiscalyear.index' ? 'active' : '' }}">Fiscal Year</a>
        <a href="{{ route('paymentMode.index') }}" class="setting-menu list-group-item list-group-item-action {{ Route::currentRouteName() == 'paymentMode.index' ? 'active' : '' }}">Payment Mode</a>
        <a href="{{ route('bank.index') }}" class="setting-menu list-group-item list-group-item-action {{ Route::currentRouteName() == 'bank.index' ? 'active' : '' }}">Bank Account</a>
        <a href="{{ route('expenseCategory.index') }}" class="setting-menu list-group-item list-group-item-action {{ Route::currentRouteName() == 'expenseCategory.index' ? 'active' : '' }}">Expense Head</a>
        <a href="{{ route('unit.index') }}" class="setting-menu list-group-item list-group-item-action {{ Route::currentRouteName() == 'unit.index' ? 'active' : '' }}">Unit</a>
    </div>
</div>
