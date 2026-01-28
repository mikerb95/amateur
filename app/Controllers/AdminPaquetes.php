<?php

namespace App\Controllers;

use App\Models\PaqueteClasesModel;
use App\Models\PaqueteCatalogoModel;
use App\Models\PlanModel;

use CodeIgniter\I18n\Time;

class AdminPaquetes extends BaseController
{
    public function __construct()
    {
        // Solo Admin (rol 1)
        if (!session('logueado') || session('id_rol') != 1) {
            redirect()->to('/login')->send();
            exit;
        }
    }

    /**
     * GET /admin/usuarios/{id}/paquetes
     * Lista paquetes de un usuario
     */
    public function index(int $idUsuario)
    {
        $paqueteModel = new PaqueteClasesModel();
        $paquetes = $paqueteModel->getByUsuario($idUsuario);

        return view('admin/paquetes/index', [
            'idUsuario' => $idUsuario,
            'paquetes'  => $paquetes,
        ]);
    }

    /**
     * GET /admin/usuarios/{id}/paquetes/nuevo
     * Form para asignar/crear paquete (ideal mostrando catálogo)
     */
    public function create(int $idUsuario)
    {
        $catModel = new PaqueteCatalogoModel();
        $catalogo = $catModel->where('activo', 1)->orderBy('id_catalogo', 'DESC')->findAll();

        return view('admin/paquetes/create', [
            'idUsuario' => $idUsuario,
            'catalogo'  => $catalogo,
        ]);
    }

