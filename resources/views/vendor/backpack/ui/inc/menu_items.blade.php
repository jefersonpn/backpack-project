{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('labels.dashboard') }}</a></li>

<x-backpack::menu-item title="{{ trans('labels.users') }}" icon="la la-user" :link="backpack_url('user')" />
