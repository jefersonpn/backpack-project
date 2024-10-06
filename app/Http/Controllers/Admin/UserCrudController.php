<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    // If not backpack user type == 3, redirect to home
    public function __construct()
{
    parent::__construct();

    // Apply the superadmin middleware to ensure only superadmins can access this controller
    $this->middleware(function ($request, $next) {
        if (backpack_auth()->guest() || !backpack_auth()->user()->isSuperAdmin()) {
            abort(404);
        }

        return $next($request);
    });
}

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;



    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // Set columns from db columns.

        // Remove the default type column added by setFromDb(), to add the custom type column
        CRUD::removeColumn('type');

        // Add a new type column with human-readable labels
        CRUD::addColumn([
            'name' => 'type',
            'label' => 'User Type',
            'type' => 'closure',
            'function' => function($entry) {
                switch ($entry->type) {
                    case '1':
                        return 'Superadmin';
                    case '2':
                        return 'Admin';
                    case '3':
                        return 'User';
                    default:
                        return 'Unknown';
                }
            },
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
        CRUD::setValidation(UserRequest::class);
        CRUD::setFromDb(); // Set fields from db columns.

        // Add the 'type' field to select from a list of user types.
        CRUD::addField([
            'name' => 'type',
            'label' => 'User Type',
            'type' => 'select_from_array',
            'options' => [
                '1' => 'Superadmin',
                '2' => 'Admin',
                '3' => 'User',
            ],
            'allows_null' => false,
            'default' => '3', // Default value if needed
        ]);

        // Remove the default 'type' field if the user is not a superadmin.
        if (!backpack_auth()->user()->isSuperAdmin()) {
            CRUD::removeField('type');
        }
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
        CRUD::setFromDb(); // Set fields from db columns.

        // To customize the columns in the show blade, i needed to remove the column type, but removing it, the created at and updated at
        // has been removed too i don't know why, so i added at the end.

        // Remove the default 'type' column added by setFromDb()
        CRUD::removeColumn('type');

        // Add a new 'type' column with human-readable labels
        CRUD::addColumn([
            'name' => 'type',
            'label' => 'User Type',
            'type' => 'text',
            'value' => function($entry) {
                switch ($entry->type) {
                    case '1':
                        return 'Superadmin';
                    case '2':
                        return 'Admin';
                    case '3':
                        return 'User';
                    default:
                        return 'Unknown';
                }
            },
        ]);

        // Adding the column Created_at
        CRUD::addColumn([
            'name' => 'created_at',
            'label' => 'Created At',
            'type' => 'datetime',
        ]);

        // Adding the column Updated_at
        CRUD::addColumn([
            'name' => 'updated_at',
            'label' => 'Updated At',
            'type' => 'datetime',
        ]);
    }

}
