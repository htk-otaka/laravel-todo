<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Folder;
use App\Http\Requests\CreateFolder;
use App\Http\Requests\EditFolder;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $folders = $user->folders();
        return view('folders/create', compact('folders'));
    }

    public function create(CreateFolder $request)
    {
        $folder = new Folder();
        $folder->title = $request->title;
        /** @var App\Models\User */
        $user = Auth::user();
        $user->folders()->save($folder);

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    public function showEditForm(int $id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($id);

        return view('folders/edit', [
            'folder_id' => $folder->id,
            'folder_title' => $folder->title,
        ]);
    }

    public function edit(int $id, EditFolder $request)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($id);

        $folder->title = $request->title;
        $folder->save();

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    public function showDeleteForm(int $id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($id);

        return view('folders/delete', [
            'folder_id' => $folder->id,
            'folder_title' => $folder->title,
        ]);
    }

    public function delete(int $id)
    {
        /** @var App\Models\User */
        $user = Auth::user();
        $folder = $user->folders()->findOrFail($id);

        $folder->tasks()->delete();
        $folder->delete();

        $folder = $user->folders()->first();

        if (is_null($folder)) {
            return redirect()->route('home');
        }

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
