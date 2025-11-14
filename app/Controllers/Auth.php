<?php
namespace App\Controllers;

use App\Models\PerfilModel;
use App\Models\DatosUsuarioModel;

class Auth extends BaseController
{
    protected $helpers = ['url', 'form'];

    public function index()
    {
        return view('pagina/login');
    }

    public function acceder()
    {
    $usuario = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $perfilModel = new PerfilModel();
    $perfil = $perfilModel->login($usuario, $password);

    if (!$perfil) {
        return redirect()->back()->with('error', 'Credenciales incorrectas');
    }

    session()->set([
        'id_usuario' => $perfil['id_usuario'],
        'id_rol'     => $perfil['id_rol'],
        'logueado'   => true
    ]);

        switch ($perfil['id_rol']) {
            case 1:
                return redirect()->to('/admin/dashboard_admin');
            case 2:
                return redirect()->to('/admin/dashboard_admin');
            case 3:
                return redirect()->to('/usuarios/dashboard');

            default:
                session()->destroy();
                return redirect()->to('/login')->with('error', 'Rol no válido');
        }
    }

    public function registrar()
    {
        $datosUsuarioModel = new DatosUsuarioModel();
        $perfilModel = new PerfilModel();

        // Insertar datos en datos_usuarios
        $dataUser = [
            'cedula'   => $this->request->getPost('cedula'),
            'nombre'   => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'correo'   => $this->request->getPost('correo'),
            'telefono' => $this->request->getPost('telefono'),
            'genero'   => $this->request->getPost('genero'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),

        ];

        $datosUsuarioModel->insert($dataUser);

        $idUsuario = $datosUsuarioModel->insertID();

        // Insertar perfil
        $perfilModel->insert([
            'nombre_usuario' => strtolower($dataUser["nombre"] . "." . $dataUser["apellido"]),
            'contraseña'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'id_usuario'     => $idUsuario,
            'id_rol'         => 3
        ]);

        return redirect()->to('/login')->with('mensaje', 'Cuenta creada exitosamente.');
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to('login');
    }

    public function crear_usuario()
    {
        return view('pagina/registrar');
    }
}
