<?php
namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\CelestialRegistro;
use Illuminate\Http\Request;

class CelestialController extends Controller
{
    public function index()
    {
        $registros = CelestialRegistro::with('evento')->latest()->paginate(15);
        return view('pages.celestial.index', compact('registros'));
    }

    public function create()
    {
        $cultos = Evento::where('tipo_evento', 'culto_dominical')
            ->whereDoesntHave('celestialRegistro')
            ->latest('data')->take(10)->get();
        return view('pages.celestial.create', compact('cultos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'evento_id'        => 'required|exists:eventos,id',
            'total_criancas'   => 'required|integer|min:0',
            'total_professores'=> 'required|integer|min:0',
        ]);

        CelestialRegistro::create($request->only(['evento_id','total_criancas','total_professores','observacoes']));
        return redirect()->route('celestial.index')->with('success', 'Classe Celestial registada!');
    }

    public function destroy(CelestialRegistro $reg)
    {
        $reg->delete();
        return redirect()->route('celestial.index')->with('success', 'Registo eliminado.');
    }
}
