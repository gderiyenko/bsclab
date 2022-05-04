<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilesStoreRequest;
use App\Services\FileService;
use App\Services\FirmService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * @var FileService
     */
    private $file;
    /**
     * @var FirmService
     */
    private $firms;

    public function __construct(FileService $file, FirmService $firms)
    {
        $this->file = $file;
        $this->firms = $firms;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param FilesStoreRequest $request
     * @return JsonResponse
     */
    public function valid(FilesStoreRequest $request): JsonResponse
    {
        return response()->json('The file successfully validated');
    }

    public function store(FilesStoreRequest $request): JsonResponse
    {
        $connect = Storage::disk('google');

        foreach ($request->all() as $title => $file) {
            try {
                $googleFileName = $connect->putFile('', $file);
                $meta_path = $connect->getMetadata($googleFileName)['path'];
                $url = $connect->url($googleFileName);
                $visibility = $connect->setVisibility($googleFileName, 'private');

                $this->file->create([
                    'firm_id' => $request->get('firm_id'),
                    'title' => $title,
                    'meta_path' => $meta_path,
                    'url' => $url,
                ]);
            } catch (Exception $e) {
                continue;
            }
        }

        return response()->json('The file successfully upload');
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $files = $this->file->getAllByFirmId($id);

        return response()->json($files);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $file = $this->file->findById($id);
        $connect = Storage::disk('google');
        $connect->delete($file->meta_path);

        $this->file->destroy($id);

        return response()->json('The file successfully deleted');
    }
}
