<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected $messages = [
        'save_success' => 'Data saved successfully',
        'save_failed' => 'Failed to save data',
        'update_success' => 'Data updated successfully',
        'update_failed' => 'Failed to update data',
        'delete_success' => 'Data deleted successfully',
        'delete_failed' => 'Failed to delete data',
        'archive_success' => 'Data archived successfully',
        'archive_failed' => 'Failed to archive data',
        'not_found' => 'Data not found',
        'unauthorized' => 'You are not authorized to perform this action',
        'validation_error' => 'Validation error occurred',
    ];
}
