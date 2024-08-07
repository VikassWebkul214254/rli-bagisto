<?php

namespace Webkul\BulkUpload\Http\Controllers\Admin;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Webkul\BulkUpload\Jobs\ProductUploadJob;
use Webkul\BulkUpload\Imports\DataGridImport;
use Webkul\BulkUpload\Jobs\ProductImageUploadingJob;
use Webkul\BulkUpload\Repositories\ImportProductRepository;
use Webkul\Attribute\Repositories\AttributeFamilyRepository;
use Webkul\BulkUpload\Helpers\ResultHelper;
use Webkul\BulkUpload\Repositories\BulkProductImporterRepository;

class UploadFileController extends Controller
{
    /**
     * @var array
     */
    protected $product = [];

    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected AttributeFamilyRepository $attributeFamilyRepository,
        protected ImportProductRepository $importProductRepository,
        protected BulkProductImporterRepository $bulkProductImporterRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $families = $this->attributeFamilyRepository->all();

        return view('bulkUpload::admin.bulk-upload.upload-files.index', compact('families'));
    }

    /**
     * Download sample files.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadSampleFile()
    {
        if (! empty(request()->download_sample)) {
            return response()->download(public_path('vendor/webkul/admin/assets/sample-files/' . request()->download_sample));
        }

        session()->flash('error', 'Product type is not available, Please select valid product type');

        return redirect()->route('admin.bulk-upload.upload-file.index');
    }

    /**
     * Get profiles on basis of attribute family
     *
     * @return array
     */
    public function getBulkProductImporter()
    {
        $dataFlowProfiles = $this->bulkProductImporterRepository->findByField('attribute_family_id', request()->attribute_family_id);

        return ['dataFlowProfiles' => $dataFlowProfiles];
    }

    /**
     * store import products for profile execution
     *
     * @return \Illuminate\Http\Response
     */
    public function storeProductsFile()
    {
        $request = request();

        $importerId = $request->bulk_product_importer_id;

        $validExtensions = ['csv', 'xls', 'xlsx'];

        $validImageExtensions = ['zip', 'rar'];

        // Validate the request
        $request->validate([
            'file_path'                => 'required',
            'image_path'               => 'mimetypes:application/zip|max:10000',
            'attribute_family_id'      => 'required',
            'bulk_product_importer_id' => 'required',
        ]);

        $importer = $this->bulkProductImporterRepository->find($importerId);

        if (empty($importer)) {
            session()->flash('error', trans('bulkUpload::app.admin.bulk-upload.messages.data-profile-not-selected'));

            return back();
        }

        $product = [
            'attribute_family_id'      => $request->attribute_family_id,
            'bulk_product_importer_id' => $importerId,
            'is_downloadable'          => $request->is_downloadable ? 1 : 0,
            'is_links_have_samples'    => $request->is_link_have_sample ? 1 : 0,
            'is_samples_available'     => $request->is_sample ? 1 : 0,
            'image_path'               => '',
            'file_path'                => '',
            'file_name'                => $request->file('file_path')->getClientOriginalName(),
        ];

        $fileStorePath = 'imported-products/admin';

        // Handle link files
        if ($request->hasFile('link_files')) {
            $linkFiles = $request->file('link_files');

            if (in_array($linkFiles->getClientOriginalExtension(), $validImageExtensions)) {
                $product['upload_link_files'] = $linkFiles->storeAs($fileStorePath . '/link-files', uniqid() . '.' . $linkFiles->getClientOriginalExtension());
            } else {
                session()->flash('error', trans('bulkUpload::app.admin.bulk-upload.messages.file-format-error'));

                return back();
            }
        }

        // Handle link sample files
        if ($request->is_link_have_sample
                    && $request->hasFile('link_sample_files')) {
            $linkSampleFiles = $request->file('link_sample_files');

            if (in_array($linkSampleFiles->getClientOriginalExtension(), $validImageExtensions)) {
                $product['upload_link_sample_files'] = $linkSampleFiles->storeAs($fileStorePath . '/link-sample-files', uniqid() . '.' . $linkSampleFiles->getClientOriginalExtension());
            } else {
                session()->flash('error', trans('bulkUpload::app.admin.bulk-upload.messages.file-format-error'));

                return back();
            }
        }

        // Handle sample files
        if ($request->is_sample
                    && $request->hasFile('sample_file')) {
            $sampleFile = $request->file('sample_file');

            if (in_array($sampleFile->getClientOriginalExtension(), $validImageExtensions)) {
                $product['upload_sample_files'] = $sampleFile->storeAs($fileStorePath . '/sample-file', uniqid() . '.' . $sampleFile->getClientOriginalExtension());
            } else {
                session()->flash('error', trans('bulkUpload::app.admin.bulk-upload.messages.file-format-error'));

                return back();
            }
        }

        // Handle image uploads
        if ($request->hasFile('image_path')) {
            $uploadedImage = request()->file('image_path');

            if (in_array($uploadedImage->getClientOriginalExtension(), $validImageExtensions)) {
                $product['image_path'] = $uploadedImage->storeAs($fileStorePath . '/images', uniqid() . '.' . $uploadedImage->getClientOriginalExtension());
            } else {
                session()->flash('error', trans('bulkUpload::app.admin.bulk-upload.messages.file-format-error'));

                return back();
            }
        }

        // Handle file uploads
        if ($request->hasFile('file_path')) {
            $uploadedFile = request()->file('file_path');

            if (in_array($uploadedFile->getClientOriginalExtension(), $validExtensions)) {
                $product['file_path'] = $uploadedFile->storeAs($fileStorePath . '/files', uniqid() . '.' . $uploadedFile->getClientOriginalExtension());
            } else {
                session()->flash('error', trans('bulkUpload::app.admin.bulk-upload.messages.file-format-error'));

                return back();
            }
        }

        $this->importProductRepository->create($product);

        session()->flash('success', trans('bulkUpload::app.admin.bulk-upload.messages.profile-saved'));

        return back();
    }

    /**
     * Display a run profiler page and get family by attribute family id.
     *
     * @return \Illuminate\View\View
     */
    public function getFamilyAttributesToUploadFile()
    {
        $uniqueAttributeFamilyIds = $this->importProductRepository
            ->distinct()
            ->pluck('attribute_family_id');

        $families = $this->attributeFamilyRepository->whereIn('id', $uniqueAttributeFamilyIds)->get();

        return view('bulkUpload::admin.bulk-upload.run-profile.index', compact('families'));
    }

    /**
     * Get profiles on basis of attribute family
     *
     * @return array
     */
    public function getProductImporter()
    {
        $dataFlowProfiles = $this->bulkProductImporterRepository->findByField('attribute_family_id', request()->attribute_family_id);

        $productImporter = $dataFlowProfiles->filter(function ($dataFlowProfile) {
            return $dataFlowProfile->import_product->isNotEmpty();
        });

        return ['dataFlowProfiles' => $productImporter];
    }

    /**
     * Delete product file from run profiler
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteProductFile()
    {
        try {
            $dataFlowProfile = $this->bulkProductImporterRepository->findOrFail(request()->bulk_product_importer_id);

            $dataFlowProfile->import_product()->where('id', request()->product_file_id)->delete();

            return ['importer_product_file' => $dataFlowProfile->import_product];

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case where the bulk_product_importer_id does not exist
            return response()->json(['error' => 'Data Flow Profile not found'], 404);
        }
    }

    /**
     * Read CSV file and upload bulk-product using Jobs
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function readCSVData()
    {
        $productFileRecord = $this->importProductRepository->where([
            'bulk_product_importer_id' => request()->bulk_product_importer_id,
            'id'                       => request()->product_file_id,
        ])->first();

        if (! $productFileRecord) {
            return response()->json([
                'error'   => true,
                'message' => 'Selected File not found.',
            ]);
        }

        $csvData = (new DataGridImport())->toArray($productFileRecord->file_path)[0];

        $csvImageData = (new DataGridImport())->toArray($productFileRecord->file_path)[2] ?? [];

        // Check booking type product is not supported
        if (! empty($csvData)) {
            foreach ($csvData as $data) {
                if ($data['type'] == 'booking') {
                    return response()->json([
                        'success' => false,
                        'message' => trans('bulkUpload::app.admin.bulk-upload.messages.product-not-supported'),
                    ]);
                }
            }
        }

        $countConfig = count(array_filter($csvData, function ($item) {
            return $item['type'] === 'configurable';
        }));

        $countCSV = ($countConfig > 0) ? $countConfig : count($csvData);

        if (! $countCSV) {
            // Handle the case when $countCSV is false (or any condition you need).
            return response()->json([
                'success' => false,
                'message' => 'No CSV Data to Import',
            ]);
        }

        $chunks = array_chunk($csvData, 100);

        /**
         * Deleting all result file.
         */
        app(ResultHelper::class)->removeAllFile();

        $chain[] = new ProductUploadJob($productFileRecord, $chunks, $countCSV);
        
        $chain[] = new ProductImageUploadingJob($csvImageData);

        Bus::chain($chain)->dispatch();

        return response()->json([
            'success' => true,
            'message' => 'CSV Product Successfully Imported',
        ]);
    }

    /**
     * Get error after bulk-product uploaded and return error file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUploaded()
    {
        $limit = request()->input('limit');

        $files = $this->importProductRepository->orderBy('id', 'desc')->limit($limit);

        return response()->json([
            'files' => $files,
        ]);
    }

    /**
     * Delete CSV file from run profiler page
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteCSV()
    {
        $import = $this->importProductRepository->findOrFail(request()->input('id'));

        try {
            $import->delete(request()->input('id'));

            Storage::delete($import->file_path);

            return response()->json(['message' => trans('bulkUpload::app.admin.bulk-upload.upload-files.delete-message')]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return response()->json(['message' => 'File not found'], 404);
    }

    /**
     * Get Uploaded and not uploaded product detail from session
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUploadedProductOrNotUploadedProduct()
    {
        $status = request()->status;
        $message = false;

        if (session()->has('completionMessage')) {
            $message = true;
            
            $status = false;
        }

        return response()->json(['status' => $status, 'success' => $message], 200);
    }


    /**
     * Get Final Result
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFinalResult()
    {
        /**
         * image_not_found
         * product_uploaded
         * product_not_upload.json
         */
        $imageNotUploaded = Storage::get('imported-products/admin/result/image_not_found.json');

        $productUploaded = Storage::get('imported-products/admin/result/product_uploaded.json');

        $productNotFound = Storage::get('imported-products/admin/result/product_not_upload.json');
        
        $data = [
            'image_not_found'  => [
                'data' => json_decode($imageNotUploaded),
                'url'  => Storage::url('imported-products/admin/result/image_not_found.json'),
            ],
            
            'product_uploaded' => [
                'data' => json_decode($productUploaded),
                'url'  => Storage::url('imported-products/admin/result/product_uploaded.json'),
            ],

            'product_not_upload' => [
                'data' => json_decode($productNotFound),
                'url'  => Storage::url('imported-products/admin/result/product_not_upload.json'),
            ],
        ];

        return response()->json($data, 200);
    }
}
