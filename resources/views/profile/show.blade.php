@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [['link' => 'home', 'name' => 'Home'], ['link' => 'javascript:void(0)', 'name' => 'User'], ['name' => 'Profile']];

use App\Http\Controllers\CustomPermissionController;
$custom_permission_controller = new CustomPermissionController;
$custom_get_all_permissions_access = $custom_permission_controller->custom_get_all_permissions();

@endphp

@section('title', 'Profile')


@section('content')

  @if (Laravel\Fortify\Features::canUpdateProfileInformation())
    @livewire('profile.update-profile-information-form')
  @endif

  @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
    @livewire('profile.update-password-form')
  @endif

  @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
    @livewire('profile.two-factor-authentication-form')
  @endif

  @livewire('profile.logout-other-browser-sessions-form')

  @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
    @livewire('profile.delete-user-form')
  @endif

@endsection
