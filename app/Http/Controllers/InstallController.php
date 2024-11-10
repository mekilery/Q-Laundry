<?php
namespace App\Http\Controllers;
use App\Http\Middleware\RedirectIfInstalled;
use App\Http\Requests\InstallRequest;
use App\Install\App;
use App\Install\Database;
use App\Install\Requirement;
use Illuminate\Contracts\Cache\Factory;
use Exception;
use PDOException;
use Illuminate\Support\Facades\File;

class InstallController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectIfInstalled::class);
    }
    public function install(Requirement $requirement)
    {
        return view('install.installation', compact('requirement'));
    }
    public function dbsettings(Requirement $requirement)
    {
        if (!$requirement->satisfied()) {
            return redirect('install/installation');
        }
        return view('install.dbsettings', compact('requirement'));
    }
    public function postDatabase(
        InstallRequest $request,
        Database $database,
        App $app,
        Factory $cache
    )
    {
        set_time_limit(3000);
         try {
             try {
                $database->setup($request->db);
             } catch (Exception $pe) {
                return back()->withInput()
                ->with(['error_message' => $pe->getMessage()]);
             }

            $app->setup();
         } catch (Exception $e) {
             return redirect()->back()->withInput()->with(['message' => $e->getMessage()]);
         }
        return redirect('install/completed');
    }

    public function install_completed()
    {
        
        unlink(base_path('install'));
        return view('install.completed');
    }
}