<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\User;
class GroupController extends Controller
{
    public function index()
    {
        // Listar todos los grupos
        $groups = Group::with('members.user')->get();
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        // Mostrar formulario para crear un nuevo grupo
        return view('groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Crear un nuevo grupo
        Group::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('groups.index')->with('success', 'Grupo creado exitosamente.');
    }

    public function edit($id)
    {
        // Obtener el grupo y sus miembros
        $group = Group::with('members.user')->findOrFail($id);
        $users = User::all(); // Lista de usuarios para agregar nuevos miembros

        return view('groups.edit', compact('group', 'users'));
    }

    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Actualizar el grupo
        $group->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('groups.index')->with('success', 'Grupo actualizado exitosamente.');
    }

    public function destroy($id)
    {
        // Eliminar el grupo y sus relaciones
        $group = Group::findOrFail($id);
        $group->delete();

        return redirect()->route('groups.index')->with('success', 'Grupo eliminado exitosamente.');
    }

    public function manageMembers($id)
    {
        // Gestionar miembros del grupo
        $group = Group::with('members.user')->findOrFail($id);
        $users = User::all(); // Lista de usuarios para agregar nuevos miembros

        return view('groups.manage_members', compact('group', 'users'));
    }

    public function addMember(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:student,teacher',
        ]);

        // Agregar un nuevo miembro al grupo
        $group->members()->create([
            'user_id' => $request->user_id,
            'role' => $request->role,
        ]);

        return redirect()->route('groups.manage_members', $id)->with('success', 'Miembro agregado exitosamente.');
    }

    public function removeMember($groupId, $memberId)
    {
        $group = Group::findOrFail($groupId);

        // Eliminar miembro del grupo
        $group->members()->where('id', $memberId)->delete();

        return redirect()->route('groups.manage_members', $groupId)->with('success', 'Miembro eliminado exitosamente.');
    }
}
