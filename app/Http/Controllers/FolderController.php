<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Folder;
use App\Http\Requests\CreateFolder;
use App\Http\Requests\EditFolder;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        try {
            /** @var App\Models\User */
            $user = Auth::user();
            $folders = $user->folders();

            return view('folders/create', compact('folders'));
        } catch (\Throwable $e) {
            Log::error('Error FolderController in showCreateForm: ' . $e->getMessage());
        }
    }

    public function create(CreateFolder $request)
    {
        try {
            $folder = new Folder();
            $folder->title = $request->title;
            /** @var App\Models\User */
            $user = Auth::user();
            $user->folders()->save($folder);

            return redirect()->route('tasks.index', [
                'folder' => $folder->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error FolderController in create: ' . $e->getMessage());
        }
    }

    public function showEditForm(Folder $folder)
    {
        try {
            /** @var App\Models\User */
            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);

            return view('folders/edit', [
                'folder_id' => $folder->id,
                'folder_title' => $folder->title,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error FolderController in showEditForm: ' . $e->getMessage());
        }
    }

    public function edit(Folder $folder, EditFolder $request)
    {
        try {
            /** @var App\Models\User */
            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);

            $folder->title = $request->title;
            $folder->save();

            return redirect()->route('tasks.index', [
                'folder' => $folder->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error FolderController in edit: '. $e->getMessage());
        }
    }

    public function showDeleteForm(Folder $folder)
    {
        try {
            /** @var App\Models\User */
            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);

            return view('folders/delete', [
                'folder_id' => $folder->id,
                'folder_title' => $folder->title,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error FolderController in showDeleteForm: '. $e->getMessage());
        }
    }

    public function delete(Folder $folder)
    {
        try {
            /** @var App\Models\User */
            $user = Auth::user();
            $folder = $user->folders()->findOrFail($folder->id);

            $folder = DB::transaction(function() use ($folder) {
                $folder->tasks()->delete();
                $folder->delete();
                return $folder;
            });

            $folder = $user->folders()->first();

            if (is_null($folder)) {
                return redirect()->route('home');
            }

            return redirect()->route('tasks.index', [
                'folder' => $folder->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error FolderController in delete: '. $e->getMessage());
        }
    }
}
