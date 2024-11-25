<?
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEvaluation(Request $request)
    {
        $selectedAgent = $request->input('sl_agente_audio');           
        $audioName = $request->input('sl_audio_general');          
        $observacion = $request->input('observacion');       

        $recipient = "mauricio@sinaptek.com";                 
        $subject = "Alerta de falta grave (malas palabras)";  

        try {
            Mail::send([], [], function ($message) use ($recipient, $subject, $selectedAgent, $audioName, $observacion) {
                $message->to($recipient)
                        ->subject($subject)
                        ->setBody("Se identifican malas palabras en el agente: $selectedAgent\nAudio asociado: $audioName\nObservación: $observacion", 'text/plain');
            });

            return response()->json(['success' => true, 'message' => 'Correo enviado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al enviar el correo: ' . $e->getMessage()]);
        }
    }
}

