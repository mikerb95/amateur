<?
namespace App\Controllers;

use App\Models\DatosUsuarioModel;
use App\Models\ReservaModel;

class Usuarios extends BaseController
{
    public function index()
    {
        $usuarioModel = new DatosUsuarioModel();
        $reservaModel = new ReservaModel();

        $usuarios = $usuarioModel->findAll();

        foreach ($usuarios as &$usuario) {
            $reservas = $reservaModel->getByUsuario($usuario['id_usuario']);
            $usuario['tiene_reserva'] = !empty($reservas);
        }

        return view('usuarios/index', ['usuarios' => $usuarios]);
    }

    

    
}


?>
