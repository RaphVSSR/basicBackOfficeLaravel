<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticlesRequest;
use App\Traits\ReadOnlyAccess;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Illuminate\Http\Request;

/**
 * Class ArticlesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ArticlesCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Articles::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/articles');
        CRUD::setEntityNameStrings('article', 'articles');
        CRUD::setOperationSetting('responsiveTable', false);
        
        $this->applyReadOnly();
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

        CRUD::removeColumn("categorie_id");

        CRUD::addColumn([
            'label'     => "Catégorie",
            'type'      => 'text',
            'name'      => 'categorie.name',
            'entity'    => 'categorie',
            'attribute' => 'name',
            'model'     => "App\Models\Categories",
        ]);

        CRUD::column('description')->wrapper([
            'element' => 'p',
            'style' => 'white-space: normal; word-break: break-word;',
        ]);

        CRUD::column('image_src')->wrapper([
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
        CRUD::setValidation(ArticlesRequest::class);     

        Widget::add([
            'type' => 'view',
            'view' => 'vendor.backpack.ui.inc.category_modal',
            'stack'   => 'after_content',
        ]);

        Widget::add([
            'type' => 'view',
            'view' => 'vendor.backpack.ui.inc.image_dropzone',
            'stack' => 'after_content',
        ]);   

        CRUD::addField([
            'name' => 'image_src',
            'type' => 'upload',
            'withFiles' => [
                'disk' => 'public',
                'path' => 'images',
            ],
        ]);           
        
        
        // Ajouter les champs nécessaires manuellement
        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Name']);
        
        // Champ description avec éditeur riche Summernote
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
        
        CRUD::addField(['name' => 'price', 'type' => 'number', 'label' => 'Price']);

        // Champ de sélection de la catégorie avec bouton d'ajout
        CRUD::addField([
            'label'     => "Category",
            'type'      => 'select',
            'name'      => 'categorie_id',
            'entity'    => 'categorie',
            'attribute' => 'name',
            'model'     => "App\Models\Categories",
            'wrapper'   => [
                'class' => 'form-group col-md-12',
            ],
        ]);

        // Bouton d'ajout rapide de catégorie
        CRUD::addField([
            'name' => 'category_quick_add',
            'type' => 'custom_html',
            'value' => '

                <script>

                    function toggleModal(){

                        const modal = document.getElementById("categoryModal");

                        modal.classList.toggle("!hidden");
                		document.body.classList.toggle("overflow-hidden");

                    }

                </script>

                <button type="button" id="openCategoryModal" class="btn btn-sm btn-primary" onClick="toggleModal()">
                    Add category
                </button>
            ',
        ]);
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

    protected function setupShowOperation()
    {
        CRUD::setFromDb();
        CRUD::removeColumn('categorie_id');

        CRUD::addColumn([
            'name'     => 'categorie.name',
            'type'     => 'text',
            'label'    => 'Catégorie',
        ]);
    }

    public function quickAdd(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'required|string|max:1000',
            ]);

            $category = \App\Models\Categories::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'ajout de la catégorie: ' . $e->getMessage(),
            ], 500);
        }
    }
}