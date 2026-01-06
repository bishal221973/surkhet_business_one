<div class="col-md-3  mb-3" >
    <div class="list-group bg-warning shadow1">
        <a href="{{ route('organization.setting') }}" class="setting-menu list-group-item list-group-item-action {{Route::currentRouteName() == 'organization.setting' ? 'active' : ''}}">
            Organization Settings
        </a>
        <a href="{{ route('email.setting') }}" class="setting-menu list-group-item list-group-item-action {{ Route::currentRouteName() == 'email.setting' ? 'active' : '' }}">Email Settings</a>
        <a href="{{ route('user.my.profile') }}" class="setting-menu list-group-item list-group-item-action {{ Route::currentRouteName() == 'user.my.profile' ? 'active' : '' }}">User Account Settings</a>
        <a href="{{ route('fiscalyear.index') }}" class="setting-menu list-group-item list-group-item-action {{ Route::currentRouteName() == 'fiscalyear.index' ? 'active' : '' }}">Fiscal Year</a>
    </div>
</div>
