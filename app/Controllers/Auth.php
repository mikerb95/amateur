<?php
namespace App\Controllers;

use App\Models\PerfilModel;
use App\Models\DatosUsuarioModel;
use App\Models\PagoModel;
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

    public function Crear_usuarioAd()
    {
        return view('admin/Crear_usuario');
    }

    public function guardar_usuario()
{
    $model = new DatosUsuarioModel();

    $model->save([
        'nombre'   => $this->request->getPost('nombre'),
        'apellido' => $this->request->getPost('apellido'),
        'cedula'   => $this->request->getPost('cedula'),
        'correo'   => $this->request->getPost('correo'),
        'telefono' => $this->request->getPost('telefono'),
        'direccion'=> $this->request->getPost('direccion'),
        'genero'   => $this->request->getPost('genero'),
    ]);

    return redirect()->to(base_url('admin/usuarios'));
}


public function editar($idUsuario)
{
    $model = new DatosUsuarioModel();
    $data['usuario'] = $model->find($idUsuario);
    
    // Obtener el estado del pago del usuario
    $pagoModel = new PagoModel();
    $data['pago'] = $pagoModel->where('id_usuario', $idUsuario)->first();
    
    // Si no existe registro de pago, crear uno por defecto
    if (!$data['pago']) {
        $data['pago'] = ['estado' => 'Pago Pendiente'];
    }
    
    return view('adminCrud/editar', $data);
}
    public function eliminar($idUsuario)
{
    $perfilModel = new PerfilModel();
    $usuarioModel = new DatosUsuarioModel();

    // 1️⃣ Eliminar el perfil primero
    $perfilModel->where('id_usuario', $idUsuario)->delete();

    // 2️⃣ Luego eliminar el usuario
    $usuarioModel->delete($idUsuario);

    return redirect()
        ->to('/admin/usuarios')
        ->with('mensaje', 'Usuario eliminado correctamente');
}


}
