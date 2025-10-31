<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
       

        @permission('church_branch manage')
            <a href="{{ route('churchbranch.index') }}"
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('churchbranch.*') ? 'active' : '' }}">
                {{ __('Branch') }}
                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
            </a>
        @endpermission


        @permission('church_department manage')
            <a href="{{ route('churchly.departments.index') }}" 
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('churchly.*') ? 'active' : '' }}">{{__('Departments')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endpermission

        @permission('church_volunteer manage')
            <a href="{{ route('churchly.volunteers.index') }}" 
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('churchly.volunteers.*') ? 'active' : '' }}">{{__('Volunteers')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endpermission

        @permission('church_household manage')
            <a href="{{ route('churchly.households.index') }}"
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('churchly.households.*') ? 'active' : '' }}">{{ __('Households') }}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endpermission

        @permission('church_settings manage')
            <a href="{{ route('churchly.zoom.index') }}"
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('churchly.zoom.*') ? 'active' : '' }}">{{ __('Zoon Integration') }}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endpermission


        @permission('church_designation manage')
            <a href="{{ route('churchdesignation.index') }}" 
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('churchdesignation.*') ? 'active' : '' }}">{{__('Designation')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endpermission

        @permission('church_documenttype manage')
            <a href="{{ route('zender.whatsapp.groups') }}" 
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('zender.*') ? 'active' : '' }}">{{__('Document Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endpermission
       
        @permission('church_settings manage')
            <a href="{{ route('wa_group.index') }}" 
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('wa_group.*') ? 'active' : '' }}">{{__('Assign WhatsApp Group')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endpermission
        <a href="{{ route('formsetup.index') }}" 
        class="list-group-item list-group-item-action border-0 {{ request()->routeIs('formsetup.*') ? 'active' : '' }}">{{__('Custom Member Form')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>    
        @permission('church_settings manage')
            <a href="{{ route('sms-gateway.edit') }}" 
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('sms-gateway.*') ? 'active' : '' }}">{{__('SMS Gateway Settings')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endpermission
        @permission('church_settings manage')
            <a href="{{ route('discipleship.index') }}" 
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('discipleship.*') ? 'active' : '' }}">{{__('Setup Discipleship Pathway')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endpermission

        @permission('church_settings manage')
            <a href="{{ route('birthday_templates.index') }}" 
            class="list-group-item list-group-item-action border-0 {{ request()->routeIs('birthday_templates.*') ? 'active' : '' }}">{{__('Birthday Templates')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endpermission
        
   
       
       
    </div>
</div>

