<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileManagerController extends Controller
{
    protected $basePath;

    public function __construct()
    {
        // Set base path to parent directory of admin folder (project2 root)
        $this->basePath = realpath(base_path('..'));
    }

    public function index()
    {
        // List files and directories in the base path excluding the admin folder
        $files = File::allFiles($this->basePath);
        $filteredFiles = [];

        foreach ($files as $file) {
            if (strpos($file->getPathname(), $this->basePath . DIRECTORY_SEPARATOR . 'admin') === false) {
                $filteredFiles[] = $file->getRelativePathname();
            }
        }

        return view('filemanager.index', ['files' => $filteredFiles]);
    }

    public function show($filename)
    {
        $filePath = $this->basePath . DIRECTORY_SEPARATOR . $filename;

        if (!File::exists($filePath)) {
            abort(404);
        }

        $content = File::get($filePath);

        return view('filemanager.show', ['filename' => $filename, 'content' => $content]);
    }

    public function edit($filename)
    {
        $filePath = $this->basePath . DIRECTORY_SEPARATOR . $filename;

        if (!File::exists($filePath)) {
            abort(404);
        }

        $content = File::get($filePath);

        return view('filemanager.edit', ['filename' => $filename, 'content' => $content]);
    }

    public function update(Request $request, $filename)
    {
        $filePath = $this->basePath . DIRECTORY_SEPARATOR . $filename;

        if (!File::exists($filePath)) {
            abort(404);
        }

        $content = $request->input('content');
        File::put($filePath, $content);

        return redirect()->route('filemanager.show', ['filename' => $filename])->with('success', 'File updated successfully.');
    }

    public function destroy($filename)
    {
        $filePath = $this->basePath . DIRECTORY_SEPARATOR . $filename;

        if (!File::exists($filePath)) {
            abort(404);
        }

        File::delete($filePath);

        return redirect()->route('filemanager.index')->with('success', 'File deleted successfully.');
    }

    public function create()
    {
        return view('filemanager.create');
    }

    public function store(Request $request)
    {
        $filename = $request->input('filename');
        $content = $request->input('content');

        $filePath = $this->basePath . DIRECTORY_SEPARATOR . $filename;

        if (File::exists($filePath)) {
            return redirect()->route('filemanager.create')->withErrors(['filename' => 'File already exists.']);
        }

        File::put($filePath, $content);

        return redirect()->route('filemanager.index')->with('success', 'File created successfully.');
    }
}
