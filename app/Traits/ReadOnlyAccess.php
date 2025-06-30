<?php

namespace App\Traits;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

trait ReadOnlyAccess
{
    public function applyReadOnly()
    {
        if (backpack_user() && backpack_user()->can('read only')) {

            CRUD::denyAccess(['create', 'update', 'delete']);
			CRUD::allowAccess('list');

        }
    }
}
