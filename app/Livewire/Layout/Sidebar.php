<?php

namespace App\Livewire\Layout;

use App\Models\SettingApp;
use App\Models\User;
use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        $setting = SettingApp::first();
        $logoUrl = $setting?->logo ? asset('storage/uploads/logos/' . $setting->logo) : asset('assets/img/favicon/favicon.ico');

        $userManagementPermissions = ['permissions.index', 'role.index', 'users.index'];

        // Home Route
        $isHomeRoute = request()->routeIs('home');

        // Product Route
        $isProductRoute = request()->routeIs('products.*');

        // Scheme & Competency Routes
        $isSchemeRoute = request()->routeIs('schemes.*');
        $isComRoute = request()->routeIs('competencies.*');
        $isSchemeComOpen = $isSchemeRoute || $isComRoute;
        $schemeComMenuClass = $isSchemeComOpen ? 'open active' : '';
        $schemeComToggleClass = $isSchemeComOpen ? 'menu-link menu-toggle active' : 'menu-link menu-toggle';
        $schemeComSubmenuStyle = $isSchemeComOpen ? 'display: block;' : '';

        // User Routes
        $isUserRoute = request()->routeIs('users.*');
        $isDocumentRoute = request()->routeIs('documents.*') || request()->routeIs('general-informations.*') || request()->routeIs('curricula.*') || request()->routeIs('silabus.*') || request()->routeIs('lesson-plans.*') || request()->routeIs('equipments.*') || request()->routeIs('supplys.*');
        $isUserDocumentOpen = $isUserRoute || $isDocumentRoute;

        // Role & Permission Routes
        $isRoleRoute = request()->routeIs('roles.*');
        $isPermissionRoute = request()->routeIs('permissions.*');
        $isRolePermissionOpen = $isRoleRoute || $isPermissionRoute;
        $rolePermissionMenuClass = $isRolePermissionOpen ? 'open active' : '';
        $rolePermissionToggleClass = $isRolePermissionOpen ? 'menu-link menu-toggle active' : 'menu-link menu-toggle';
        $rolePermissionSubmenuStyle = $isRolePermissionOpen ? 'display: block;' : '';

        /** @var User|null $user */
        $user = auth()->user();
        $canAccessUserManagement = $user?->canAny($userManagementPermissions) ?? false;
        $appName = $setting->thumbnail ?? 'Base App Template';

        return view('livewire.layout.sidebar', compact('logoUrl', 'isHomeRoute', 'isProductRoute', 'isSchemeRoute', 'isComRoute', 'isDocumentRoute', 'schemeComMenuClass', 'schemeComToggleClass', 'schemeComSubmenuStyle', 'isUserRoute', 'isRoleRoute', 'isPermissionRoute', 'rolePermissionMenuClass', 'rolePermissionToggleClass', 'rolePermissionSubmenuStyle', 'canAccessUserManagement', 'appName'));
    }
}
