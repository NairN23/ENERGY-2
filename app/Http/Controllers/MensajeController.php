<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    /**
     * Guardar un mensaje de contacto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'asunto' => 'nullable|string|max:255',
            'contenido' => 'required|string',
        ]);

        $nombre = $request->nombre;
        $email = $request->email;

        if (auth()->check()) {
            $nombre = $nombre ?? auth()->user()->name;
            $email = $email ?? auth()->user()->email;
        }

        Mensaje::create([
            'nombre' => $nombre ?? 'Visitante Anónimo',
            'email' => $email ?? 'visita@energy.com',
            'telefono' => $request->telefono,
            'asunto' => $request->asunto ?? 'Consulta General ENERGY',
            'contenido' => $request->contenido,
            'user_id' => auth()->id(),
            'leido' => false,
        ]);

        return redirect()->route('contacto')->with('success', 'Mensaje enviado correctamente. Nos pondremos en contacto pronto.');
    }
}