    /**
     * POST /admin/usuarios/{id}/paquetes
     * Crea/asigna paquete.
     * - Si viene id_catalogo: asigna desde catálogo (recomendado)
     * - Si no viene id_catalogo: crea manual (por si lo necesitas)
     */
    public function store(int $idUsuario)
    {
        $paqueteModel = new PaqueteClasesModel();

        // ========= MODO CATÁLOGO =========
        $idCatalogo = (int) ($this->request->getPost('id_catalogo') ?? 0);
        if ($idCatalogo > 0) {
            $catModel = new PaqueteCatalogoModel();
            $cat = $catModel->where('activo', 1)->find($idCatalogo);

            if (!$cat) {
                return redirect()->back()->withInput()->with('mensaje', 'Paquete de catálogo no válido.');
            }

            $now   = Time::now('America/Bogota');
            $vence = $now->addDays((int) $cat['vigencia_dias']);

            // ✅ Regla recomendada: 1 ACTIVO por usuario
            $paqueteModel->desactivarOtrosActivos($idUsuario);

            $paqueteModel->insert([
                'id_usuario'        => $idUsuario,
                'total_clases'      => (int) $cat['clases_mes'],
                'clases_restantes'  => (int) $cat['clases_mes'],
                'fecha_inicio'      => $now->toDateTimeString(),
                'fecha_vencimiento' => $vence->toDateTimeString(),
                'estado'            => 'ACTIVO',
                'creado_por'        => (int) (session('id_usuario') ?? 0),
            ]);

            return redirect()->to("admin/usuarios/{$idUsuario}/paquetes")
                ->with('mensaje', 'Paquete asignado correctamente.');
        }

        // ========= MODO MANUAL (opcional) =========
        $data = $this->request->getPost();

        $rules = [
            'total_clases'      => 'required|is_natural_no_zero',
            'fecha_inicio'      => 'required|valid_date[Y-m-d]',
            'fecha_vencimiento' => 'required|valid_date[Y-m-d]',
            'estado'            => 'required|in_list[ACTIVO,INACTIVO]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $total = (int) $data['total_clases'];
        $restantes = isset($data['clases_restantes']) && $data['clases_restantes'] !== ''
            ? (int) $data['clases_restantes']
            : $total;

        if ($restantes > $total) {
            return redirect()->back()->withInput()->with('mensaje', 'Clases restantes no puede ser mayor al total.');
        }

        $inicio = Time::parse($data['fecha_inicio'] . ' 00:00:00', 'America/Bogota');
        $vence  = Time::parse($data['fecha_vencimiento'] . ' 23:59:59', 'America/Bogota');

        if ($vence->isBefore($inicio)) {
            return redirect()->back()->withInput()->with('mensaje', 'La fecha de vencimiento debe ser >= fecha inicio.');
        }

        if ($data['estado'] === 'ACTIVO') {
            $paqueteModel->desactivarOtrosActivos($idUsuario);
        }

        $paqueteModel->insert([
            'id_usuario'        => $idUsuario,
            'total_clases'      => $total,
            'clases_restantes'  => $restantes,
            'fecha_inicio'      => $inicio->toDateTimeString(),
            'fecha_vencimiento' => $vence->toDateTimeString(),
            'estado'            => $data['estado'],
            'creado_por'        => (int) (session('id_usuario') ?? 0),
        ]);

        return redirect()->to("admin/usuarios/{$idUsuario}/paquetes")
            ->with('mensaje', 'Paquete creado correctamente.');
    }

    /**
     * GET /admin/paquetes/{idPaquete}/editar
     */
    public function edit(int $idPaquete)
    {
        $paqueteModel = new PaqueteClasesModel();
        $paquete = $paqueteModel->find($idPaquete);

        if (!$paquete) {
            return redirect()->back()->with('mensaje', 'Paquete no existe.');
        }

        return view('admin/paquetes/edit', [
            'paquete' => $paquete,
        ]);
    }

    /**
     * POST /admin/paquetes/{idPaquete}/update
     */
    public function update(int $idPaquete)
    {
        $paqueteModel = new PaqueteClasesModel();
        $paquete = $paqueteModel->find($idPaquete);

        if (!$paquete) {
            return redirect()->back()->with('mensaje', 'Paquete no existe.');
        }

        $data = $this->request->getPost();

        $rules = [
            'total_clases'      => 'required|is_natural_no_zero',
            'clases_restantes'  => 'required|is_natural',
            'fecha_inicio'      => 'required|valid_date[Y-m-d]',
            'fecha_vencimiento' => 'required|valid_date[Y-m-d]',
            'estado'            => 'required|in_list[ACTIVO,INACTIVO]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $total = (int) $data['total_clases'];
        $rest  = (int) $data['clases_restantes'];

        if ($rest > $total) {
            return redirect()->back()->withInput()->with('mensaje', 'Clases restantes no puede ser mayor al total.');
        }

        $inicio = Time::parse($data['fecha_inicio'] . ' 00:00:00', 'America/Bogota');
        $vence  = Time::parse($data['fecha_vencimiento'] . ' 23:59:59', 'America/Bogota');

        if ($vence->isBefore($inicio)) {
            return redirect()->back()->withInput()->with('mensaje', 'La fecha de vencimiento debe ser >= fecha inicio.');
        }

        // ✅ si lo activas, apaga otros
        if ($data['estado'] === 'ACTIVO') {
            $paqueteModel->desactivarOtrosActivos((int) $paquete['id_usuario'], $idPaquete);
        }

        $paqueteModel->update($idPaquete, [
            'total_clases'      => $total,
            'clases_restantes'  => $rest,
            'fecha_inicio'      => $inicio->toDateTimeString(),
            'fecha_vencimiento' => $vence->toDateTimeString(),
            'estado'            => $data['estado'],
        ]);

        return redirect()->to("admin/usuarios/{$paquete['id_usuario']}/paquetes")
            ->with('mensaje', 'Paquete actualizado correctamente.');
    }

    /**
     * POST /admin/paquetes/{idPaquete}/delete
     */
    public function delete(int $idPaquete)
    {
        $paqueteModel = new PaqueteClasesModel();
        $paquete = $paqueteModel->find($idPaquete);

        if (!$paquete) {
            return redirect()->back()->with('mensaje', 'Paquete no existe.');
        }

        $idUsuario = (int) $paquete['id_usuario'];

        $paqueteModel->delete($idPaquete);

        return redirect()->to("admin/usuarios/{$idUsuario}/paquetes")
            ->with('mensaje', 'Paquete eliminado correctamente.');
    }

    /**
     * Mantengo tu endpoint anterior por si ya lo estás usando en un form viejo:
     * POST /admin/paquetes/asignar
     * (Recomendación: migrar al store($idUsuario) y luego eliminar esta ruta y este método)
     */
    public function asignar()
    {
        $idUsuario  = (int) $this->request->getPost('id_usuario');
        $idCatalogo = (int) $this->request->getPost('id_catalogo');

        if ($idUsuario <= 0 || $idCatalogo <= 0) {
            return redirect()->back()->with('mensaje', 'Datos inválidos.');
        }

        $catModel = new PaqueteCatalogoModel();
        $cat = $catModel->where('activo', 1)->find($idCatalogo);

        if (!$cat) {
            return redirect()->back()->with('mensaje', 'Paquete no válido.');
        }

        $now   = Time::now('America/Bogota');
        $vence = $now->addDays((int)$cat['vigencia_dias']);

        $paqueteModel = new PaqueteClasesModel();

        // ✅ 1 ACTIVO por usuario
        $paqueteModel->desactivarOtrosActivos($idUsuario);

        $paqueteModel->insert([
            'id_usuario'        => $idUsuario,
            'total_clases'      => (int)$cat['clases_mes'],
            'clases_restantes'  => (int)$cat['clases_mes'],
            'fecha_inicio'      => $now->toDateTimeString(),
            'fecha_vencimiento' => $vence->toDateTimeString(),
            'estado'            => 'ACTIVO',
            'creado_por'        => (int) (session('id_usuario') ?? 0),
        ]);

        return redirect()->back()->with('mensaje', 'Paquete asignado correctamente.');
    }

public function planes()
{
    // pantalla de buscar por cédula para asignar planes/paquetes
    return view('admin/asignar_plan');
}

public function buscarPorCedula()
{
    $cedula = trim((string) ($this->request->getPost('cedula_buscar') ?? $this->request->getPost('cedula')));


    if ($cedula === '' || !ctype_digit($cedula)) {
        return redirect()->back()->with('mensaje', 'Ingresa una cédula válida.');
    }

    $db = \Config\Database::connect();

    $usuario = $db->table('datos_usuarios')
        ->select('id_usuario, cedula, nombre, apellido, correo, telefono')
        ->where('cedula', (int) $cedula)
        ->get()
        ->getRowArray();

    if (!$usuario) {
        return redirect()->back()->with('mensaje', 'No se encontró usuario con esa cédula.');
    }

    $planModel = new \App\Models\PlanModel();
    $planes = $planModel->where('estado', 'ACTIVO')->orderBy('precio', 'ASC')->findAll();

    $paqueteModel = new \App\Models\PaqueteClasesModel();
    $paqueteModel->marcarVencidosPorFecha((int)$usuario['id_usuario']); // ✅ marca vencidos automáticamente
    $paqueteActual = $paqueteModel->getUltimoPaquete((int)$usuario['id_usuario']);

    // ✅ Regla B: bloquear si hay paquete ACTIVO vigente con saldo
    $bloqueado = false;
    $paqueteActivoConSaldo = $paqueteModel->getActivoConSaldo((int)$usuario['id_usuario']);
    if ($paqueteActivoConSaldo) {
        $bloqueado = true;
    }

    return view('admin/asignar_plan', [
        'usuario'        => $usuario,
        'planes'         => $planes,
        'paqueteActual'  => $paqueteActual,
        'bloqueado'      => $bloqueado,
    ]);
}

public function asignarPlan()
{
    $idUsuario = (int) $this->request->getPost('id_usuario');
    $idPlan    = (int) $this->request->getPost('id_plan');

    if ($idUsuario <= 0 || $idPlan <= 0) {
        return redirect()->back()->with('mensaje', 'Datos inválidos.');
    }

    // Validar usuario existe
    $db = \Config\Database::connect();
    $existe = $db->table('datos_usuarios')
        ->select('id_usuario')
        ->where('id_usuario', $idUsuario)
        ->get()->getRowArray();

    if (!$existe) {
        return redirect()->back()->with('mensaje', 'El usuario no existe.');
    }

    // ✅ Validar plan ACTIVO por id_planes (PK real)
    $planModel = new \App\Models\PlanModel();
    $plan = $planModel->where('id_planes', $idPlan)
        ->where('estado', 'ACTIVO')
        ->first();

    if (!$plan) {
        return redirect()->back()->with('mensaje', 'Plan no válido o inactivo.');
    }

    $paqueteModel = new \App\Models\PaqueteClasesModel();

    // ✅ 1) Marcar vencidos
    $paqueteModel->marcarVencidosPorFecha($idUsuario);

    // ✅ 2) Bloquear si hay activo con saldo
    if ($paqueteModel->getActivoConSaldo($idUsuario)) {
        return redirect()->back()->with(
            'mensaje',
            'Este usuario ya tiene un paquete ACTIVO y vigente con saldo. No se puede asignar otro.'
        );
    }

    // ✅ 3) Crear paquete desde el plan
    $now   = \CodeIgniter\I18n\Time::now('America/Bogota');
    $vence = $now->addDays((int)($plan['duracion_dias'] ?? 30));

    $paqueteModel->insert([
        'id_usuario'        => $idUsuario,
        'total_clases'      => (int) $plan['total_clases'],
        'clases_restantes'  => (int) $plan['total_clases'],
        'fecha_inicio'      => $now->toDateTimeString(),
        'fecha_vencimiento' => $vence->toDateTimeString(),
        'estado'            => 'ACTIVO',
        'creado_por'        => session()->get('id_usuario'), // ✅ null si no hay sesión
    ]);

    return redirect()->to(base_url('admin/asignar_plan'))
        ->with('mensaje', '✅ Plan asignado y paquete creado correctamente.');
}

}
