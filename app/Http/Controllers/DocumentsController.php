<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use App\Repositories\ContractRepository;
use App\Repositories\DocumentRepository;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class DocumentsController
 * @package App\Http\Controllers
 */
class DocumentsController extends Controller
{

    const DOCUMENT_FILE_NAME_LENGTH = 16;

    /**
     * @var DocumentRepository
     */
    protected $documentRepository;


    /**
     * @var ContractRepository
     */
    protected $contractRepository;


    /**
     * @var ClientRepository
     */
    protected $clientRepository;


    /**
     * DocumentsController constructor.
     * @param DocumentRepository $documentRepository
     */
    public function __construct(
        DocumentRepository $documentRepository,
        ContractRepository $contractRepository,
        ClientRepository $clientRepository
    ) {
        $this->documentRepository = $documentRepository;
        $this->contractRepository = $contractRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Returns the document resource by id
     *
     * @param $contractId
     */
    public function getById($documentId) {
        $document = $this->documentRepository->find($documentId);

        if (! $document) {
            return;
        }

        //return response(Storage::get('contracts/1/JdsBetq8UY3aRXMd'), 200);

        $path = storage_path($document->getPath());

        $headers = array(
            'Content-Type' => $document->getMimeType(),
            'Content-Disposition' => 'inline;filename="'. $document->getName() . '"'
        );

        //return Response::download($path, $document->getName(), $headers);

        //return Response::make(file_get_contents($path), 200, $headers);

        return Response::file($path, $headers);
    }


    /**
     * Returns the documents by contract id
     *
     * @param $contractId
     */
    public function getByContractId($contractId) {
        $contract = $this->contractRepository->find($contractId);

        return $contract->getDocuments();
    }


    /**
     * Saves the documents by client id
     *
     * @param $request
     * @param $contractId
     */
    public function saveByContractId(Request $request, $contractId) {
        $files = $request->allFiles();
        $contract = $this->contractRepository->find($contractId);

        $newName = str_random(self::DOCUMENT_FILE_NAME_LENGTH);

        $documentIds = array();

        /**
         * @var $file \Illuminate\Http\UploadedFile
         */
        foreach ($files as $file) {
            if ($file->isValid()) {

                try {
                    $file->move(storage_path($contract->getDocumentPath()), $newName);

                    // Save document
                    $documentId = $this->documentRepository->create(array(
                        "contract_id" => $contractId,
                        "name" => $file->getClientOriginalName(),
                        "mime_type" => $file->getClientMimeType(),
                        "size" => $file->getClientSize(),
                        "path" => $contract->getDocumentPath() . $newName,
                        "created_at" => new \DateTime()
                    ));

                    array_push($documentIds, $documentId);

                } catch (FileException $e) {
                    return Response::json(array('status' => 'error'), 400);
                }
            }
        }

        return Response::json(array(
            'status' => 'success',
            'documentIds' => $documentIds
        ), 200);
    }

    /**
     * Returns the documents by contract id
     *
     * @param $request
     * @param $clientId
     */
    public function getByClientId($clientId) {
        $contract = $this->clientRepository->find($clientId);

        return $contract->getDocuments();
    }


    /**
     * Saves the document by client id
     *
     * @param $request
     * @param $clientId
     */
    public function saveByClientId(Request $request, $clientId) {
        $files = $request->allFiles();
        $contract = $this->clientRepository->find($clientId);

        $newName = str_random(self::DOCUMENT_FILE_NAME_LENGTH);

        $documentIds = array();

        /**
         * @var $file \Illuminate\Http\UploadedFile
         */
        foreach ($files as $file) {
            if ($file->isValid()) {

                try {
                    $file->move(storage_path($contract->getDocumentPath()), $newName);

                    // Save document
                    $documentId = $this->documentRepository->create(array(
                        "client_id" => $clientId,
                        "name" => $file->getClientOriginalName(),
                        "mime_type" => $file->getClientMimeType(),
                        "size" => $file->getClientSize(),
                        "path" => $contract->getDocumentPath() . $newName,
                        "created_at" => new \DateTime()
                    ));

                    array_push($documentIds, $documentId);

                } catch (FileException $e) {
                    return Response::json(array('status' => 'error'), 400);
                }
            }
        }

        return Response::json(array(
            'status' => 'success',
            'documentIds' => $documentIds
        ), 200);
    }


    /**
     * Deletes a document
     *
     *
     * @param $documentId
     */
    public function delete($documentId) {
        $document = $this->documentRepository->find($documentId);

        if (! $document) {
            return;
        }

        // Delete the document physically
        Storage::delete($document->getPath());

        // Delete from db
        $this->documentRepository->delete($documentId);
    }
}