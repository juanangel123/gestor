<?php

namespace App\Http\Controllers;

use App\Repositories\AddressRepository;
use App\Repositories\ClientRepository;
use App\Repositories\ContractRepository;
use App\Repositories\ProvinceRepository;
use App\Models\ClientType;
use Illuminate\Http\Request;

/**
 * Class ClientsController
 * @package App\Http\Controllers
 */
class ClientsController extends Controller
{

    /**
     * @var ClientRepository
     */
    private $clientRepository;


    /**
     * @var AddressRepository
     */
    private $addressRepository;


    /**
     * @var ProvinceRepository
     */
    private $provinceRepository;


    /**
     * @var ContractRepository
     */
    private $contractRepository;


    /**
     * ClientsController constructor.
     * @param ClientRepository $clientRepository
     * @param AddressRepository $addressRepository
     * @param ProvinceRepository $provinceRepository
     * @param ContractRepository $contractRepository
     */
    public function __construct(
        ClientRepository $clientRepository,
        AddressRepository $addressRepository,
        ProvinceRepository $provinceRepository,
        ContractRepository $contractRepository) {
        $this->clientRepository = $clientRepository;
        $this->addressRepository = $addressRepository;
        $this->provinceRepository = $provinceRepository;
        $this->contractRepository = $contractRepository;


        //$this->middleware('auth');
    }


    /**
     * Show the client list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        // Get all the clients stored
        $clients = $this->clientRepository->all();

        // Pass to the view
        return view(
            'clients'
        )->with('clients', $clients);
    }


    /**
     * Shows the client creation page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $clientTypes = ClientType::toArray();
        $provinces =  $this->provinceRepository->all();

        return view(
            'client',
            [
                'clientTypes' => $clientTypes,
                'provinces' => $provinces
            ]
        );
    }


    /**
     * Shows the client edition page
     *
     * @param $clientId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($clientId) {
        $client = $this->clientRepository->find($clientId);
        $clientTypes = ClientType::toArray();
        $clientContracts = $this->contractRepository->findBy('client_id', $clientId);
        $provinces = $this->provinceRepository->all();

        return view(
            'client',
            [
                'client' => $client,
                'clientTypes' => $clientTypes,
                'clientContracts' => $clientContracts,
                'provinces' => $provinces
            ]
        );
    }


    /**
     * Saves or updates client and goes to the listing
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function save(Request $request) {
        $clientId = $request->get('id');

        if ($clientId) {
            $client = $this->clientRepository->find($clientId);

            // Update / create address
            if ($request->get('address-line')) {
                if (! $client->getAddress()) {
                    // Create
                    $addressId = $this->addressRepository->create(array(
                        'line' =>  $request->get('address-line'),
                        'postcode' => $request->get('address-post-code'),
                        'province_id' => $request->get('address-province'),
                        'locality' => $request->get('address-locality'),
                        'created_at' => new \DateTime()
                    ));
                } else {
                    // Update
                    $this->addressRepository->update(array(
                        'line' =>  $request->get('address-line'),
                        'postcode' => $request->get('address-post-code'),
                        'province_id' => $request->get('address-province'),
                        'locality' => $request->get('address-locality'),
                        'created_at' => $client->getAddress()->created_at
                    ), $client->getAddress()->getId());

                    $addressId = $client->getAddress()->getId();
                }
            } else {
                $addressId = false;
            }

            // Update client
            $clientData = array(
                'name' => $request->get('name'),
                'telephone' => $request->get('telephone'),
                'mobile' => $request->get('mobile'),
                'email' => $request->get('email'),
                'client_type' => $request->get('client-type'),
                'vat_id' => $request->get('vat-id'),
                'created_at' => $client->created_at
            );

            if ($addressId) {
                $clientData['address_id'] = $addressId;
            }

            $this->clientRepository->update($clientData, $clientId);
        } else {
            // Check the email is not used
            $clientsWithSameEmail = $this->clientRepository->findBy('email', $request->get('email'));

            if (count($clientsWithSameEmail) > 0) {
                return redirect('clients/create')->withErrors(['El cliente ' . $request->get('email') . ' ya existe.']);
                //return redirect('clients/edit/' . $client->getId());
            }

            // Create address
            if ($request->get('address-line')) {
                $addressId = $this->addressRepository->create(array(
                    'line' =>  $request->get('address-line'),
                    'postcode' => $request->get('address-post-code'),
                    'province_id' => $request->get('address-province'),
                    'locality' => $request->get('address-locality'),
                    'created_at' => new \DateTime()
                ));
            } else {
                $addressId = false;
            }

            // Create
            $clientData = array(
                'name' => $request->get('name'),
                'telephone' => $request->get('telephone'),
                'mobile' => $request->get('mobile'),
                'email' => $request->get('email'),
                'client_type' => $request->get('client-type'),
                'vat_id' => $request->get('vat-id'),
                'created_at' => new \DateTime()
            );

            if ($addressId) {
                $clientData['address_id'] = $addressId;
            }

            $clientId = $this->clientRepository->create($clientData);
        }

        return redirect('clients/edit/' . $clientId);
    }


    /**
     * Deletes a client
     *
     * @param $clientId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete($clientId) {
        $client = $this->clientRepository->find($clientId);

        // Delete his address
        if ($client->getAddress()) {
            $this->addressRepository->delete($client->getAddress()->getId());
        }

        // Delete all his contracts
        $contracts = $this->contractRepository->findBy('client_id', $clientId);

        foreach ($contracts as $contract) {
            $this->contractRepository->delete($contract->getId());
        }

        // Delete the client
        $this->clientRepository->delete($clientId);

        return redirect('clients');
    }
}
