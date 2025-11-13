<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    /**
     * Show the settings editor
     */
    public function edit()
    {
        $configPath = config_path('site.php');
        $config = include $configPath;

        return view('admin.settings.edit', [
            'config' => $config,
        ]);
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_number' => 'required|string|max:20',
            'whatsapp_message' => 'required|string|max:500',
            'email' => 'required|email|max:100',
            'instagram' => 'required|url|max:255',
        ]);

        $configPath = config_path('site.php');

        // Build the new config file content
        $content = <<<PHP
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Site Contact Information
    |--------------------------------------------------------------------------
    |
    | Información de contacto del sitio que se usa en varios lugares
    | como footer, flotantes de WhatsApp, enlaces de contacto, etc.
    |
    */

    'whatsapp' => [
        'number' => '{$validated['whatsapp_number']}',
        'message' => '{$validated['whatsapp_message']}',
    ],

    'email' => '{$validated['email']}',

    'social' => [
        'instagram' => '{$validated['instagram']}',
    ],
];

PHP;

        // Write to file
        File::put($configPath, $content);

        // Clear config cache
        \Artisan::call('config:clear');

        return redirect()->back()->with('success', 'Configuración actualizada exitosamente');
    }
}
