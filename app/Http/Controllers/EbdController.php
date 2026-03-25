<?php
namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\EbdRegistro;
use Illuminate\Http\Request;

class EbdController extends Controller
{
    public function index()
    {
        $registros = EbdRegistro::with('evento')->latest()->paginate(15);
        return view('pages.ebd.index', compact('registros'));
    }

    public function create()
    {
        /* Cultos do último mês sem EBD registada */
        $cultos = Evento::where('tipo_evento', 'culto_dominical')
            ->whereDoesntHave('ebdRegistro')
            ->latest('data')->take(10)->get();

        $ultimoCultoTotal = Evento::with('presencaCulto')
            ->where('tipo_evento', 'culto_dominical')
            ->latest('data')->first()?->presencaCulto?->total ?? 0;

        return view('pages.ebd.create', compact('cultos', 'ultimoCultoTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'evento_id'      => 'required|exists:eventos,id',
            'professor'      => 'required|string|max:150',
            'tema'           => 'required|string|max:255',
            'total_presentes'=> 'required|integer|min:0',
        ]);

        EbdRegistro::create($request->only(['evento_id','professor','tema','total_presentes','observacoes']));

        return redirect()->route('ebd.index')->with('success', 'EBD registada com sucesso!');
    }

    public function show(EbdRegistro $ebd)
    {
        $ebd->load('evento');
        return view('pages.ebd.show', compact('ebd'));
    }

    public function update(Request $request, EbdRegistro $ebd)
    {
        $ebd->update($request->only(['professor','tema','total_presentes','observacoes']));
        return redirect()->route('ebd.index')->with('success', 'EBD actualizada!');
    }

    public function destroy(EbdRegistro $ebd)
    {
        $ebd->delete();
        return redirect()->route('ebd.index')->with('success', 'Registo eliminado.');
    }
}
