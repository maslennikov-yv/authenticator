<?php

namespace Maslennikov\Authorizator\Traits;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Maslennikov\Authorizator\Models\Role;
use Maslennikov\Authorizator\Rules\CircularReferences;

trait RoleResource
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $this->authorize('roles.viewAny');
        return Role::orderBy('slug', 'desc')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $this->authorize('roles.create');
        $validated = $request->validate([
            'slug' => 'required|string|unique:roles',
            'children' => [
                'array',
                new CircularReferences(),
            ],
            'permissions' => 'array',
        ]);
        return Role::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Role $role
     * @return Response
     */
    public function show(Request $request, Role $role): Response
    {
        $this->authorize('roles.view', [$role]);
        return $role;
    }

    /**
     * Update the specified resource from storage.
     *
     * @param Request $request
     * @param Role $role
     * @return bool|null
     */
    public function update(Request $request, Role $role): ?bool
    {
        $this->authorize('roles.update', [$role]);
        $validated = $request->validate(
            [
                'slug' => [
                    'required',
                    'string',
                    Rule::unique('roles', 'slug')->ignore($role),
                ],
                'children' => [
                    'array',
                    new CircularReferences(),
                ],
                'permissions' => 'array',
            ]);
        return $role->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return bool|null
     */
    public function destroy(Role $role): ?bool
    {
        $this->authorize('roles.delete', [$role]);
        return $role->delete();
    }

}
