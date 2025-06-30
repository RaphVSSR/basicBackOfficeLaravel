<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoriesRequest;
use App\Traits\ReadOnlyAccess;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class CategoriesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoriesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ReadOnlyAccess;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        $this->applyReadOnly();
        CRUD::setModel(\App\Models\Categories::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/categories');
        CRUD::setEntityNameStrings('categories', 'categories');
        CRUD::setOperationSetting('responsiveTable', false);  
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb();

        CRUD::column('description')->wrapper([
            'element' => 'p',
            'style' => 'white-space: normal; word-break: break-word;',
        ]);
    }


    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoriesRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::addField([
            'name' => 'description',
            'type' => 'summernote',
            'label' => 'Description',
            'options' => [
                'height' => 200,
                'toolbar' => [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            ]
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation(){

        CRUD::setFromDb();

        CRUD::addColumn([
            'name' => 'created_at',
            'type' => 'datetime',
            'label' => 'Created at',
        ]);
        CRUD::addColumn([
            'name' => 'updated_at',
            'type' => 'datetime',
            'label' => 'Modified at',
        ]);
    }

    public function quickAdd(Request $request)
    {
        try {
            \Log::info('Tentative d\'ajout de catégorie', ['request' => $request->all()]);

            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'required|string|max:1000', // Ajout validation description
            ]);

            $category = \App\Models\Categories::create([
                'name' => $request->name,
                'description' => $request->description, // Ajout de la description
            ]);

            \Log::info('Catégorie créée avec succès', ['category' => $category]);

            return response()->json([
                'success' => true,
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description, // Ajout si tu veux la renvoyer
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erreur de validation', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'ajout de la catégorie', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'ajout de la catégorie: ' . $e->getMessage(),
            ], 500);
        }
    }


}
