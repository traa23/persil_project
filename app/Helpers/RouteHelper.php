<?php
/**
 * Helpers untuk menentukan route berdasarkan user role
 * Membantu super-admin mengakses fitur yang sama dengan admin
 */

// OLD CODE (DEPRECATED - untuk referensi awal):
// Function ini dibuat karena routes admin dan super-admin terpisah
// Admin routes: /admin/*
// Super Admin routes: /super-admin/*
// Tapi kedua role punya akses ke fitur yang sama, jadi perlu dynamic routing

if (! function_exists('getAdminRoute')) {
    /**
     * Get route name dengan prefix yang sesuai untuk admin/super_admin
     * @param string $name Nama route tanpa prefix (contoh: 'persil.list')
     * @param mixed ...$parameters Route parameters
     * @return string Route URL
     */
    function getAdminRoute($name, ...$parameters)
    {
        if (! auth()->check()) {
            return route('admin.' . $name, $parameters);
        }

        $prefix = auth()->user()->role === 'super_admin' ? 'super-admin.' : 'admin.';
        return route($prefix . $name, $parameters);
    }
}

if (! function_exists('getRoutePrefix')) {
    /**
     * Get route prefix berdasarkan user role
     * @return string 'admin' atau 'super-admin'
     */
    function getRoutePrefix()
    {
        if (! auth()->check()) {
            return 'admin';
        }

        return auth()->user()->role === 'super_admin' ? 'super-admin' : 'admin';
    }
}
