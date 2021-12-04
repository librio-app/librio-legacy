<?php

namespace App\Http\Controllers\Install;

use App\Utilities\Installer;
use File;
use Illuminate\Routing\Controller;

class RequirementsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function show()
    {
        // Check requirements
        $requirements = Installer::checkServerRequirements();

        if (empty($requirements)) {
            // Create the .env file
            if (!File::exists(base_path('.env'))) {
                Installer::createDefaultEnvFile();
            }

            redirect('install/language')->send();
        } else {
            foreach ($requirements as $requirement) {
                flash($requirement)->error()->important();
            }

            return view('install.requirements.show');
        }
    }
}
